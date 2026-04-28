<x-app-layout>
    <x-slot name="header">
        <h2 style="margin: 0; font-weight: bold; font-size: 1.25rem;">Add New Barber</h2>
    </x-slot>

    <div class="card mt-4 mb-4" style="max-width: 600px; margin-left: auto; margin-right: auto;">
        <form action="{{ route('admin.barbers.store') }}" method="POST">
            @csrf

            <div style="margin-bottom: 1rem;">
                <label for="name" style="display: block; margin-bottom: 0.5rem;">Name</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #333; background: #1e293b; color: white;">
                @error('name')<span style="color: #ef4444;">{{ $message }}</span>@enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="email" style="display: block; margin-bottom: 0.5rem;">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #333; background: #1e293b; color: white;">
                @error('email')<span style="color: #ef4444;">{{ $message }}</span>@enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="password" style="display: block; margin-bottom: 0.5rem;">Password</label>
                <input type="password" id="password" name="password" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #333; background: #1e293b; color: white;">
                @error('password')<span style="color: #ef4444;">{{ $message }}</span>@enderror
            </div>

            <div style="margin-bottom: 1rem;">
                <label for="password_confirmation" style="display: block; margin-bottom: 0.5rem;">Confirm Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" required style="width: 100%; padding: 10px; border-radius: 4px; border: 1px solid #333; background: #1e293b; color: white;">
            </div>

            <div style="display: flex; gap: 10px; justify-content: flex-end;">
                <a href="{{ route('admin.barbers.index') }}" style="padding: 10px 20px; background: #475569; color: white; text-decoration: none; border-radius: 4px;">Cancel</a>
                <button type="submit" style="padding: 10px 20px; background: #22c55e; color: white; border: none; font-weight: bold; border-radius: 4px; cursor: pointer;">Add Barber</button>
            </div>
        </form>
    </div>
</x-app-layout>
