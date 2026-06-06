<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class StorageLinker
{
    private const UPLOAD_DIRS = ['categories', 'products', 'sections'];

    public function run(): string
    {
        $publicStorage = public_path('storage');
        $legacyStorage = storage_path('app/public');
        $messages = [];

        $this->preparePublicStorageDirectory($publicStorage);

        foreach (self::UPLOAD_DIRS as $dir) {
            File::ensureDirectoryExists($publicStorage . DIRECTORY_SEPARATOR . $dir, 0755);
        }

        $migrated = $this->migrateLegacyFiles($legacyStorage, $publicStorage);
        if ($migrated > 0) {
            $messages[] = "تم نقل {$migrated} ملف من storage/app/public إلى public/storage";
        }

        $this->cleanupHtaccessFallback($publicStorage);

        $messages[] = 'وضع التخزين: مباشر في public/storage (بدون symlink وبدون .htaccess)';
        $messages[] = "المسار: {$publicStorage}";
        $messages[] = 'الصور تُخدم كملفات ثابتة عبر /storage/...';

        return implode("\n", $messages);
    }

    private function preparePublicStorageDirectory(string $publicStorage): void
    {
        if ($this->isReparsePoint($publicStorage)) {
            $this->removeReparsePoint($publicStorage);
        }

        if (File::exists($publicStorage . '/.htaccess')) {
            File::delete($publicStorage . '/.htaccess');
        }

        File::ensureDirectoryExists($publicStorage, 0755);
    }

    private function migrateLegacyFiles(string $legacyStorage, string $publicStorage): int
    {
        if (!File::isDirectory($legacyStorage)) {
            return 0;
        }

        $count = 0;

        foreach (File::allFiles($legacyStorage) as $file) {
            $relativePath = $file->getRelativePathname();
            $destination = $publicStorage . DIRECTORY_SEPARATOR . $relativePath;

            if (File::exists($destination)) {
                continue;
            }

            File::ensureDirectoryExists(dirname($destination), 0755);
            File::copy($file->getPathname(), $destination);
            $count++;
        }

        return $count;
    }

    private function cleanupHtaccessFallback(string $publicStorage): void
    {
        $mainHtaccess = public_path('.htaccess');
        $markerBegin = '# BEGIN SyLux Storage Fallback';
        $markerEnd = '# END SyLux Storage Fallback';

        if (File::exists($mainHtaccess)) {
            $content = File::get($mainHtaccess);
            if (str_contains($content, $markerBegin)) {
                $pattern = '/' . preg_quote($markerBegin, '/') . '.*?' . preg_quote($markerEnd, '/') . '\s*/s';
                File::put($mainHtaccess, preg_replace($pattern, '', $content));
            }
        }

        if (File::exists($publicStorage . '/.htaccess')) {
            File::delete($publicStorage . '/.htaccess');
        }
    }

    private function isReparsePoint(string $path): bool
    {
        if (!file_exists($path)) {
            return false;
        }

        return is_link($path) || @readlink($path) !== false;
    }

    private function removeReparsePoint(string $path): void
    {
        if (is_link($path)) {
            @unlink($path);
            return;
        }

        if (is_dir($path)) {
            @rmdir($path);
        }
    }
}
