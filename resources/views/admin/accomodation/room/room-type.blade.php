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
                <span>Akomodasi Wisata</span>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <a href="{{ route('homestays.index') }}" class="text-primary hover:underline">Penginapan</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Tipe Kamar</span>
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
            <span class="ltr:mr-3 rtl:ml-3">Tipe Kamar Penginapan: </span>Daftar Tipe Kamar Penginapan
        </div>
        <div class="panel p-0 flex-1">
            <div class="md:flex items-center flex-wrap p-4 border-b border-[#ebedf2] dark:border-[#191e3a]">
                {{-- <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                </div> --}}
                <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                    <div class="">
                        <div class="font-semibold mb-1.5">Filter Penginapan</div>
                        <select id='homestayFilter'
                            class="homestaySelect selectize form-select form-select-xl text-white-dark" name="homestay">
                            <option value="">Pilih Penginapan</option>
                            <option value="all">
                                Semua
                            </option>
                            @foreach ($homestays as $homestay)
                                <option value="{{ $homestay->code }}"
                                    {{ old('homestay') == $homestay->code ? 'selected' : '' }}>
                                    {{ $homestay->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                </div>
                <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                    <div class="flex gap-3">
                        <div>
                            <a href="{{ route('room-type.create') }}" type="button" class="btn btn-primary">

                                <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M22 22L2 22" stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                                    <path
                                        d="M3 22.0001V11.3472C3 10.4903 3.36644 9.67432 4.00691 9.10502L10.0069 3.77169C11.1436 2.76133 12.8564 2.76133 13.9931 3.77169L19.9931 9.10502C20.6336 9.67432 21 10.4903 21 11.3472V22.0001"
                                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                                    <path d="M10 9H14" stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                                    <path opacity="0.5" d="M9 15.5H15" stroke="#ffff" stroke-width="1.5"
                                        stroke-linecap="round" />
                                    <path opacity="0.5" d="M9 18.5H15" stroke="#ffff" stroke-width="1.5"
                                        stroke-linecap="round" />
                                    <path opacity="0.5"
                                        d="M18 22V16C18 14.1144 18 13.1716 17.4142 12.5858C16.8284 12 15.8856 12 14 12H10C8.11438 12 7.17157 12 6.58579 12.5858C6 13.1716 6 14.1144 6 16V22"
                                        stroke="#ffff" stroke-width="1.5" />
                                </svg>
                                Tambah Tipe Kamar
                            </a>
                        </div>
                    </div>
                    <div class="relative ">
                        <form method="GET">
                            <input type="text" name="search" placeholder="Cari Tipe Kamar"
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
            <div
                class="p-4 mb-5 border-b border-[#ebedf2] dark:border-[#253b5c] grid grid-rows-1 sm:grid-cols-4 gap-4">
                <div>
                </div>
            </div>
            <div class="panel flex-1 px-4 overflow-hidden">
                <div class="mt-5 p-0 border-0 overflow-hidden">
                    <div class="table-responsive">
                        <table class="table-striped table-hover">
                            <thead>
                                <tr>
                                    <th>Penginapan</th>
                                    <th>Nama</th>
                                    <th>Kapasitas</th>
                                    <th>Harga</th>
                                    <th class="!text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($allRoomType as $roomtype)
                                    <tr>
                                        <td>
                                            <div>{{ $roomtype->homestay()->get()->implode('name') }}</div>
                                        </td>
                                        <td>
                                            <div class="flex items-center font-semibold">
                                                <div
                                                    class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                        src="{{ asset($roomtype->thumbnail) }}">
                                                </div>
                                                <div>{{ $roomtype->name }}</div>
                                            </div>
                                        </td>
                                        <td>{{ $roomtype->capacity }}</td>
                                        <td>@currency($roomtype->price)</td>
                                        <td>
                                            <div class="flex gap-2 items-center justify-center">
                                                <a href="{{ route('room.gallery', $roomtype->id) }}" type="button"
                                                    class="btn btn-sm btn-outline-success">Galeri</a>
                                                <a href="{{ route('room-type.edit', $roomtype) }}" type="button"
                                                    class="btn btn-sm btn-outline-primary">Ubah</a>
                                                <form action="{{ route('room-type.destroy', $roomtype) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id"
                                                        value="{{ $roomtype->id }}">
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
            $('#homestayFilter').change(function() {
                var homestayCode = $(this).val();
                if (homestayCode == 'all') {
                    window.location.href = "{{ route('room-type.index') }}";
                } else {
                    window.location.href = "{{ route('room-type.index') }}?homestay=" + homestayCode;
                }
            });
        });
    </script>


    {{-- Select2 --}}
    <script>
        $(document).ready(function() {
            $('.homestaySelect').select2({
                placeholder: 'Pilih Penginapan',
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
