<?php
/* Template Name: Reservation */
get_header();
?>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" type="text/css" href="https://npmcdn.com/flatpickr/dist/themes/dark.css">

    <main class="main-content">

        <section class="contact-section section-padding30">
            <div class="container">
                <form class="form-contact contact_form" action="#" method="post">
                    <div class="row justify-content-center">

                        <div class="col-lg-7 mb-5">
                            <h4 style="color: #d19f68;" class="mb-4">1. Elige el día</h4>
                            <div class="row mb-3">
                                <div class="col-sm-6 mb-2">
                                    <input class="form-control" name="name" type="text" placeholder="Nombre completo"
                                        required>
                                </div>
                                <div class="col-sm-6 mb-2">
                                    <input class="form-control" name="phone" type="tel" placeholder="Teléfono" required>
                                </div>
                            </div>

                            <div id="inline-calendar"></div>
                            <input type="hidden" name="date" id="date-input" required>

                            <p class="info-horario">
                                <b>Horario:</b> L-V 9:00-13:30 / 16:00-20:30 | Sáb 9:00-13:30
                            </p>
                        </div>

                        <div class="col-lg-5">
                            <div class="booking-details-box">
                                <h4 style="color: #d19f68;" class="mb-4">2. Detalles y Hora</h4>

                                <div class="form-group mb-4">
                                    <label style="color:#fff">Servicio</label>
                                    <select class="form-control" name="service" required>
                                        <option value="">¿Qué te haremos hoy?</option>
                                        <option>Corte de pelo</option>
                                        <option>Corte + Barba</option>
                                        <option>Afeitado clásico</option>
                                    </select>
                                </div>

                                <div class="form-group mb-4">
                                    <label style="color:#fff">Hora disponible</label>
                                    <select id="time-select" class="form-control" name="time" required disabled>
                                        <option value="">Primero elige un día...</option>
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label style="color:#fff">Notas (opcional)</label>
                                    <textarea class="form-control w-100" name="message" rows="3"></textarea>
                                </div>

                                <button type="submit" class="button button-contactForm boxed-btn w-100 mt-3">
                                    Confirmar Reserva
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </main>

<?php 
add_action('wp_footer', function() {
?>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/es.js"></script>

    <script>
        $(document).ready(function () {
            function cargarHoras(esSabado) {
                const select = $("#time-select");
                select.empty();
                select.append('<option value="">Selecciona la hora</option>');
                select.prop('disabled', false);

                const hManana = ["09:00", "09:30", "10:00", "10:30", "11:00", "11:30", "12:00", "12:30", "13:00", "13:30"];
                const hTarde = ["16:00", "16:30", "17:00", "17:30", "18:00", "18:30", "19:00", "19:30", "20:00", "20:30"];

                hManana.forEach(h => select.append(`<option value="${h}">${h}h</option>`));
                if (!esSabado) {
                    hTarde.forEach(h => select.append(`<option value="${h}">${h}h</option>`));
                }
            }

            flatpickr("#inline-calendar", {
                inline: true,
                locale: "es",
                minDate: "today",
                dateFormat: "Y-m-d",
                disable: [function (date) { return (date.getDay() === 0); }],
                onChange: function (selectedDates, dateStr) {
                    $("#date-input").val(dateStr);
                    const day = selectedDates[0].getDay();
                    cargarHoras(day === 6);
                }
            });
        });
    </script>
<?php
}, 100);

get_footer(); 
?>
