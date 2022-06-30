<div class="form_wrap">
    <!-- Session Status -->
    <x-auth-session-status class="mb-4" :status="session('status')" />
    <!-- Validation Errors -->
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <form method="POST" id="loginForm" onsubmit="return false">
    @csrf
    <!-- Email Address -->
        <div class="form_block">
            <label class="form_lable" for="email">Email</label>
            <input class="form_input @error('email') is-invalid @enderror" id="email" type="email" name="email" :value="old('email')" required="required" autofocus="autofocus" tabindex="0">
        </div>

        <!-- Password -->
        <div class="form_block">
            <label class="form_lable" for="password">Password</label>
            <input class="form_input @error('password') is-invalid @enderror" id="password" type="password" name="password" required="required" autocomplete="current-password" tabindex="0">
        </div>

        <!-- Remember Me -->
        <div class="form_block">
            <label for="remember_me" class="form_lable">
                <input id="remember_me" type="checkbox" class="form_check" name="remember" tabindex="0">
                <span class="form_udertext">Запомнить меня</span>
            </label>
        </div>

        <div class="form_add">
            <div class="form_add_link">
                <a class="form_link" href="{{ route('register') }}" tabindex="0">Зарегистрироваться</a>
                @if (Route::has('password.request'))
                    <a class="form_link" href="{{ route('password.request') }}" tabindex="0">Забыли пароль?</a>
                @endif
            </div>
            <button type="submit" class="formBtn" id="formBtn" tabindex="0">Log in</button>
        </div>
    </form>
</div>

