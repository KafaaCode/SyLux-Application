
<x-guest-layout :title="'تسجيل الدخول'" :subtitle="'مرحباً بك مرة أخرى'">
    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="example@domain.com" />
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">كلمة المرور</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="current-password" placeholder="أدخل كلمة المرور" />
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Remember Me -->
        <div class="form-group">
            <label class="form-label">
                <input type="checkbox" name="remember" style="margin-left: 8px;">
                تذكرني
            </label>
        </div>

        <button type="submit" class="btn-primary">
            تسجيل الدخول
        </button>

        <div class="auth-links">
            <a href="{{ route('register') }}" class="auth-link">
                ليس لديك حساب؟ سجل الآن
            </a>
        </div>
</x-guest-layout>