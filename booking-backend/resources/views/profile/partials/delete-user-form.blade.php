<section class="space-y-6">
    <header>
        <h2 style="font-size: 1.25rem; font-weight: 600; color: #fff;">
            {{ __('Delete Account') }}
        </h2>

        <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #cbd5e1;">
            {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
        </p>
    </header>

    <button
        style="margin-top: 1rem; background-color: #ef4444; color: white; padding: 0.5rem 1rem; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: bold; font-size: 0.875rem; text-transform: uppercase;"
        x-data=""
        x-on:click.prevent="$dispatch('open-modal', 'confirm-user-deletion')"
    >{{ __('Delete Account') }}</button>

    <x-modal name="confirm-user-deletion" :show="$errors->userDeletion->isNotEmpty()" focusable>
        <form method="post" action="{{ route('profile.destroy') }}" class="p-6">
            @csrf
            @method('delete')

            <h2 style="font-size: 1.25rem; font-weight: 600; color: #1e293b;">
                {{ __('Are you sure you want to delete your account?') }}
            </h2>

            <p style="margin-top: 0.25rem; font-size: 0.875rem; color: #475569;">
                {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}
            </p>

            <div class="mt-6">
                <label for="password" class="sr-only">{{ __('Password') }}</label>

                <input
                    id="password"
                    name="password"
                    type="password"
                    placeholder="{{ __('Password') }}"
                    style="width: 75%; background-color: #f1f5f9; color: #0f172a; border: 1px solid #cbd5e1;"
                />

                <x-input-error :messages="$errors->userDeletion->get('password')" class="text-danger mt-2" />
            </div>

            <div class="mt-6 flex justify-end gap-4">
                <button type="button" x-on:click="$dispatch('close')" style="padding: 0.5rem 1rem; background-color: #e2e8f0; color: #475569; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">
                    {{ __('Cancel') }}
                </button>

                <button type="submit" style="padding: 0.5rem 1rem; background-color: #ef4444; color: white; border: none; border-radius: 0.375rem; cursor: pointer; font-weight: 600; font-size: 0.875rem; text-transform: uppercase;">
                    {{ __('Delete Account') }}
                </button>
            </div>
        </form>
    </x-modal>
</section>
