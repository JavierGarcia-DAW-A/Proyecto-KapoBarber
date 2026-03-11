<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book an Appointment') }}
        </h2>
    </x-slot>

    <div class="py-12" x-data="bookingForm()">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    
                    @if ($errors->any())
                        <div class="mb-4 bg-red-100 text-red-600 p-4 rounded">
                            <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('appointments.store') }}">
                        @csrf
                        
                        <!-- Hairdresser Selection -->
                        <div class="mb-4">
                            <label for="hairdresser_id" class="block text-sm font-medium text-gray-700">Select Hairdresser</label>
                            <select id="hairdresser_id" name="hairdresser_id" x-model="hairdresser" @change="fetchTimes" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                                <option value="" disabled selected>-- Choose --</option>
                                <option value="1">Hairdresser 1</option>
                                <option value="2">Hairdresser 2</option>
                                <option value="3">Hairdresser 3</option>
                            </select>
                        </div>

                        <!-- Date Selection -->
                        <div class="mb-4">
                            <label for="date" class="block text-sm font-medium text-gray-700">Select Date</label>
                            <input type="date" id="date" name="date" x-model="date" @change="fetchTimes" min="{{ date('Y-m-d') }}" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm">
                            <p class="text-sm text-gray-500 mt-1">Closed on Sundays. Saturdays only morning shifts.</p>
                        </div>

                        <!-- Time Selection -->
                        <div class="mb-4" x-show="availableTimes.length > 0" style="display: none;">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Available Times</label>
                            <div class="grid grid-cols-4 sm:grid-cols-6 gap-2">
                                <template x-for="timeSlot in availableTimes" :key="timeSlot">
                                    <label class="cursor-pointer">
                                        <input type="radio" name="time" :value="timeSlot" x-model="time" class="peer sr-only">
                                        <div class="rounded-md border border-gray-300 px-3 py-2 text-center text-sm peer-checked:bg-indigo-600 peer-checked:text-white hover:bg-gray-50">
                                            <span x-text="timeSlot"></span>
                                        </div>
                                    </label>
                                </template>
                            </div>
                        </div>

                        <div class="mb-4" x-show="date && hairdresser && availableTimes.length === 0 && !loading" style="display: none;">
                            <p class="text-red-500">No time slots available for this date/hairdresser. Please select another date.</p>
                        </div>

                        <div class="mb-4" x-show="loading" style="display: none;">
                            <p class="text-indigo-500">Loading available times...</p>
                        </div>

                        <div class="mt-6">
                            <button type="submit" :disabled="!time || !date || !hairdresser" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 disabled:bg-gray-400 disabled:cursor-not-allowed">
                                Book Now
                            </button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>

    <script>
        function bookingForm() {
            return {
                hairdresser: '',
                date: '',
                time: '',
                availableTimes: [],
                loading: false,

                async fetchTimes() {
                    const d = new Date(this.date);
                    if (d.getDay() === 0) { // Sunday
                        this.availableTimes = [];
                        return;
                    }

                    if (this.hairdresser && this.date) {
                        this.loading = true;
                        this.availableTimes = [];
                        this.time = '';

                        try {
                            const response = await fetch(`/appointments/available-times?hairdresser_id=${this.hairdresser}&date=${this.date}`);
                            if (response.ok) {
                                this.availableTimes = await response.json();
                            }
                        } catch (error) {
                            console.error("Error fetching times", error);
                        } finally {
                            this.loading = false;
                        }
                    }
                }
            }
        }
    </script>
</x-app-layout>
