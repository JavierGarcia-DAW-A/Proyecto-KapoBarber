<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Admin Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">All Appointments</h3>
                    
                    @if($appointments->isEmpty())
                        <p class="text-gray-500">No appointments have been booked yet.</p>
                    @else
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-2 px-4 border-b text-left">Client Name</th>
                                    <th class="py-2 px-4 border-b text-left">Email</th>
                                    <th class="py-2 px-4 border-b text-center">Hairdresser</th>
                                    <th class="py-2 px-4 border-b text-center">Date</th>
                                    <th class="py-2 px-4 border-b text-center">Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($appointments as $app)
                                <tr>
                                    <td class="py-2 px-4">{{ $app->user->name }}</td>
                                    <td class="py-2 px-4">{{ $app->user->email }}</td>
                                    <td class="py-2 px-4 text-center text-blue-600 font-bold">#{{ $app->hairdresser_id }}</td>
                                    <td class="py-2 px-4 text-center">{{ \Carbon\Carbon::parse($app->date)->format('d/m/Y') }}</td>
                                    <td class="py-2 px-4 text-center font-semibold">{{ \Carbon\Carbon::parse($app->time)->format('H:i') }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @endif
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
