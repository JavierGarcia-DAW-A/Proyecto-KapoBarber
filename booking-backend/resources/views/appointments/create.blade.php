<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-2xl text-white leading-tight" style="color: #d19f68; text-transform: uppercase;">
            {{ __('Reserva Tu Cita') }}
        </h2>
    </x-slot>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div class="max-w-4xl mx-auto mt-10 mb-10 px-4">
        @if ($errors->any())
            <div style="background: rgba(248, 113, 113, 0.1); border-left: 4px solid #f87171; color: #f87171; padding: 1rem; border-radius: 8px; margin-bottom: 2rem;">
                <ul style="list-style-type: disc; padding-left: 20px;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="wizard-container">
            
            <form id="booking-form" method="POST" action="{{ route('appointments.store') }}">
                @csrf
                <input type="hidden" id="selected_date" name="date" value="">
                <input type="hidden" id="selected_time" name="time" value="">
                <input type="hidden" id="selected_barber" name="barber_id" value="">
                <input type="hidden" id="selected_service" name="service" value="">
                <input type="hidden" id="selected_price" name="price" value="">

                <!-- DATOS DE CONTACTO -->
                <div class="form-row" style="max-width: 500px;">
                    <div>
                        <label>Nombre Completo</label>
                        <input type="text" value="{{ auth()->user()->name }}" readonly class="readonly-input">
                    </div>
                    <div>
                        <label>Teléfono de Contacto *</label>
                        <input type="text" id="phone" name="phone" required placeholder="+34 600..." class="active-input">
                    </div>
                </div>

                <!-- CAROUSEL DE FECHAS -->
                <div class="month-title-container">
                    <button type="button" id="prev-btn" class="nav-arrow">&#10094;</button>
                    <h3 id="month-year-display" class="month-title">MARZO</h3>
                    <button type="button" id="next-btn" class="nav-arrow">&#10095;</button>
                </div>
                
                <div class="date-carousel">
                    <div id="dates-container" class="dates-wrapper">
                        <!-- Generado por JS -->
                    </div>
                </div>

                <!-- PELUQUEROS -->
                <div class="section-container">
                    <h4 class="section-title">Selecciona un empleado:</h4>
                    <div class="barbers-grid">
                        @foreach ($barbers as $barber)
                            <div class="barber-card" data-id="{{ $barber->id }}" onclick="selectBarber({{ $barber->id }})">
                                <div class="barber-icon">M</div> <!-- Icono por defecto -->
                                <div class="barber-info">
                                    <span class="barber-name">{{ $barber->name }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- HORARIOS -->
                <div class="section-container" id="time-section" style="display: none;">
                    <h4 class="section-title">Por la mañana:</h4>
                    <div id="morning-slots" class="slots-grid"></div>

                    <h4 class="section-title" style="margin-top: 1.5rem;" id="afternoon-title">Por la tarde:</h4>
                    <div id="afternoon-slots" class="slots-grid"></div>
                </div>

                <!-- SERVICIOS -->
                <div class="section-container">
                    <h4 class="section-title">Selecciona un servicio:</h4>
                    <div class="services-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem;">
                        <div class="service-card" onclick="selectService('Styling', 25, this)">
                           <strong>Styling</strong><br><span style="color:#d19f68;">$25</span>
                        </div>
                        <div class="service-card" onclick="selectService('Styling + Color', 65, this)">
                           <strong>Styling + Color</strong><br><span style="color:#d19f68;">$65</span>
                        </div>
                        <div class="service-card" onclick="selectService('Styling + Tint', 65, this)">
                           <strong>Styling + Tint</strong><br><span style="color:#d19f68;">$65</span>
                        </div>
                        <div class="service-card" onclick="selectService('Semi-Permanent Wave', 65, this)">
                           <strong>Semi-Permanent Wave</strong><br><span style="color:#d19f68;">$65</span>
                        </div>
                        <div class="service-card" onclick="selectService('Cut + Styling', 63, this)">
                           <strong>Cut + Styling</strong><br><span style="color:#d19f68;">$63</span>
                        </div>
                        <div class="service-card" onclick="selectService('Cut + Styling + Color', 100, this)">
                           <strong>Cut + Styling + Color</strong><br><span style="color:#d19f68;">$100</span>
                        </div>
                        <div class="service-card" onclick="selectService('Cut + Styling + Tint', 100, this)">
                           <strong>Cut + Styling + Tint</strong><br><span style="color:#d19f68;">$100</span>
                        </div>
                        <div class="service-card" onclick="selectService('Cut', 25, this)">
                           <strong>Cut</strong><br><span style="color:#d19f68;">$25</span>
                        </div>
                        <div class="service-card" onclick="selectService('Shave', 65, this)">
                           <strong>Shave</strong><br><span style="color:#d19f68;">$65</span>
                        </div>
                        <div class="service-card" onclick="selectService('Beard Trim', 65, this)">
                           <strong>Beard Trim</strong><br><span style="color:#d19f68;">$65</span>
                        </div>
                        <div class="service-card" onclick="selectService('Cut + Beard Trim', 65, this)">
                           <strong>Cut + Beard Trim</strong><br><span style="color:#d19f68;">$65</span>
                        </div>
                        <div class="service-card" onclick="selectService('Cut + Shave', 63, this)">
                           <strong>Cut + Shave</strong><br><span style="color:#d19f68;">$63</span>
                        </div>
                        <div class="service-card" onclick="selectService('Clean Up', 100, this)">
                           <strong>Clean Up</strong><br><span style="color:#d19f68;">$100</span>
                        </div>
                    </div>
                </div>

                <!-- BOTON -->
                <button type="button" id="btn-submit" class="submit-btn" onclick="confirmSubmit()">Confirmar cita</button>
                
            </form>
        </div>
    </div>

    <!-- WIZARD UI ESTILOS -->
    <style>
        .wizard-container { background: #111; padding: 2.5rem; border-radius: 12px; border: 1px solid #222; box-shadow: 0 10px 40px rgba(0,0,0,0.8); color: #fff; font-family: 'Inter', sans-serif; }
        
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem; }
        label { display: block; color: #888; margin-bottom: 0.5rem; font-size: 0.85rem; }
        .readonly-input { width: 100%; background: #1a1a1a; border: 1px solid #333; color: #666; border-radius: 6px; padding: 0.85rem; }
        .active-input { width: 100%; background: #0a0a0a; border: 1px solid #d19f68; color: #fff; border-radius: 6px; padding: 0.85rem; outline: none; }
        
        .month-title-container { display: flex; justify-content: center; align-items: center; gap: 1.5rem; margin-bottom: 1rem; }
        .month-title { text-transform: uppercase; font-weight: bold; font-size: 1.1rem; color: #fff; }
        .nav-arrow { background: none; border: none; color: #888; font-size: 1.2rem; cursor: pointer; transition: color 0.2s; }
        .nav-arrow:hover { color: #d19f68; }

        .date-carousel { overflow: hidden; margin-bottom: 2.5rem; padding-bottom: 10px; }
        .dates-wrapper { display: flex; gap: 1rem; transition: transform 0.3s ease; }
        .date-box { min-width: 60px; text-align: center; cursor: pointer; color: #666; transition: all 0.2s; padding: 10px 0; border-radius: 8px; }
        .date-box .day-name { display: block; font-size: 0.8rem; text-transform: lowercase; margin-bottom: 5px; }
        .date-box .day-num { display: block; font-size: 1.1rem; font-weight: bold; }
        .date-box:hover { color: #fff; }
        .date-box.selected { background: #000; color: #fff; border: 1px solid #d19f68; box-shadow: 0 0 10px rgba(209, 159, 104, 0.2); }

        .section-container { margin-bottom: 2.5rem; }
        .section-title { color: #888; font-size: 0.9rem; margin-bottom: 1rem; }

        .barbers-grid { display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1rem; }
        .barber-card { display: flex; align-items: center; gap: 12px; padding: 1rem; background: #1a1a1a; border: 1px solid #333; border-radius: 8px; cursor: pointer; transition: all 0.2s; }
        .barber-card:hover { border-color: #666; }
        .barber-card.selected { border-color: #d19f68; background: rgba(209, 159, 104, 0.05); }
        .barber-icon { width: 35px; height: 35px; border-radius: 50%; background: #333; color: #fff; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 1px solid #555; }
        .barber-name { font-size: 0.9rem; font-weight: 500; }

        .slots-grid { display: flex; flex-wrap: wrap; gap: 10px; }
        .slot-pill { padding: 8px 18px; border: 1px solid #333; border-radius: 20px; font-size: 0.9rem; color: #aaa; cursor: pointer; transition: all 0.2s; background: #1a1a1a; }
        .slot-pill:hover { border-color: #666; color: #fff; }
        .slot-pill.selected { background: #d19f68; color: #000; border-color: #d19f68; font-weight: bold; }

        .service-card { display: flex; flex-direction: column; padding: 1.2rem; background: #1a1a1a; border: 1px solid #333; border-left: 4px solid #555; border-radius: 8px; cursor: pointer; transition: all 0.2s; }
        .service-card:hover { border-color: #666; }
        .service-card.selected { border-left-color: #d19f68; border-color: #d19f68; background: rgba(209, 159, 104, 0.05); }
        
        .submit-btn { display: block; width: 100%; padding: 1.2rem; background: #555; color: #fff; font-size: 1rem; font-weight: bold; border: none; border-radius: 8px; text-transform: uppercase; cursor: pointer; transition: background 0.3s; margin-top: 1rem; }
        .submit-btn.ready { background: #d19f68; color: #000; }
        .submit-btn.ready:hover { background: #b88655; }
    </style>

    <script>
        const daysContainer = document.getElementById('dates-container');
        const monthTitle = document.getElementById('month-year-display');
        const morningsContainer = document.getElementById('morning-slots');
        const afternoonsContainer = document.getElementById('afternoon-slots');
        const timeSection = document.getElementById('time-section');
        const btnSubmit = document.getElementById('btn-submit');
        const afternoonTitle = document.getElementById('afternoon-title');

        let selectedDate = null;
        let selectedTime = null;
        let selectedBarberId = null;
        let selectedService = null;
        let selectedPrice = null;

        let currentDateStart = new Date();
        const daysToGenerate = 30; // generar 30 días en adelante

        const months = ["ENERO","FEBRERO","MARZO","ABRIL","MAYO","JUNIO","JULIO","AGOSTO","SEPTIEMBRE","OCTUBRE","NOVIEMBRE","DICIEMBRE"];
        const days = ["dom","lun","mar","mié","jue","vie","sáb"];

        function generateDates() {
            daysContainer.innerHTML = '';
            let dateCursor = new Date(currentDateStart);
            let addedCount = 0;

            monthTitle.innerText = `${months[dateCursor.getMonth()]} ${dateCursor.getFullYear()}`;

            while(addedCount < 14) { // mostrar 14 días en la vista
                // Omitir los domingos por completo
                if(dateCursor.getDay() !== 0) {
                    const dateStr = dateCursor.toISOString().split('T')[0];
                    const box = document.createElement('div');
                    box.className = 'date-box' + (selectedDate === dateStr ? ' selected' : '');
                    box.innerHTML = `
                        <span class="day-name">${days[dateCursor.getDay()]}</span>
                        <span class="day-num">${dateCursor.getDate()}</span>
                    `;
                    box.onclick = () => selectDate(dateStr, box);
                    daysContainer.appendChild(box);
                    addedCount++;
                }
                dateCursor.setDate(dateCursor.getDate() + 1);
            }
        }

        function selectDate(dateStr, el) {
            document.querySelectorAll('.date-box').forEach(b => b.classList.remove('selected'));
            el.classList.add('selected');
            selectedDate = dateStr;
            document.getElementById('selected_date').value = selectedDate;
            
            selectedTime = null;
            document.getElementById('selected_time').value = "";
            checkSubmitReady();

            if(selectedBarberId) {
                fetchAvailableTimes();
            } else {
                Swal.fire({ icon: 'info', title: 'Paso Previo', text: 'Selecciona un peluquero primero para ver sus horarios', background: '#1a1a1a', color: '#fff', confirmButtonColor: '#d19f68' });
            }
        }

        function selectBarber(barberId) {
            document.querySelectorAll('.barber-card').forEach(c => c.classList.remove('selected'));
            document.querySelector(`.barber-card[data-id="${barberId}"]`).classList.add('selected');
            selectedBarberId = barberId;
            document.getElementById('selected_barber').value = barberId;
            
            selectedTime = null;
            document.getElementById('selected_time').value = "";
            checkSubmitReady();

            if(selectedDate) {
                fetchAvailableTimes();
            } else {
                Swal.fire({ icon: 'info', title: 'Paso Previo', text: 'Selecciona una fecha arriba para ver los horarios disponibles', background: '#1a1a1a', color: '#fff', confirmButtonColor: '#d19f68' });
            }
        }

        async function fetchAvailableTimes() {
            timeSection.style.display = 'block';
            morningsContainer.innerHTML = '<span style="color:#666">Cargando horarios...</span>';
            afternoonsContainer.innerHTML = '<span style="color:#666">Cargando horarios...</span>';

            try {
                const response = await fetch(`{{ url('appointments/available-times') }}?barber_id=${selectedBarberId}&date=${selectedDate}`);
                const times = await response.json();

                morningsContainer.innerHTML = '';
                afternoonsContainer.innerHTML = '';
            
            let dateObj = new Date(selectedDate);
            let isSaturday = dateObj.getDay() === 6;

            if (isSaturday) {
                afternoonTitle.style.display = 'none';
                afternoonsContainer.style.display = 'none';
            } else {
                afternoonTitle.style.display = 'block';
                afternoonsContainer.style.display = 'flex';
            }

            if(times.length === 0) {
                morningsContainer.innerHTML = '<span style="color:#f87171">No hay horarios disponibles</span>';
            }

            times.forEach(t => {
                let hour = parseInt(t.split(':')[0]);
                let pill = document.createElement('div');
                pill.className = 'slot-pill';
                pill.innerText = t;
                pill.onclick = () => selectTime(t, pill);

                if (hour < 14) {
                    morningsContainer.appendChild(pill);
                } else {
                    afternoonsContainer.appendChild(pill);
                }
            });

            } catch (error) {
                console.error("Error cargando horarios:", error);
                morningsContainer.innerHTML = '<span style="color:#f87171">Error de conexión al cargar horarios</span>';
                afternoonsContainer.innerHTML = '';
            }
        }

        function selectTime(time, el) {
            document.querySelectorAll('.slot-pill').forEach(p => p.classList.remove('selected'));
            el.classList.add('selected');
            selectedTime = time;
            document.getElementById('selected_time').value = selectedTime;
            checkSubmitReady();
        }

        function selectService(name, price, el) {
            document.querySelectorAll('.service-card').forEach(c => c.classList.remove('selected'));
            el.classList.add('selected');
            selectedService = name;
            selectedPrice = price;
            document.getElementById('selected_service').value = name;
            document.getElementById('selected_price').value = price;
            checkSubmitReady();
        }

        function checkSubmitReady() {
            const phone = document.getElementById('phone').value;
            if(selectedDate && selectedBarberId && selectedTime && phone && selectedService) {
                btnSubmit.classList.add('ready');
            } else {
                btnSubmit.classList.remove('ready');
            }
        }

        document.getElementById('phone').addEventListener('input', checkSubmitReady);

        function confirmSubmit() {
            if(!btnSubmit.classList.contains('ready')) {
                Swal.fire({ icon: 'warning', title: 'Faltan datos', text: 'Rellena tu teléfono, selecciona peluquero, fecha y hora.', background: '#1a1a1a', color: '#fff', confirmButtonColor: '#d19f68' });
                return;
            }
            document.getElementById('booking-form').submit();
        }

        document.getElementById('prev-btn').onclick = () => {
            currentDateStart.setDate(currentDateStart.getDate() - 7);
            if(currentDateStart < new Date()) currentDateStart = new Date();
            generateDates();
        };

        document.getElementById('next-btn').onclick = () => {
            currentDateStart.setDate(currentDateStart.getDate() + 7);
            generateDates();
        };

        // Inicializar Interfaz de Usuario
        generateDates();
    </script>
</x-app-layout>
