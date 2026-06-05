<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class DeployController extends Controller
{
    public function index(string $token)
    {
        return view('deploy.index', [
            'token' => $token,
            'commands' => config('deploy.commands', []),
        ]);
    }

    public function run(Request $request, string $token)
    {
        $commands = config('deploy.commands', []);
        $key = $request->input('command');

        if (!isset($commands[$key])) {
            return back()->with('error', 'الأمر غير مسموح.');
        }

        $definition = $commands[$key];

        if ($definition['dangerous'] && $request->input('confirm') !== 'yes') {
            return back()->with('error', 'يجب تأكيد الأوامر الخطرة قبل التنفيذ.');
        }

        try {
            $exitCode = Artisan::call(
                $definition['command'],
                $definition['parameters'] ?? []
            );

            $output = trim(Artisan::output());

            return back()->with('success', "تم التنفيذ بنجاح (exit: {$exitCode})")
                ->with('output', $output);
        } catch (\Throwable $e) {
            return back()->with('error', 'فشل التنفيذ: ' . $e->getMessage());
        }
    }
}
