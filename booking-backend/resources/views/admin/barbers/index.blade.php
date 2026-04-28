<x-app-layout>
    <x-slot name="header">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <h2 style="margin: 0; font-weight: bold; font-size: 1.25rem;">Manage Barbers</h2>
            <a href="{{ route('admin.barbers.create') }}" style="padding: 10px 20px; background: #22c55e; color: white; text-decoration: none; border-radius: 4px; font-weight: bold;">Add Barber</a>
        </div>
    </x-slot>

    <div class="card mt-4 mb-4">
        <h3 style="margin-bottom: 1rem;">Barber List</h3>
        
        @if(session('status'))
            <div style="color: #4ade80; margin-bottom: 1rem;">{{ session('status') }}</div>
        @endif

        @if($barbers->isEmpty())
            <p style="color: #94a3b8;">No barbers registered.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Name</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Email</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($barbers as $barber)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ $barber->name }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ $barber->user->email ?? 'N/A' }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.barbers.edit', $barber->id) }}" style="color: #60a5fa; text-decoration: underline;">Edit</a>

                                <form action="{{ route('admin.barbers.destroy', $barber->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this barber?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" style="color: #f87171; background: none; border: none; cursor: pointer; text-decoration: underline; padding: 0;">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
</x-app-layout>
