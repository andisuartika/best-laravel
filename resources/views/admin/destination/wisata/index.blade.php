<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="/assets/js/file-upload-with-preview.iife.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link rel='stylesheet' type='text/css' href='{{ Vite::asset('resources/css/nice-select2.css') }}'>
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/flatpickr.min.css') }}">
    <script src="/assets/js/flatpickr.js"></script>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('destination.index') }}" class="text-primary hover:underline">Destinasi Wisata</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Lokasi Wisata</span>
            </li>
        </ul>
        <div
            class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary __web-inspector-hide-shortcut__ my-6">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path d="M22 22L2 22" stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M2 11L10.1259 4.49931C11.2216 3.62279 12.7784 3.62279 13.8741 4.49931L22 11" stroke="#ffff"
                        stroke-width="1.5" stroke-linecap="round" />
                    <path d="M15.5 5.5V3.5C15.5 3.22386 15.7239 3 16 3H18.5C18.7761 3 19 3.22386 19 3.5V8.5"
                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M4 22V9.5" stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                    <path d="M20 22V9.5" stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                    <path
                        d="M15 22V17C15 15.5858 15 14.8787 14.5607 14.4393C14.1213 14 13.4142 14 12 14C10.5858 14 9.87868 14 9.43934 14.4393C9 14.8787 9 15.5858 9 17V22"
                        stroke="#ffff" stroke-width="1.5" />
                    <path
                        d="M14 9.5C14 10.6046 13.1046 11.5 12 11.5C10.8954 11.5 10 10.6046 10 9.5C10 8.39543 10.8954 7.5 12 7.5C13.1046 7.5 14 8.39543 14 9.5Z"
                        stroke="#ffff" stroke-width="1.5" />
                </svg>

            </div>
            <span class="ltr:mr-3 rtl:ml-3">Lokasi Wisata: </span>Daftar Lokasi Destinasi Wisata
        </div>
        <div class="panel p-0 flex-1">
            <div class="md:flex items-center flex-wrap p-4 border-b border-[#ebedf2] dark:border-[#191e3a]">
                {{-- <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                </div> --}}
                @if (Auth::user()->hasRole('pengelola'))
                    <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                    </div>
                @else
                    <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                        <div class="">
                            <div class="font-semibold mb-1.5">Filter Pengelola</div>
                            <select id='managerFilter'
                                class="managerSelect selectize form-select form-select-xl text-white-dark" name="manager">
                                <option value="">Pilih Pengelola</option>
                                <option value="all">
                                    Semua
                                </option>
                                @foreach ($managers as $manager)
                                    <option value="{{ $manager->id }}"
                                        {{ old('manager') == $manager->id ? 'selected' : '' }}>
                                        {{ $manager->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                @endif
                <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                    <div class="flex gap-3">
                        <div>
                            <a href="{{ route('destination.create') }}" type="button" class="btn btn-primary">

                                <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.5"
                                        d="M4 10.1433C4 5.64588 7.58172 2 12 2C16.4183 2 20 5.64588 20 10.1433C20 14.6055 17.4467 19.8124 13.4629 21.6744C12.5343 22.1085 11.4657 22.1085 10.5371 21.6744C6.55332 19.8124 4 14.6055 4 10.1433Z"
                                        stroke="#ffff" stroke-width="1.5" />
                                    <path d="M9.5 10H14.5M12 12.5L12 7.5" stroke="#ffff" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>

                                Tambah Destinasi Wisata
                            </a>
                        </div>
                    </div>
                    <div class="relative ">
                        <form method="GET">
                            <input type="text" name="search" placeholder="Cari Destinasi"
                                class="form-input py-2 ltr:pr-11 rtl:pl-11 peer" value="{{ request('search', '') }}" />
                            <div
                                class="absolute ltr:right-[11px] rtl:left-[11px] top-1/2 -translate-y-1/2 peer-focus:text-primary">

                                <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor"
                                        stroke-width="1.5" opacity="0.5"></circle>
                                    <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round">
                                    </path>
                                </svg>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="p-4 mb-5 border-b border-[#ebedf2] dark:border-[#253b5c] grid grid-rows-1 sm:grid-cols-4 gap-4">
                <div>
                </div>
            </div>
            <div class="panel flex-1 px-4 overflow-hidden">
                <div class="mt-5 p-0 border-0 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Alamat</th>
                                    <th>Pengelola</th>
                                    <th class="!text-center">Status</th>
                                    <th class="!text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($destinations as $destination)
                                    <tr>
                                        <td>
                                            <div>{{ $destination->code }}</div>
                                        </td>
                                        <td>
                                            <div class="flex items-center font-semibold">
                                                <div
                                                    class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                        src="{{ asset($destination->thumbnail) }}">
                                                </div>
                                                <div>{{ $destination->name }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $destination->address }}</td>
                                        <td class="whitespace-nowrap">
                                            {{ $destination->user()->get()->implode('name') }}
                                        </td>
                                        <td>
                                            <!-- vertically centered -->
                                            <div class="mb-5" x-data="modal">
                                                <!-- button -->
                                                <div class="flex items-center justify-center">
                                                    <a href="#" @click="toggle">
                                                        <span
                                                            class="badge whitespace-nowrap {{ $destination->status === 'OPEN'
                                                                ? 'bg-success'
                                                                : ($destination->status === 'CLOSED'
                                                                    ? 'bg-danger'
                                                                    : ($destination->status === 'TEMPORARY CLOSED'
                                                                        ? 'bg-warning'
                                                                        : '')) }}">{{ $destination->status }}
                                                        </span>
                                                    </a>
                                                </div>
                                                <!-- modal -->
                                                <div class="fixed inset-0 bg-[black]/60 z-[999] hidden overflow-y-auto"
                                                    :class="open && '!block'">
                                                    <div class="flex items-center justify-center min-h-screen px-4"
                                                        @click.self="open = false">
                                                        <div x-show="open" x-transition x-transition.duration.300
                                                            class="panel border-0 p-0 rounded-lg overflow-hidden w-full max-w-lg my-8">
                                                            <div
                                                                class="flex bg-[#fbfbfb] dark:bg-[#121c2c] items-center justify-between px-5 py-3">
                                                                <h5 class="font-bold text-lg">Ubah Status Destinasi
                                                                    Wisata</h5>
                                                                <button type="button"
                                                                    class="text-white-dark hover:text-dark"
                                                                    @click="toggle">
                                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                                        width="24px" height="24px"
                                                                        viewBox="0 0 24 24" fill="none"
                                                                        stroke="currentColor" stroke-width="1.5"
                                                                        stroke-linecap="round" stroke-linejoin="round"
                                                                        class="h-6 w-6">
                                                                        <line x1="18" y1="6"
                                                                            x2="6" y2="18"></line>
                                                                        <line x1="6" y1="6"
                                                                            x2="18" y2="18"></line>
                                                                    </svg>
                                                                </button>
                                                            </div>
                                                            <div class="p-5">
                                                                <form
                                                                    action="{{ route('destination.updateStatus', $destination) }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div
                                                                        class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                                                                        <div>
                                                                            <label for="status">Status
                                                                                Destinasi</label>
                                                                            <select id="status" name="status"
                                                                                class="form-select text-white-dark"
                                                                                required>
                                                                                <option value="OPEN"
                                                                                    {{ $destination->status == 'OPEN' ? 'selected' : '' }}>
                                                                                    OPEN</option>
                                                                                <option value="TEMPORARY CLOSED"
                                                                                    {{ $destination->status == 'TEMPORARY CLOSED' ? 'selected' : '' }}>
                                                                                    TEMPORARY CLOSED</option>
                                                                                <option value="CLOSED"
                                                                                    {{ $destination->status == 'CLOSED' ? 'selected' : '' }}>
                                                                                    CLOSED</option>

                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <div class="flex justify-end items-center mt-8">
                                                                        <button type="button"
                                                                            class="btn btn-outline-danger"
                                                                            @click="toggle">Discard</button>
                                                                        <button type="submit"
                                                                            class="btn btn-primary ltr:ml-4 rtl:mr-4">Save</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                        </td>
                                        <td>
                                            <div class="flex gap-2 items-center justify-center">
                                                <a href="/ticket?destination={{ $destination->code }}"
                                                    type="button" class="btn btn-sm btn-outline-success">Tiket</a>
                                                <a href="{{ route('destination.gallery', $destination) }}"
                                                    type="button" class="btn btn-sm btn-outline-secondary">Galeri</a>
                                                <a href="{{ route('destination.edit', $destination) }}"
                                                    type="button" class="btn btn-sm btn-outline-primary">Ubah</a>
                                                <form action="{{ route('destination.destroy', $destination) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id"
                                                        value="{{ $destination->id }}">
                                                    <a href="javascript:;"
                                                        class="btn btn-sm btn-outline-danger delete_confirm">Hapus</a>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
    @if (session('success'))
        <script>
            const toast = window.Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
            });
            toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
                padding: '10px 20px',
            });
        </script>
    @endif
    <script>
        $(document).ready(function() {
            $('#managerFilter').change(function() {
                var managerCode = $(this).val();
                if (managerCode == 'all') {
                    window.location.href = "{{ route('destination.index') }}";
                } else {
                    window.location.href = "{{ route('destination.index') }}?manager=" + managerCode;
                }
            });
        });
    </script>


    {{-- Select2 --}}
    <script>
        $(document).ready(function() {
            $('.managerSelect').select2({
                placeholder: 'Pilih Pengelola',
            });
        });
    </script>
    <script>
        // DeleteConfirm
        $(document).ready(function() {

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $('.delete_confirm').click(function(e) {
                e.preventDefault();

                var deleteId = $(this).closest("tr").find('.delete_id').val();
                var form = $(this).closest("form");
                Swal.fire({
                        title: 'Apakah Anda yakin?',
                        text: "Anda tidak akan bisa mengembalikannya!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText : 'Batal',
                        confirmButtonText: 'Ya, hapus!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                            Swal.fire(
                                'Success',
                                'Room Deleted!',
                                'success'
                            )

                        }
                    })
            });

        });
    </script>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("modal", (initialOpenState = false) => ({
                open: initialOpenState,

                toggle() {
                    this.open = !this.open;
                },
            }));
        });
    </script>
</x-layout.default>
