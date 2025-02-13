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
                <a href="javaScript():;" class="text-primary hover:underline">Akomodasi</a>
            </li>
        </ul>
        <div
            class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary __web-inspector-hide-shortcut__ my-6">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M4 10C4 6.22876 4 4.34315 5.17157 3.17157C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.17157C20 4.34315 20 6.22876 20 10V12C20 15.7712 20 17.6569 18.8284 18.8284C17.6569 20 15.7712 20 12 20C8.22876 20 6.34315 20 5.17157 18.8284C4 17.6569 4 15.7712 4 12V10Z"
                        stroke="#ffff" stroke-width="1.5" />
                    <path d="M4 13H20" stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M15.5 16H17" stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M7 16H8.5" stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round" />
                    <path d="M6 19.5V21C6 21.5523 6.44772 22 7 22H8.5C9.05228 22 9.5 21.5523 9.5 21V20" stroke="#ffff"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M18 19.5V21C18 21.5523 17.5523 22 17 22H15.5C14.9477 22 14.5 21.5523 14.5 21V20"
                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M20 9H21C21.5523 9 22 9.44772 22 10V11C22 11.3148 21.8518 11.6111 21.6 11.8L20 13"
                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M4 9H3C2.44772 9 2 9.44772 2 10V11C2 11.3148 2.14819 11.6111 2.4 11.8L4 13" stroke="#ffff"
                        stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <path d="M19.5 5H4.5" stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                </svg>


            </div>
            <span class="ltr:mr-3 rtl:ml-3">Akomodasi Transportasi: </span>Daftar Transportasi Desa
            {{ Auth::user()->village()->get()->implode('name') }}
        </div>
        <div class="panel p-0 flex-1">
            <div class="md:flex items-center flex-wrap p-4 border-b border-[#ebedf2] dark:border-[#191e3a]">
                {{-- <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                </div> --}}
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
                <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                    <div class="flex gap-3">
                        <div>
                            <a href="{{ route('transportations.create') }}" type="button" class="btn btn-primary">

                                <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M4 10C4 6.22876 4 4.34315 5.17157 3.17157C6.34315 2 8.22876 2 12 2C15.7712 2 17.6569 2 18.8284 3.17157C20 4.34315 20 6.22876 20 10V12C20 15.7712 20 17.6569 18.8284 18.8284C17.6569 20 15.7712 20 12 20C8.22876 20 6.34315 20 5.17157 18.8284C4 17.6569 4 15.7712 4 12V10Z"
                                        stroke="#ffff" stroke-width="1.5" />
                                    <path opacity="0.5" d="M4 13H20" stroke="#ffff" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                    <path d="M15.5 16H17" stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path d="M7 16H8.5" stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path opacity="0.5"
                                        d="M6 19.5V21C6 21.5523 6.44772 22 7 22H8.5C9.05228 22 9.5 21.5523 9.5 21V20"
                                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path opacity="0.5"
                                        d="M18 19.5V21C18 21.5523 17.5523 22 17 22H15.5C14.9477 22 14.5 21.5523 14.5 21V20"
                                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path opacity="0.5"
                                        d="M20 9H21C21.5523 9 22 9.44772 22 10V11C22 11.3148 21.8518 11.6111 21.6 11.8L20 13"
                                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path opacity="0.5"
                                        d="M4 9H3C2.44772 9 2 9.44772 2 10V11C2 11.3148 2.14819 11.6111 2.4 11.8L4 13"
                                        stroke="#ffff" stroke-width="1.5" stroke-linecap="round"
                                        stroke-linejoin="round" />
                                    <path opacity="0.5" d="M19.5 5H4.5" stroke="#ffff" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>


                                Tambah Transportasi
                            </a>
                        </div>
                    </div>
                    <div class="relative ">
                        <form method="GET">
                            <input type="text" name="search" placeholder="Cari Transportasi"
                                class="form-input py-2 ltr:pr-11 rtl:pl-11 peer"
                                value="{{ request('search', '') }}" />
                            <div
                                class="absolute ltr:right-[11px] rtl:left-[11px] top-1/2 -translate-y-1/2 peer-focus:text-primary">

                                <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24"
                                    fill="none" xmlns="http://www.w3.org/2000/svg">
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
                                    <th>Kode</th>
                                    <th>Nama</th>
                                    <th>Harga</th>
                                    <th>Pengelola</th>
                                    <th>Harga Tambahan</th>
                                    <th class="!text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transportations as $transportation)
                                    <tr>
                                        <td>
                                            <div>{{ $transportation->code }}</div>
                                        </td>
                                        <td>
                                            <div class="flex items-center font-semibold">
                                                <div
                                                    class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                        src="{{ asset($transportation->image) }}">
                                                </div>
                                                <div>{{ $transportation->name }}</div>
                                            </div>
                                        </td>
                                        <td> {{ $transportation->user()->get()->implode('name') }}</td>
                                        <td class="whitespace-nowrap">
                                            @currency($transportation->price)
                                        </td>
                                        <td>
                                            @currency($transportation->extra_price)
                                        </td>
                                        <td>
                                            <div class="flex gap-2 items-center justify-center">
                                                <a href="{{ route('transportations.edit', $transportation) }}"
                                                    type="button" class="btn btn-sm btn-outline-primary">Ubah</a>
                                                <form action="{{ route('transportations.destroy', $transportation) }}"
                                                    method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id"
                                                        value="{{ $transportation->id }}">
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
                    window.location.href = "{{ route('transportations.index') }}";
                } else {
                    window.location.href = "{{ route('transportations.index') }}?manager=" + managerCode;
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
