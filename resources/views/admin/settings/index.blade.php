<x-app-layout>
    <x-slot name="header">
        <ul class="flex-align gap-4">
            <li><a href="{{ route('dashboard') }}" class="text-gray-200 fw-normal text-15 hover-text-main-600">Home</a></li>
            <li> <span class="text-gray-500 fw-normal d-flex"><i class="ph ph-caret-right"></i></span> </li>
            <li><span class="text-main-600 fw-normal text-15">{{ __('Pengaturan Website') }}</span></li>
        </ul>
    </x-slot>

    <x-slot name="headerTitle">
        Pengaturan Website
    </x-slot>

    <main>
        @if (session('success'))
            <div class="alert alert-success mb-10">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger mb-10">
                {{ session('error') }}
            </div>
        @endif

        <div class="card overflow-hidden px-8 py-8">
            <div class="card-body">
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        @foreach ($pengaturan as $key => $value)
                        <div class="col-md-6 mb-4">
                            <div class="form-group">
                                <label for="{{ $key }}" class="form-label text-gray-600 fw-medium mb-2">
                                    {{ ucwords(str_replace('_', ' ', $key)) }}
                                </label>
                                <input type="text" 
                                    class="form-control rounded-3 border-gray-200 @error($key) is-invalid @enderror" 
                                    id="{{ $key }}" 
                                    name="{{ $key }}"
                                    value="{{ old($key, $value) }}"
                                    placeholder="Masukkan {{ strtolower(str_replace('_', ' ', $key)) }}">
                                @error($key)
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-main text-white rounded-pill px-24 py-12">
                            <i class="ph ph-floppy-disk me-2"></i>
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </main>
</x-app-layout>
