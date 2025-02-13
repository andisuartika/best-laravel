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
                <span>Tiket Destinasi Wisata</span>
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
            <span class="ltr:mr-3 rtl:ml-3">Tiket Destinasi: </span>Daftar Harga Tiket Destinasi Wisata
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
                            <div class="font-semibold mb-1.5">Filter Destinasi</div>
                            <select id='destinationFilter'
                                class="destinationSelect selectize form-select form-select-xl text-white-dark"
                                name="destination">
                                <option value="">Pilih Destinasi</option>
                                <option value="all">
                                    Semua
                                </option>
                                @foreach ($destinations as $destination)
                                    <option value="{{ $destination->code }}"
                                        {{ old('destination') == $destination->code ? 'selected' : '' }}>
                                        {{ $destination->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                @endif
                <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                    <div class="flex gap-3">
                        <div>
                            <a href="{{ route('ticket.create') }}" type="button" class="btn btn-primary">

                                <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.5"
                                        d="M14.0037 4H9.9963C6.21809 4 4.32899 4 3.15525 5.17157C2.27661 6.04858 2.0557 7.32572 2.00016 9.49444C1.99304 9.77248 2.22121 9.99467 2.49076 10.0652C3.35074 10.2901 3.98521 11.0711 3.98521 12C3.98521 12.9289 3.35074 13.7099 2.49076 13.9348C2.22121 14.0053 1.99304 14.2275 2.00016 14.5056C2.0557 16.6743 2.27661 17.9514 3.15525 18.8284C4.32899 20 6.21809 20 9.9963 20H14.0037C17.7819 20 19.671 20 20.8448 18.8284C21.7234 17.9514 21.9443 16.6743 21.9998 14.5056C22.007 14.2275 21.7788 14.0053 21.5092 13.9348C20.6493 13.7099 20.0148 12.9289 20.0148 12C20.0148 11.0711 20.6493 10.2901 21.5092 10.0652C21.7788 9.99467 22.007 9.77248 21.9998 9.49444C21.9443 7.32572 21.7234 6.04858 20.8448 5.17157C19.671 4 17.7819 4 14.0037 4Z"
                                        stroke="#ffff" stroke-width="1.5" />
                                    <path
                                        d="M11.1459 10.0225C11.5259 9.34084 11.7159 9 12 9C12.2841 9 12.4741 9.34084 12.8541 10.0225L12.9524 10.1989C13.0603 10.3926 13.1143 10.4894 13.1985 10.5533C13.2827 10.6172 13.3875 10.641 13.5972 10.6884L13.7881 10.7316C14.526 10.8986 14.895 10.982 14.9828 11.2643C15.0706 11.5466 14.819 11.8407 14.316 12.429L14.1858 12.5812C14.0429 12.7483 13.9714 12.8319 13.9392 12.9353C13.9071 13.0387 13.9179 13.1502 13.9395 13.3733L13.9592 13.5763C14.0352 14.3612 14.0733 14.7536 13.8435 14.9281C13.6136 15.1025 13.2682 14.9435 12.5773 14.6254L12.3986 14.5431C12.2022 14.4527 12.1041 14.4075 12 14.4075C11.8959 14.4075 11.7978 14.4527 11.6014 14.5431L11.4227 14.6254C10.7318 14.9435 10.3864 15.1025 10.1565 14.9281C9.92674 14.7536 9.96476 14.3612 10.0408 13.5763L10.0605 13.3733C10.0821 13.1502 10.0929 13.0387 10.0608 12.9353C10.0286 12.8319 9.95713 12.7483 9.81418 12.5812L9.68403 12.429C9.18097 11.8407 8.92945 11.5466 9.01723 11.2643C9.10501 10.982 9.47396 10.8986 10.2119 10.7316L10.4028 10.6884C10.6125 10.641 10.7173 10.6172 10.8015 10.5533C10.8857 10.4894 10.9397 10.3926 11.0476 10.1989L11.1459 10.0225Z"
                                        stroke="#ffff" stroke-width="1.5" />
                                </svg>

                                Tambah Tiket Destinasi
                            </a>
                        </div>
                    </div>
                    <div class="relative ">
                        <form method="GET">
                            <input type="text" name="search" placeholder="Cari Tiket"
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
                                    <th>Destinasi</th>
                                    <th>Tiket</th>
                                    <th>Tanggal</th>
                                    <th>Harga</th>
                                    <th class="!text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tickets as $ticket)
                                    <tr>
                                        <td>
                                            <div>{{ $ticket->destination()->get()->implode('name') }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $ticket->name }}</div>
                                        </td>
                                        <td>
                                            <div>
                                                @isset($ticket->valid_from)
                                                    {{ $ticket->valid_from }} to {{ $ticket->valid_to }}
                                                @else
                                                    -
                                                @endisset

                                            </div>
                                        </td>
                                        <td>
                                            <div>@currency($ticket->price)</div>
                                        </td>
                                        <td>
                                            <div class="flex gap-4 items-center justify-center">

                                                <a href="{{ route('ticket.edit', $ticket) }}" type="button"
                                                    class="btn btn-sm btn-outline-primary">Ubah</a>
                                                <form action="{{ route('ticket.destroy', $ticket) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id" value="{{ $ticket->id }}">
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
            $('#destinationFilter').change(function() {
                var destinationCode = $(this).val();
                if (destinationCode == 'all') {
                    window.location.href = "{{ route('ticket.index') }}";
                } else {
                    window.location.href = "{{ route('ticket.index') }}?destination=" + destinationCode;
                }
            });
        });
    </script>


    {{-- Select2 --}}
    <script>
        $(document).ready(function() {
            $('.destinationSelect').select2({
                placeholder: 'Pilih Destinasi',
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
