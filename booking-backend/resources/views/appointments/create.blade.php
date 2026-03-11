<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Book an Appointment') }}
        </h2>
    </x-slot>

    <!-- Include FullCalendar & SweetAlert2 from CDN -->
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.10/index.global.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="card mt-4 mb-4">
        @if ($errors->any())
            <div style="background: rgba(248, 113, 113, 0.2); color: #f87171; padding: 1rem; border-radius: 0.5rem; margin-bottom: 1rem;">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form id="booking-form" method="POST" action="{{ route('appointments.store') }}">
            @csrf
            
            <!-- Hidden inputs to submit to the controller -->
            <input type="hidden" id="selected_date" name="date" value="">
            <input type="hidden" id="selected_time" name="time" value="">

            <div class="mb-4">
                <label for="barber_id">Select Hairdresser</label>
                <select id="barber_id" name="barber_id" required onchange="renderCalendar()">
                    <option value="" disabled selected>-- Choose --</option>
                    @foreach ($barbers as $barber)
                        <option value="{{ $barber->id }}">{{ $barber->name }}</option>
                    @endforeach
                </select>
                <p style="font-size: 0.75rem; color: #94a3b8; margin-top: 0.5rem;">Select a barber first to check their available schedule.</p>
            </div>

            <!-- FullCalendar Container -->
            <div id="calendar-container" style="display: none;">
                <h3 style="margin-bottom: 1rem; color: #d19f68;">Select an Available Slot</h3>
                <div id="calendar" style="background: #ffffff; color: #000; padding: 1rem; border-radius: 8px;"></div>
            </div>
        </form>
    </div>

    <script>
        let calendar = null;

        function renderCalendar() {
            const barberId = document.getElementById('barber_id').value;
            const calendarEl = document.getElementById('calendar');
            const containerEl = document.getElementById('calendar-container');

            if (!barberId) {
                containerEl.style.display = 'none';
                return;
            }
            containerEl.style.display = 'block';

            if (calendar) {
                calendar.destroy();
            }

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'timeGridWeek',
                slotMinTime: '09:00:00',
                slotMaxTime: '20:00:00',
                allDaySlot: false,
                hiddenDays: [0, 6], /* Hide Sundays (0) and Saturdays (6) */
                events: async function(info, successCallback, failureCallback) {
                    try {
                        const response = await fetch(`/appointments/events?barber_id=${barberId}&start=${info.startStr}&end=${info.endStr}`);
                        const events = await response.json();
                        successCallback(events);
                    } catch (error) {
                        console.error('Error fetching events:', error);
                        failureCallback(error);
                    }
                },
                dateClick: async function(info) {
                    const selectedDateStr = info.dateStr.split('T')[0];
                    const selectedTimeStr = info.dateStr.split('T')[1].substring(0, 5); // HH:mm
                    const barberSelect = document.getElementById('barber_id');
                    const barberName = barberSelect.options[barberSelect.selectedIndex].text;

                    // Verify availability again before prompting
                    const response = await fetch(`/appointments/available-times?barber_id=${barberId}&date=${selectedDateStr}`);
                    const availableTimes = await response.json();

                    if (!availableTimes.includes(selectedTimeStr)) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Slot Unavailable',
                            text: 'This time slot is either booked or invalid. Please select another time.',
                            confirmButtonColor: '#d19f68'
                        });
                        return;
                    }

                    Swal.fire({
                        title: 'Confirm Booking',
                        html: `You are booking <strong>${barberName}</strong><br> Date: <strong>${selectedDateStr}</strong><br> Time: <strong>${selectedTimeStr}</strong>`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#d19f68',
                        cancelButtonColor: '#1b1b18',
                        confirmButtonText: 'Yes, book it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            document.getElementById('selected_date').value = selectedDateStr;
                            document.getElementById('selected_time').value = selectedTimeStr;
                            document.getElementById('booking-form').submit();
                        }
                    });
                }
            });
            calendar.render();
        }
    </script>
</x-app-layout>
