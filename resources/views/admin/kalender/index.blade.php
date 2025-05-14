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

    <main>
        <div class="card mt-24 bg-transparent">
            <div class="card-body p-0">
                <div id='wrap'>
                    <div id='calendar' class="position-relative">
                        <button type="button" class="add-event btn btn-main text-sm btn-sm px-24 rounded-pill py-12 d-flex align-items-center gap-2" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="ph ph-plus me-4"></i>
                            Tambah Event
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
                        <h1 class="modal-title fs-5" id="exampleModalLabel">Tambah Event Baru</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-24">
                        <form id="addEventForm">
                            <div class="row">   
                                <div class="col-12 mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Judul Event:</label>
                                    <input type="text" class="form-control radius-8" placeholder="Masukkan Judul Event">
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
                        <h1 class="modal-title fs-5" id="editEventModalLabel">Edit Event</h1>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-24">
                        <form id="editEventForm">
                            <div class="row">   
                                <div class="col-12 mb-20">
                                    <label class="form-label fw-semibold text-primary-light text-sm mb-8">Judul Event:</label>
                                    <input type="text" id="editEventTitle" class="form-control radius-8" placeholder="Masukkan Judul Event">
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
                                    <label for="editEventType" class="form-label fw-semibold text-primary-light text-sm mb-8">Tipe Event</label>
                                    <select id="editEventType" class="form-control radius-8">
                                        <option value="normal">Normal</option>
                                        <option value="important">Important</option>
                                        <option value="info">Info</option>
                                    </select>
                                </div>

                                <div class="d-flex align-items-center justify-content-center gap-8 mt-24">
                                    <button type="button" class="btn bg-danger-600 hover-bg-danger-800 border-danger-600 hover-border-danger-800 text-md px-24 py-12 radius-8" data-bs-dismiss="modal">
                                        Batal
                                    </button>
                                    <button type="submit" class="btn bg-main-600 hover-bg-main-800 border-main-600 hover-border-main-800 text-md px-24 py-12 radius-8">
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
    <script>
        // Wait for all scripts to be loaded
        document.addEventListener('DOMContentLoaded', function() {            
            // Check if FullCalendar is available
            if (typeof $.fullCalendar === 'undefined') {
                console.error('FullCalendar is not loaded!');
                return;
            }
            
            // Check if jQuery is available
            if (typeof $ === 'undefined') {
                console.error('jQuery is not loaded!');
                return;
            }
            
            // Check if Bootstrap is available
            if (typeof bootstrap === 'undefined') {
                console.error('Bootstrap is not loaded!');
                return;
            }
            
            // Listen for calendarDayClick event
            $(document).on('calendarDayClick', function(event, date) {
                // Format the date for display
                const formattedDate = date;
                console.log(date);
                
                // Set the date in the modal
                $('#startDate').val(formattedDate);
                $('#endDate').val(formattedDate);
                
                // Try to show modal using jQuery
                try {
                    // fill the modal with the data
                    $('#editEventTitle').val(event.title);
                    $('#editStartDate').val(formattedDate);
                    $('#editEndDate').val(formattedDate);
                    $('#editDesc').val(event.description);
                    $('#editEventType').val(event.type);
                    $('#editEventModal').modal('show');
                    console.log('Modal show command executed');
                } catch (error) {
                    console.error('Error showing modal:', error);
                }
            });

            // Handle form submission
            $('#exampleModal form').on('submit', function(e) {
                e.preventDefault();
                console.log('Form submitted');
                
                const title = $(this).find('input[type="text"]').val();
                const startDate = $('#startDate').val();
                const endDate = $('#endDate').val();
                const description = $('#desc').val();
                
                if (!title) {
                    alert('Judul event harus diisi');
                    return;
                }
                
                const eventData = {
                    title: title,
                    start: startDate,
                    end: endDate,
                    description: description,
                    allDay: true
                };
                
                console.log('Adding event:', eventData);
                $('#calendar').fullCalendar('renderEvent', eventData, true);
                
                // Close the modal
                $('#exampleModal').modal('hide');
                
                // Reset the form
                this.reset();
                
                // Show success message
                alert(`Event "${title}" berhasil ditambahkan.`);
            });

            // Add click handler to test modal directly
            $('.add-event').on('click', function() {
                console.log('Add event button clicked');
                $('#exampleModal').modal('show');
            });
        });
    </script>
    @endpush

</x-app-layout>