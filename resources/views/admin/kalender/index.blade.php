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
                        <button type="button" class="add-event btn btn-main text-sm btn-sm px-24 rounded-pill py-12 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="ph ph-plus me-4"></i>
                            Tambah Kegiatan
                        </button>
                    </div>
                    <div style='clear:both'></div>
                </div>
            </div>
        </div>

        <!-- Modal Add Event -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
                <div class="modal-content radius-16 bg-base">
                    <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Kegiatan Baru</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-24">
                        <form id="addEventForm">
                            <div class="row">
                                <div class="col-12 mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Judul Kegiatan:</label>
                                    <input type="text" class="form-control radius-8" placeholder="Masukkan Judul Kegiatan">
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label for="startDate" class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal Mulai</label>
                                    <div class="position-relative">
                                        <input class="form-control radius-8 bg-base" id="startDate" type="date">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label for="endDate" class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal Selesai</label>
                                    <div class="position-relative">
                                        <input class="form-control radius-8 bg-base" id="endDate" type="date">
                                    </div>
                                </div>
                                <div class="col-12 mb-20">
                                    <label for="desc" class="form-label fw-semibold text-primary-light text-sm mb-8">Deskripsi</label>
                                    <textarea class="form-control" id="desc" rows="4" cols="50" placeholder="Tulis deskripsi event"></textarea>
                                </div>

                                <div class="col-12 mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Jenis Kegiatan</label>
                                    <select class="form-select radius-8" name="eventType" id="eventType">
                                        <option value="" selected disabled>Pilih Jenis Kegiatan</option>
                                        <option value="ujian">Ujian</option>
                                        <option value="event">Event</option>
                                        <option value="libur">Libur</option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-8 mt-24">
                                    <button type="reset" class="btn bg-danger-600 hover-bg-danger-800 border-danger-600 hover-border-danger-800 text-md px-24 py-12 radius-8">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn bg-main-600 hover-bg-main-800 border-main-600 hover-border-main-800 text-md px-24 py-12 radius-8">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Edit Event -->
        <div class="modal fade" id="editEventModal" tabindex="-1" aria-labelledby="editEventModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog modal-dialog-centered">
                <div class="modal-content radius-16 bg-base">
                    <div class="modal-header py-16 px-24 border border-top-0 border-start-0 border-end-0">
                        <h1 class="modal-title fs-5" id="editEventModalLabel">Edit Kegiatan</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-24">
                        <form id="editEventForm">
                            <div class="row">
                                {{-- Input Hidden Id --}}
                                <input type="hidden" id="editEventId" name="id">
                                {{-- Input Hidden User Id --}}
                                <input type="hidden" id="editEventUserId" name="user_id" value="{{ auth()->user()->id }}">
                                <div class="col-12 mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Judul Kegiatan:</label>
                                    <input type="text" id="editEventTitle" class="form-control radius-8" placeholder="Masukkan Judul Kegiatan">
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label for="editStartDate" class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal Mulai</label>
                                    <div class="position-relative">
                                        <input class="form-control radius-8 bg-base" id="editStartDate" type="date">
                                    </div>
                                </div>
                                <div class="col-md-6 mb-20">
                                    <label for="editEndDate" class="form-label fw-semibold text-primary-light text-sm mb-8">Tanggal Selesai</label>
                                    <div class="position-relative">
                                        <input class="form-control radius-8 bg-base" id="editEndDate" type="date">
                                    </div>
                                </div>
                                <div class="col-12 mb-20">
                                    <label for="editDesc" class="form-label fw-semibold text-primary-light text-sm mb-8">Deskripsi</label>
                                    <textarea class="form-control" id="editDesc" rows="4" cols="50" placeholder="Tulis deskripsi event"></textarea>
                                </div>
                                <div class="col-12 mb-20">
                                    <label for="editEventType" class="form-label fw-semibold text-primary-light text-sm mb-8">Jenis Kegiatan</label>
                                    <select id="editEventType" class="form-control radius-8">
                                        <option value="ujian">Ujian</option>
                                        <option value="event">Event</option>
                                        <option value="libur">Libur</option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-8 mt-24">
                                    <button type="button" class="btn bg-danger-600 hover-bg-danger-800 border-danger-600 hover-border-danger-800 text-md px-24 py-12 radius-8" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn bg-main-600 hover-bg-main-800 border-main-600 hover-border-main-800 text-md px-24 py-12 radius-8">
                                        Simpan
                                    </button>
                                </div>
                            </div>
                        </form>
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
                    selectable: true,  // This is already set
                    initialView: 'dayGridMonth',
                    dayMaxEvents: true,
                    allDaySlot: true,
                    selectMirror: true,
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
                    // Add this new select callback function
                    select: function(info) {
                        // Set the selected date in the form
                        document.getElementById('startDate').value = moment(info.start).format('YYYY-MM-DD');
                        document.getElementById('endDate').value = moment(info.end).subtract(1, 'days').format('YYYY-MM-DD');

                        // Show the create modal
                        const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                        modal.show();
                    },
                    eventClick: function(info) {
                        const event = info.event;

                        document.getElementById('editEventId').value = event.id;
                        document.getElementById('editEventTitle').value = event.title;
                        document.getElementById('editStartDate').value = moment(event.start).format('YYYY-MM-DD');

                        let endDate = event.end;
                        if (endDate) {
                            // In FullCalendar 6, the end date is exclusive, so subtract 1 day to match your logic
                            endDate = moment(endDate).subtract(1, 'days');
                            document.getElementById('editEndDate').value = endDate.format('YYYY-MM-DD');
                        } else {
                            document.getElementById('editEndDate').value = moment(event.start).format('YYYY-MM-DD');
                        }

                        document.getElementById('editDesc').value = event.extendedProps.description;

                        // Set the event type in the select dropdown
                        const selectElement = document.getElementById('editEventType');
                        for(let i = 0; i < selectElement.options.length; i++) {
                            if(selectElement.options[i].value === event.extendedProps.type) {
                                selectElement.selectedIndex = i;
                                break;
                            }
                        }

                        // Store event ID for the form submission
                        document.getElementById('editEventForm').dataset.eventId = event.id;

                        // Show modal
                        const editModal = new bootstrap.Modal(document.getElementById('editEventModal'));
                        editModal.show();
                    }
                });

                calendar.render();

                // Store calendar reference for later use
                window.calendarInstance = calendar;

                // Add Event Form Handler
                document.getElementById('addEventForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const title = this.querySelector('input[type="text"]').value;
                    const startDate = document.getElementById('startDate').value;
                    const endDate = document.getElementById('endDate').value;
                    const description = document.getElementById('desc').value;
                    const type = document.getElementById('eventType').value;

                    if (!title) {
                        alert('Judul event harus diisi');
                        return;
                    }

                    const eventData = {
                        title: title,
                        start: startDate,
                        end: moment(endDate).add(1, 'days').format('YYYY-MM-DD'),
                        description: description,
                        type: type,
                        allDay: true,
                        user_id: {{ auth()->user()->id }}
                    };

                    // If using AJAX
                    fetch('{{ route('api.kalender.store') }}', {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(eventData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Add event to calendar
                        calendar.addEvent({
                            id: data.id || Date.now(), // Use returned ID or generate temporary one
                            title: data.title,
                            start: data.start,
                            end: data.end,
                            allDay: true,
                            extendedProps: {
                                description: data.description,
                                type: data.type
                            }
                        });

                        // Hide modal and reset form
                        const modal = bootstrap.Modal.getInstance(document.getElementById('exampleModal'));
                        modal.hide();
                        document.getElementById('addEventForm').reset();

                        alert(`Kegiatan "${title}" berhasil ditambahkan.`);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat menambahkan kegiatan!');
                    });
                });

                // Edit Event Form Handler
                document.getElementById('editEventForm').addEventListener('submit', function(e) {
                    e.preventDefault();

                    const eventId = this.dataset.eventId;
                    const title = document.getElementById('editEventTitle').value;
                    const startDate = document.getElementById('editStartDate').value;
                    const endDate = document.getElementById('editEndDate').value;
                    const description = document.getElementById('editDesc').value;
                    const type = document.getElementById('editEventType').value;

                    const eventData = {
                        id: document.getElementById('editEventId').value,
                        title: title,
                        start: startDate,
                        end: moment(endDate).add(1, 'days').format('YYYY-MM-DD'),
                        description: description,
                        type: type,
                        user_id: {{ auth()->user()->id }}
                    };

                    // If using AJAX
                    fetch(`/api/kalender/${eventId}`, {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify(eventData)
                    })
                    .then(response => response.json())
                    .then(data => {
                        // Find and update the event in calendar
                        const event = calendar.getEventById(eventId);
                        if (event) {
                            event.setProp('title', title);
                            event.setStart(startDate);
                            event.setEnd(moment(endDate).add(1, 'days').format('YYYY-MM-DD'));
                            event.setExtendedProp('description', description);
                            event.setExtendedProp('type', type);
                        }

                        // Hide modal
                        const modal = bootstrap.Modal.getInstance(document.getElementById('editEventModal'));
                        modal.hide();

                        alert(`Kegiatan "${title}" berhasil diperbarui.`);
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Terjadi kesalahan saat memperbarui kegiatan!');
                    });
                });

                // Add event button click handler
                document.querySelector('.add-event').addEventListener('click', function() {
                    const modal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    modal.show();
                });

            } catch (error) {
                console.error('Error initializing calendar:', error);
            }
        });
        </script>
    </x-slot>

</x-app-layout>
