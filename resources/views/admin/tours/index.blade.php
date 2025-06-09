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
                <a href="{{ route('tours.index') }}" class="text-primary hover:underline">Paket Tour Wisata</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Tour</span>
            </li>
        </ul>
        <div
            class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary __web-inspector-hide-shortcut__ my-6">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M9.20646 3.18191C8.95433 3.26179 8.70533 3.35257 8.46018 3.45411C7.33792 3.91897 6.3182 4.60032 5.45926 5.45926C4.60032 6.3182 3.91897 7.33792 3.45411 8.46018C3.0852 9.35081 2.85837 10.2922 2.78045 11.25H7.26094C7.29294 10.1541 7.39498 9.0741 7.56457 8.05057C7.7725 6.79558 8.07972 5.63914 8.47522 4.65039C8.69114 4.11057 8.9351 3.61641 9.20646 3.18191ZM12 1.25C10.5883 1.25 9.1904 1.52806 7.88615 2.06829C6.5819 2.60853 5.39683 3.40037 4.3986 4.3986C3.40037 5.39683 2.60853 6.5819 2.0683 7.88615C1.52806 9.1904 1.25 10.5883 1.25 12C1.25 13.4117 1.52806 14.8096 2.06829 16.1138C2.60853 17.4181 3.40037 18.6032 4.3986 19.6014C5.39683 20.5996 6.5819 21.3915 7.88615 21.9317C9.1904 22.4719 10.5883 22.75 12 22.75C13.4117 22.75 14.8096 22.4719 16.1138 21.9317C17.4181 21.3915 18.6032 20.5996 19.6014 19.6014C20.5996 18.6032 21.3915 17.4181 21.9317 16.1138C22.4719 14.8096 22.75 13.4117 22.75 12C22.75 10.5883 22.4719 9.1904 21.9317 7.88615C21.3915 6.5819 20.5996 5.39683 19.6014 4.3986C18.6032 3.40037 17.4181 2.60853 16.1138 2.0683C14.8096 1.52806 13.4117 1.25 12 1.25ZM12 2.75C11.7387 2.75 11.4012 2.87579 11.0088 3.2822C10.6134 3.69161 10.2176 4.33326 9.86793 5.20747C9.52056 6.07589 9.2385 7.12424 9.04439 8.29576C8.88866 9.23569 8.79316 10.2331 8.76162 11.25L15.2384 11.25C15.2068 10.2331 15.1113 9.23569 14.9556 8.29576C14.7615 7.12424 14.4794 6.0759 14.1321 5.20748C13.7824 4.33326 13.3866 3.69161 12.9912 3.2822C12.5988 2.87579 12.2613 2.75 12 2.75ZM16.7391 11.25C16.7071 10.1541 16.605 9.07411 16.4354 8.05057C16.2275 6.79558 15.9203 5.63914 15.5248 4.65039C15.3089 4.11057 15.0649 3.61641 14.7935 3.18191C15.0457 3.26179 15.2947 3.35257 15.5398 3.45411C16.6621 3.91897 17.6818 4.60032 18.5407 5.45926C19.3997 6.31821 20.081 7.33792 20.5459 8.46018C20.9148 9.35082 21.1416 10.2922 21.2195 11.25H16.7391ZM15.2384 12.75L8.76162 12.75C8.79316 13.7669 8.88866 14.7643 9.04439 15.7042C9.2385 16.8758 9.52056 17.9241 9.86793 18.7925C10.2176 19.6667 10.6134 20.3084 11.0088 20.7178C11.4012 21.1242 11.7387 21.25 12 21.25C12.2613 21.25 12.5988 21.1242 12.9912 20.7178C13.3866 20.3084 13.7824 19.6667 14.1321 18.7925C14.4794 17.9241 14.7615 16.8758 14.9556 15.7042C15.1113 14.7643 15.2068 13.7669 15.2384 12.75ZM14.7935 20.8181C15.0649 20.3836 15.3089 19.8894 15.5248 19.3496C15.9203 18.3609 16.2275 17.2044 16.4354 15.9494C16.605 14.9259 16.7071 13.8459 16.7391 12.75H21.2195C21.1416 13.7078 20.9148 14.6492 20.5459 15.5398C20.081 16.6621 19.3997 17.6818 18.5407 18.5407C17.6818 19.3997 16.6621 20.081 15.5398 20.5459C15.2947 20.6474 15.0457 20.7382 14.7935 20.8181ZM9.20646 20.8181C8.9351 20.3836 8.69114 19.8894 8.47521 19.3496C8.07971 18.3609 7.7725 17.2044 7.56457 15.9494C7.39498 14.9259 7.29294 13.8459 7.26094 12.75H2.78045C2.85837 13.7078 3.0852 14.6492 3.45411 15.5398C3.91897 16.6621 4.60032 17.6818 5.45926 18.5407C6.3182 19.3997 7.33792 20.081 8.46018 20.5459C8.70533 20.6474 8.95433 20.7382 9.20646 20.8181Z"
                        fill="#ffff" />
                </svg>
            </div>
            <span class="ltr:mr-3 rtl:ml-3">Peket Tour Wisata: </span>Daftar Paket Tour Wisata Desa
            {{ Auth::user()->village()->get()->implode('name') }}
        </div>
        <div class="panel p-0 flex-1">
            <div class="md:flex items-center flex-wrap p-4 border-b border-[#ebedf2] dark:border-[#191e3a]">
                {{-- <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                </div> --}}
                @if (Auth::user()->hasRole('pengelola'))
                    <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                    </div>
                @elseif (Auth::user()->hasRole('admin'))
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
                @elseif (Auth::user()->hasRole('super admin'))
                <div class="flex-1 flex items-start ltr:pr-4 rtl:pl-4">
                    <div class="">
                        <div class="font-semibold mb-1.5">Filter Desa Wisata</div>
                        <select id='villageFilter'
                            class="villageSelect selectize form-select form-select-xl text-white-dark" name="village">
                            <option value="">Pilih Desa Wisata</option>
                            <option value="all">
                                Semua
                            </option>
                            @foreach ($villages as $village)
                                <option value="{{ $village->code }}"
                                    {{ old('village') == $village->code ? 'selected' : '' }}>
                                    {{ $village->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                @endif
                <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                    <div class="flex gap-3">
                        <div>
                            @if(!Auth::user()->hasRole('super admin'))
                            <a href="{{ route('tours.create') }}" type="button" class="btn btn-primary">

                                <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path opacity="0.5"
                                        d="M2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C22 4.92893 22 7.28595 22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12Z"
                                        stroke="#ffff" stroke-width="1.5" />
                                    <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="#ffff"
                                        stroke-width="1.5" stroke-linecap="round" />
                                </svg>


                                Tambah Paket Tour
                            </a>
                            @endif
                        </div>
                    </div>
                    <div class="relative ">
                        <form method="GET">
                            <input type="text" name="search" placeholder="Cari Paket Tour"
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
                                    <th>Pengelola</th>
                                    <th>Nama Paket Tour</th>
                                    <th>Harga</th>
                                    <th class="!text-center">Status</th>
                                    <th class="!text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($tours as $tour)
                                    <tr>
                                        <td>
                                            <div>{{ $tour->code }}</div>
                                        </td>
                                        <td>{{ $tour->user()->get()->implode('name') }}</td>
                                        <td>
                                            <div class="flex items-center font-semibold">
                                                <div
                                                    class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                        src="{{ asset($tour->thumbnail) }}">
                                                </div>
                                                <div>{{ $tour->name }}</div>
                                            </div>
                                        </td>

                                        <td class="whitespace-nowrap">
                                            @currency($tour->rates->first()->price ?? 0)
                                        </td>
                                        @if(!Auth::user()->hasRole('super admin'))
                                        <td>
                                            <!-- vertically centered -->
                                            <div class="mb-5" x-data="modal">
                                                <!-- button -->
                                                <div class="flex items-center justify-center">
                                                    <a href="#" @click="toggle">
                                                        <span
                                                            class="badge whitespace-nowrap {{ $tour->status === 'AVAILABLE' ? 'bg-success' : ($tour->status === 'NOT-AVAILABLE' ? 'bg-danger' : '') }}">{{ $tour->status }}
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
                                                                <h5 class="font-bold text-lg">Ubah Status Paket Tour
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
                                                                <form action="{{ route('tours.updateStatus') }}"
                                                                    method="POST">
                                                                    @csrf
                                                                    <div
                                                                        class="dark:text-white-dark/70 text-base font-medium text-[#1f2937]">
                                                                        <div>
                                                                            <label for="status">Status
                                                                                Paket Tour Wisata</label>
                                                                            <select id="status" name="status"
                                                                                class="form-select text-white-dark"
                                                                                required>
                                                                                <option value="AVAILABLE"
                                                                                    {{ $tour->status == 'AVAILABLE' ? 'selected' : '' }}>
                                                                                    AVAILABLE</option>
                                                                                <option value="NOT-AVAILABLE"
                                                                                    {{ $tour->status == 'NOT-AVAILABLE' ? 'selected' : '' }}>
                                                                                    NOT AVAILABLE</option>
                                                                            </select>
                                                                        </div>
                                                                    </div>
                                                                    <input type="hidden" name="id"
                                                                        value="{{ $tour->id }}">
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
                                                <a href="{{ route('tours.edit', $tour) }}" type="button"
                                                    class="btn btn-sm btn-outline-primary">Ubah</a>
                                                <form action="{{ route('tours.destroy', $tour) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <input type="hidden" name="id"
                                                        value="{{ $tour->id }}">
                                                    <a href="javascript:;"
                                                        class="btn btn-sm btn-outline-danger delete_confirm">Hapus</a>
                                                </form>
                                            </div>
                                        </td>
                                        @else
                                        <td>
                                            <span
                                            class="badge whitespace-nowrap {{ $tour->status === 'AVAILABLE' ? 'bg-success' : ($tour->status === 'NOT-AVAILABLE' ? 'bg-danger' : '') }}">{{ $tour->status }}
                                        </span>
                                        </td>
                                        <td>
                                            <div class="flex gap-2 items-center justify-center">
                                                <a href="#" type="button"
                                                    class="btn btn-sm btn-outline-primary">Lihat Detail</a>
                                            </div>
                                        </td>
                                        @endif
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
                    window.location.href = "{{ route('tours.index') }}";
                } else {
                    window.location.href = "{{ route('tours.index') }}?manager=" + managerCode;
                }
            });
        });

        $(document).ready(function() {
            $('#villageFilter').change(function() {
                var villageCode = $(this).val();
                if (villageCode == 'all') {
                    window.location.href = "{{ route('packages') }}";
                } else {
                    window.location.href = "{{ route('packages') }}?village=" + villageCode;
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
        $(document).ready(function() {
            $('.villageSelect').select2({
                placeholder: 'Pilih Desa Wisata',
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
