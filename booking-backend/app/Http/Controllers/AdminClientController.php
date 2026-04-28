<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rule;

class AdminClientController extends Controller
{
    public function index()
    {
        $clients = User::where('is_admin', false)->where('is_barber', false)->get();
        return view('admin.clients.index', compact('clients'));
    }

    public function edit(User $client)
    {
        return view('admin.clients.edit', compact('client'));
    }

    public function update(Request $request, User $client)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($client->id)],
        ]);

        $client->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        return redirect()->route('admin.clients.index')->with('status', 'Client updated successfully.');
    }

    public function destroy(User $client)
    {
        $client->delete();
        return redirect()->route('admin.clients.index')->with('status', 'Client deleted successfully.');
    }

    public function toggleBan(User $client)
    {
        $client->is_banned = !$client->is_banned;
        $client->save();
        $status = $client->is_banned ? 'banned' : 'unbanned';
        return redirect()->route('admin.clients.index')->with('status', "Client $status successfully.");
    }
}
