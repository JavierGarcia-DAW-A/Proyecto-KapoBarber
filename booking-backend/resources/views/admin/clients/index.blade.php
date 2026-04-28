<x-app-layout>
    <x-slot name="header">
        <h2 style="margin: 0; font-weight: bold; font-size: 1.25rem;">Manage Clients</h2>
    </x-slot>

    <div class="card mt-4 mb-4">
        <h3 style="margin-bottom: 1rem;">Client List</h3>
        
        @if(session('status'))
            <div style="color: #4ade80; margin-bottom: 1rem;">{{ session('status') }}</div>
        @endif

        @if($clients->isEmpty())
            <p style="color: #94a3b8;">No clients registered.</p>
        @else
            <table>
                <thead>
                    <tr>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Name</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Email</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Status</th>
                        <th style="padding: 10px; border-bottom: 2px solid #555;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($clients as $client)
                    <tr>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ $client->name }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">{{ $client->email }}</td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">
                            @if($client->is_banned)
                                <span style="color: #ef4444;">Banned</span>
                            @else
                                <span style="color: #4ade80;">Active</span>
                            @endif
                        </td>
                        <td style="padding: 10px; border-bottom: 1px solid #333;">
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('admin.clients.edit', $client->id) }}" style="color: #60a5fa; text-decoration: underline;">Edit</a>
                                
                                <form action="{{ route('admin.clients.toggleBan', $client->id) }}" method="POST">
                                    @csrf
                                    <button type="submit" style="color: {{ $client->is_banned ? '#4ade80' : '#f59e0b' }}; background: none; border: none; cursor: pointer; text-decoration: underline; padding: 0;">
                                        {{ $client->is_banned ? 'Unban' : 'Ban' }}
                                    </button>
                                </form>

                                <form action="{{ route('admin.clients.destroy', $client->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this client?');">
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
