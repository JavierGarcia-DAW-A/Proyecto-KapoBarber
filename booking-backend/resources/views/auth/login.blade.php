<x-guest-layout>
    <!-- Session Status -->
    @if(session('status'))
        <div class="mb-4 text-green-600 font-medium text-sm">
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('login') }}">
        @csrf

        <!-- Email Address -->
        <div>
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" />
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password" />
            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Remember Me -->
        <div class="mt-4">
            <label for="remember_me" class="flex items-center" style="display: flex; gap: 0.5rem; align-items: center;">
                <input id="remember_me" type="checkbox" name="remember" style="width: auto; margin: 0;">
                <span class="text-sm">Remember me</span>
            </label>
        </div>

        <div class="flex items-center justify-between mt-4">
            @if (Route::has('password.request'))
                <a class="auth-link" href="{{ route('password.request') }}">
                    Forgot your password?
                </a>
            @endif

            <div style="display: flex; gap: 1rem; align-items: center;">
                <a class="auth-link" href="{{ route('register') }}">Need an account?</a>
                <button type="submit" class="btn-primary">
                    Log in
                </button>
            </div>
        </div>
    </form>
</x-guest-layout>
