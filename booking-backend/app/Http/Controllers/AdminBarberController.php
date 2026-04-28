<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Barbers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class AdminBarberController extends Controller
{
    public function index()
    {
        $barbers = Barbers::with('user')->get();
        return view('admin.barbers.index', compact('barbers'));
    }

    public function create()
    {
        return view('admin.barbers.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'is_barber' => true,
        ]);

        Barbers::create([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
            'user_id' => $user->id,
            'wp_id' => 0, // Placeholder if no WP integration right now
        ]);

        return redirect()->route('admin.barbers.index')->with('status', 'Barber added successfully.');
    }

    public function edit($id)
    {
        $barber = Barbers::findOrFail($id);
        return view('admin.barbers.edit', compact('barber'));
    }

    public function update(Request $request, $id)
    {
        $barber = Barbers::findOrFail($id);
        $user = $barber->user;

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', Rule::unique(User::class)->ignore($user->id)],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        $barber->update([
            'name' => $request->name,
            'slug' => \Illuminate\Support\Str::slug($request->name),
        ]);

        return redirect()->route('admin.barbers.index')->with('status', 'Barber updated successfully.');
    }

    public function destroy($id)
    {
        $barber = Barbers::findOrFail($id);
        if ($barber->user) {
            $barber->user->delete();
        }
        $barber->delete();
        return redirect()->route('admin.barbers.index')->with('status', 'Barber deleted successfully.');
    }
}
