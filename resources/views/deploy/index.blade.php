<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Deploy Console</title>
    <style>
        * { box-sizing: border-box; }
        body { font-family: system-ui, sans-serif; background: #1a1a2e; color: #eee; margin: 0; padding: 2rem; }
        .container { max-width: 720px; margin: 0 auto; }
        h1 { color: #B79C6D; font-size: 1.4rem; margin-bottom: .25rem; }
        .subtitle { color: #888; font-size: .85rem; margin-bottom: 1.5rem; }
        .alert { padding: .75rem 1rem; border-radius: 6px; margin-bottom: 1rem; font-size: .9rem; }
        .alert-success { background: #1b4332; border: 1px solid #40916c; }
        .alert-error { background: #3d0000; border: 1px solid #c0392b; }
        .cmd-card { background: #16213e; border: 1px solid #2a2a4a; border-radius: 8px; padding: 1rem; margin-bottom: .75rem; display: flex; align-items: center; justify-content: space-between; gap: 1rem; }
        .cmd-card.dangerous { border-color: #c0392b; }
        .cmd-info strong { display: block; margin-bottom: .2rem; }
        .cmd-info small { color: #888; font-family: monospace; font-size: .78rem; }
        button { background: #B79C6D; color: #1a1a2e; border: none; padding: .5rem 1.2rem; border-radius: 5px; cursor: pointer; font-weight: bold; white-space: nowrap; }
        button.danger { background: #c0392b; color: #fff; }
        button:hover { opacity: .85; }
        pre.output { background: #0d0d1a; border: 1px solid #2a2a4a; border-radius: 6px; padding: 1rem; font-size: .8rem; overflow-x: auto; white-space: pre-wrap; color: #a8dadc; margin-top: 1rem; }
        .badge { font-size: .7rem; background: #c0392b; color: #fff; padding: 2px 6px; border-radius: 3px; margin-right: 6px; }
    </style>
</head>
<body>
<div class="container">
    <h1>لوحة تنفيذ الأوامر</h1>
    <p class="subtitle">SyLux Deploy Console — أوامر مسموحة فقط</p>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif
    @if(session('output'))
        <pre class="output">{{ session('output') }}</pre>
    @endif

    @foreach($commands as $key => $cmd)
        <div class="cmd-card {{ !empty($cmd['dangerous']) ? 'dangerous' : '' }}">
            <div class="cmd-info">
                <strong>
                    @if(!empty($cmd['dangerous']))<span class="badge">خطير</span>@endif
                    {{ $cmd['label'] }}
                </strong>
                <small>{{ $cmd['description'] }}</small>
            </div>
            <form method="POST" action="{{ route('deploy.run', $token) }}">
                @csrf
                <input type="hidden" name="command" value="{{ $key }}">
                @if(!empty($cmd['dangerous']))
                    <input type="hidden" name="confirm" value="yes">
                    <button type="submit" class="danger" onclick="return confirm('تحذير: هذا الأمر سيحذف كل البيانات! هل أنت متأكد؟')">تنفيذ</button>
                @else
                    <button type="submit">تنفيذ</button>
                @endif
            </form>
        </div>
    @endforeach
</div>
</body>
</html>
