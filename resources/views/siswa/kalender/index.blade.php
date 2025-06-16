<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Kalender') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Kalender
    </x-slot>

    <x-slot name="styles">
        <style>
            .fc-day {
                background-color: #fff;
                border: 1px solid #e0e0e0;
            }
            .fc-event.info {
                background-color: hsl(var(--main)) !important;
                border-color: hsl(var(--main)) !important;
            }
            .fc-daygrid-day-number, .fc .fc-col-header-cell-cushion {
                color: hsl(var(--text)) !important;
            }
        </style>
    </x-slot>

    <main>
        <div class="card mt-24 bg-transparent">
            <div class="card-body p-0">
                <div id='wrap'>
                    <div id='calendar' class="position-relative">
                        <!-- Removed "Tambah Kegiatan" button -->
                    </div>
                    <div style='clear:both'></div>
                </div>
            </div>
        </div>

        <!-- Modal View Event (Read-Only) -->
        <div class="modal fade" id="viewEventModal" tabindex="-1" aria-labelledby="viewEventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
                <div class="modal-content radius-16 bg-base">
                    <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                        <h1 class="modal-title fs-5" id="viewEventModalLabel">Detail Kegiatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-24">
                        <div class="row">
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Judul Kegiatan:</label>
                                <div class="form-control radius-8 bg-light" id="viewEventTitle" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                    <!-- Event title will be displayed here -->
                                </div>
                            </div>
                            <div class="col-md-6 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal Mulai</label>
                                <div class="form-control radius-8 bg-light" id="viewStartDate" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                    <!-- Start date will be displayed here -->
                                </div>
                            </div>
                            <div class="col-md-6 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal Selesai</label>
                                <div class="form-control radius-8 bg-light" id="viewEndDate" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                    <!-- End date will be displayed here -->
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Deskripsi</label>
                                <div class="form-control" id="viewDesc" style="background-color: #f8f9fa; border: 1px solid #e9ecef; min-height: 100px; padding: 12px;">
                                    <!-- Description will be displayed here -->
                                </div>
                            </div>
                            <div class="col-12 mb-20">
                                <label class="form-label fw-semibold text-primary-light text-sm mb-8">Jenis Kegiatan</label>
                                <div class="form-control radius-8 bg-light" id="viewEventType" style="background-color: #f8f9fa; border: 1px solid #e9ecef;">
                                    <!-- Event type will be displayed here -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <x-slot name="scripts">
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.17/index.global.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

        <script>
            document.addEventListener('DOMContentLoaded', function() {
                try {
                    const calendarEl = document.getElementById('calendar');
                    const calendar = new FullCalendar.Calendar(calendarEl, {
                        headerToolbar: {
                            left: '',
                            center: 'title',
                            right: 'prev,next today'
                        },
                        firstDay: 1,
                        selectable: false,  // Disabled selection for read-only
                        initialView: 'dayGridMonth',
                        dayMaxEvents: true,
                        allDaySlot: true,
                        selectMirror: false,  // Disabled for read-only
                        events: {
                            url: '/api/kalender',
                            method: 'GET',
                            failure: function() {
                                alert('Terjadi kesalahan saat mengambil data event!');
                            },
                            extraParams: {
                                _token: document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                        },
                        // Removed select callback for read-only mode
                        eventClick: function(info) {
                            const event = info.event;

                            // Populate the view modal with event data
                            document.getElementById('viewEventTitle').textContent = event.title;
                            document.getElementById('viewStartDate').textContent = moment(event.start).format('DD MMMM YYYY');

                            let endDate = event.end;
                            if (endDate) {
                                endDate = moment(endDate).subtract(1, 'days');
                                document.getElementById('viewEndDate').textContent = endDate.format('DD MMMM YYYY');
                            } else {
                                document.getElementById('viewEndDate').textContent = moment(event.start).format('DD MMMM YYYY');
                            }

                            document.getElementById('viewDesc').textContent = event.extendedProps.description || 'Tidak ada deskripsi';

                            // Display event type in Indonesian
                            const eventTypes = {
                                'ujian': 'Ujian',
                                'event': 'Event',
                                'libur': 'Libur'
                            };
                            document.getElementById('viewEventType').textContent = eventTypes[event.extendedProps.type] || event.extendedProps.type || 'Tidak ditentukan';

                            // Show modal
                            const viewModal = new bootstrap.Modal(document.getElementById('viewEventModal'));
                            viewModal.show();
                        }
                    });

                    calendar.render();

                    // Store calendar reference for later use
                    window.calendarInstance = calendar;

                } catch (error) {
                    console.error('Error initializing calendar:', error);
                }
            });
        </script>
    </x-slot>

</x-app-layout>
