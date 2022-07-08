<div class="form_wrap">
    <x-auth-validation-errors class="mb-4" :errors="$errors" />
    <form method="POST" id="registerForm" onsubmit="return false">
        @csrf
        <!-- Name -->
        <div class="form_block">
            <label class="form_lable" for="name">Ваше имя</label>
            <input class="form_input @error('name') is-invalid @enderror" id="name" type="text" name="name" value="{{old('name')}}" required="required" autofocus="autofocus" tabindex="0">
        </div>

        <!-- Email Address -->
        <div class="form_block">
            <label class="form_lable" for="email">Email</label>
            <input class="form_input @error('email') is-invalid @enderror" id="email" type="email" name="email" value="{{old('email')}}" required="required" tabindex="0">
        </div>

        <!-- Password -->
        <div class="form_block">
            <label class="form_lable" for="password">Пароль</label>
            <input class="form_input @error('password') is-invalid @enderror" id="password" type="password" name="password" required="required" autocomplete="new-password" tabindex="0">
        </div>

        <!-- Confirm Password -->
        <div class="form_block">
            <label class="form_lable" for="password_confirmation">Подтвердить пароль</label>
            <input class="form_input @error('password_confirmation') is-invalid @enderror" id="password_confirmation" type="password" name="password_confirmation" required="required" tabindex="0">
        </div>

        <div class="form_add mt_2">
            <div class="form_add_link">
                <a class="form_link" href="{{ route('user.auth') }}" id="toLoginForm" tabindex="0">Уже зарегистрированы?</a>
            </div>
            <button type="submit" class="formBtn" id="formBtn">Register</button>
        </div>
    </form>
</div>
