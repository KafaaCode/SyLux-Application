<x-guest-layout :title="'إنشاء حساب جديد'" :subtitle="'انضم إلى عائلةSyLux'">
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div class="form-group">
            <label for="name" class="form-label">الاسم الكامل</label>
            <input id="name" class="form-input" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" placeholder="أدخل اسمك الكامل" />
            @error('name')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Email Address -->
        <div class="form-group">
            <label for="email" class="form-label">البريد الإلكتروني</label>
            <input id="email" class="form-input" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" placeholder="example@domain.com" />
            @error('email')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Password -->
        <div class="form-group">
            <label for="password" class="form-label">كلمة المرور</label>
            <input id="password" class="form-input" type="password" name="password" required autocomplete="new-password" placeholder="أدخل كلمة المرور" />
            @error('password')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <!-- Confirm Password -->
        <div class="form-group">
            <label for="password_confirmation" class="form-label">تأكيد كلمة المرور</label>
            <input id="password_confirmation" class="form-input" type="password" name="password_confirmation" required autocomplete="new-password" placeholder="أعد إدخال كلمة المرور" />
            @error('password_confirmation')
                <span class="error-message">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-primary">
            إنشاء حساب جديد
        </button>

        <div class="auth-links">
            <a href="{{ route('login') }}" class="auth-link">
                لديك حساب بالفعل؟ سجل الدخول
            </a>
        </div>
</x-guest-layout>
