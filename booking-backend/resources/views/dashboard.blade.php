<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('My Appointments') }}
            </h2>
            <a href="{{ route('appointments.create') }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Book Haircut
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            @if (session('status') === 'appointment-booked')
                <div class="mb-4 text-green-600 bg-green-100 p-4 rounded">
                    Your appointment has been successfully booked!
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h3 class="text-lg font-bold mb-4">Upcoming Appointments</h3>
                    
                    @if($appointments->isEmpty())
                        <p class="text-gray-500">You don't have any appointments booked yet.</p>
                    @else
                        <table class="min-w-full bg-white divide-y divide-gray-200">
                            <thead>
                                <tr>
                                    <th class="py-2 px-4 border-b">Hairdresser</th>
                                    <th class="py-2 px-4 border-b">Date</th>
                                    <th class="py-2 px-4 border-b">Time</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                                @foreach($appointments as $app)
                                <tr>
                                    <td class="py-2 px-4 text-center">Hairdresser {{ $app->hairdresser_id }}</td>
                                    <td class="py-2 px-4 text-center">{{ \Carbon\Carbon::parse($app->date)->format('d/m/Y') }}</td>
                                    <td class="py-2 px-4 text-center">{{ \Carbon\Carbon::parse($app->time)->format('H:i') }}</td>
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
