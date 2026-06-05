<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class StorageLinker
{
    public function run(): string
    {
        $target = storage_path('app/public');
        $link = public_path('storage');

        if (!File::isDirectory($target)) {
            File::makeDirectory($target, 0755, true);
        }

        $targetReal = realpath($target);

        if ($this->linkPointsTo($link, $targetReal)) {
            return "الرابط موجود ويعمل:\n{$link} → {$targetReal}";
        }

        $this->removeLinkPath($link);

        if (function_exists('symlink')) {
            try {
                if (@symlink($target, $link) && $this->linkPointsTo($link, $targetReal)) {
                    return "تم إنشاء symlink بنجاح:\n{$link} → {$target}";
                }
            } catch (\Throwable) {
                // Fall through to htaccess alternative
            }
        }

        return $this->createHtaccessFallback($target, $link);
    }

    private function linkPointsTo(string $link, ?string $targetReal): bool
    {
        if (!$targetReal || !file_exists($link)) {
            return false;
        }

        $linkReal = realpath($link);

        return $linkReal && $linkReal === $targetReal;
    }

    private function createHtaccessFallback(string $target, string $link): string
    {
        $messages = ['symlink() غير متاح على هذا السيرفر — تم تفعيل البديل عبر .htaccess.'];

        $this->removeLinkPath($link);

        if (!is_dir($link)) {
            @mkdir($link, 0755, true);
        }

        $storageHtaccess = <<<'HTACCESS'
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /storage/
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ ../../storage/app/public/$1 [L]
</IfModule>
HTACCESS;

        File::put($link . DIRECTORY_SEPARATOR . '.htaccess', $storageHtaccess);
        $messages[] = 'تم إنشاء: public/storage/.htaccess';

        $this->ensurePublicHtaccessRule();

        $messages[] = 'تم تحديث: public/.htaccess';
        $messages[] = "مجلد الملفات: {$target}";

        return implode("\n", $messages);
    }

    private function ensurePublicHtaccessRule(): void
    {
        $htaccessPath = public_path('.htaccess');
        $markerBegin = '# BEGIN SyLux Storage Fallback';

        if (File::exists($htaccessPath) && str_contains(File::get($htaccessPath), $markerBegin)) {
            return;
        }

        $rules = <<<'RULES'

# BEGIN SyLux Storage Fallback
<IfModule mod_rewrite.c>
    RewriteCond %{REQUEST_URI} ^/storage/(.+)$
    RewriteCond %{DOCUMENT_ROOT}/../storage/app/public/%1 -f
    RewriteRule ^storage/(.+)$ ../storage/app/public/$1 [L]
</IfModule>
# END SyLux Storage Fallback
RULES;

        $content = File::exists($htaccessPath) ? File::get($htaccessPath) : '';
        $insertBefore = 'RewriteRule ^ index.php';

        if (str_contains($content, $insertBefore)) {
            $content = str_replace($insertBefore, ltrim($rules) . "\n\n    " . $insertBefore, $content);
        } else {
            $content .= $rules;
        }

        File::put($htaccessPath, $content);
    }

    private function removeLinkPath(string $path): void
    {
        if (!file_exists($path) && !is_link($path)) {
            return;
        }

        if (is_link($path)) {
            @unlink($path);
            return;
        }

        if (is_dir($path)) {
            // Windows junction / symlink directory
            if (@readlink($path) !== false) {
                @rmdir($path);
                return;
            }

            // Fallback storage directory (only contains .htaccess)
            if (File::exists($path . '/.htaccess')) {
                @unlink($path . '/.htaccess');
            }

            @rmdir($path);
            return;
        }

        @unlink($path);
    }
}
