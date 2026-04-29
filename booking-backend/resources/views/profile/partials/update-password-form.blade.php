<section>
    <header>
        <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff;">
            {{ __('Update Password') }}
        </h2>

        <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #cbd5e1;">
            {{ __('Ensure your account is using a long, random password to stay secure.') }}
        </p>
    </header>

    <form method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <label for="update_password_current_password">{{ __('Current Password') }}</label>
            <input id="update_password_current_password" name="current_password" type="password" autocomplete="current-password" />
            <x-input-error :messages="$errors->updatePassword->get('current_password')" class="text-danger" />
        </div>

        <div>
            <label for="update_password_password">{{ __('New Password') }}</label>
            <input id="update_password_password" name="password" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password')" class="text-danger" />
        </div>

        <div>
            <label for="update_password_password_confirmation">{{ __('Confirm Password') }}</label>
            <input id="update_password_password_confirmation" name="password_confirmation" type="password" autocomplete="new-password" />
            <x-input-error :messages="$errors->updatePassword->get('password_confirmation')" class="text-danger" />
        </div>

        <div class="flex items-center gap-4 mt-4">
            <button class="btn-primary" type="submit">{{ __('Save') }}</button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    style="font-size: 0.875rem; color: #4ade80;"
                >{{ __('Saved.') }}</p>
            @endif
        </div>
    </form>
</section>
