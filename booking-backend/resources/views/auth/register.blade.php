<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        <!-- Name -->
        <div>
            <label for="name">Name</label>
            <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus autocomplete="name" />
            @error('name')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <label for="email">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autocomplete="username" />
            @error('email')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Password -->
        <div class="mt-4">
            <label for="password">Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password" />
            @error('password')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <label for="password_confirmation">Confirm Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password" />
            @error('password_confirmation')<div class="text-danger">{{ $message }}</div>@enderror
        </div>

        <div class="flex items-center justify-between mt-4">
            <a class="auth-link" href="{{ route('login') }}">
                Already registered?
            </a>

            <button type="submit" class="btn-primary">
                Register
            </button>
        </div>
    </form>
</x-guest-layout>
