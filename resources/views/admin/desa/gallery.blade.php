<x-layout.default>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel='stylesheet' type='text/css' media='screen' href="{{ Vite::asset('resources/css/fancybox.css') }}">
    <script src="/assets/js/fancybox.umd.js"></script>

    <div x-data="invoiceList">

        <ul class="flex space-x-2 mb-5 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Profil Desa</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Galeri Desa</span>
            </li>
        </ul>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-6 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 md:mb-5">
                    @foreach ($galleries as $i => $gallery)
                        <div
                            class="max-w-[22rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                            <div class="py-7 px-6">
                                <div class="-mt-7 mb-7 -mx-6 rounded-tl rounded-tr h-[260px] overflow-hidden">
                                    <a href="javascript:;" class="md:row-span-2 md:col-span-2">
                                        <img src="{{ asset($gallery->image) }}" alt="image-gallery"
                                            data-fancybox="gallery" class="rounded-md w-full h-full object-cover" />
                                    </a>
                                </div>
                                <p class="text-primary text-xs mb-1.5 font-bold">
                                    {{ $gallery->created_at->DiffForHumans() }}</p>
                                <h5 class="text-[#3b3f5c] text-[15px] font-bold mb-4 dark:text-white-light">
                                    {{ $gallery->title ?? '............' }}</h5>
                                <p class="text-white-dark ">
                                    {{ $gallery->description ?? '............' }}</p>
                                <form action="{{ route('delete.gallery-desa') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="id" value="{{ $gallery->id }}">
                                    <button type="button" class="btn btn-danger mt-6 delete_confirm">Hapus
                                        Gambar</button>
                                </form>
                            </div>
                        </div>
                    @endforeach

                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel mb-5">
                    <form action="{{ route('store.gallery-desa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-2xl font-semibold uppercase mb-5">Tambah Gambar</div>
                        <div>
                            <label for="title">Judul</label>
                            <input class="form-input" type="text" name="title" placeholder="Judul Gambar">
                        </div>
                        <div class="mt-4">
                            <label for="description">Deskripsi</label>
                            <textarea id="description" name="description" rows="3" class="form-textarea"
                                placeholder="Deskripsi Gambar"></textarea>
                        </div>
                        <div class="mt-4">
                            <div>
                                <label for="image">Gambar </label>
                                <input id="image" type="file"
                                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                                    onchange="readURL(this);" name="image" required />
                                <div class="mt-4">
                                    <img id="preview" src="{{ asset('assets/images/file-preview.svg') }}"
                                        alt="your image" class="rounded-md m-auto object-fit"style="width: 746px;" />
                                </div>
                                <script>
                                    function readURL(input) {
                                        if (input.files && input.files[0]) {
                                            var reader = new FileReader();

                                            reader.onload = function(e) {
                                                $('#preview')
                                                    .attr('src', e.target.result);
                                            };

                                            reader.readAsDataURL(input.files[0]);
                                        }
                                    }
                                </script>
                            </div>
                        </div>
                        <div class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4 mt-5">
                            <button type="sumbit" class="btn btn-success w-full gap-2">

                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                    <path
                                        d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path
                                        d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path opacity="0.5" d="M7 8H13" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" />
                                </svg>
                                Simpan </button>
                        </div>
                    </form>
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
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"
        integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
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
                        title: 'Apakah anda yakin?',
                        text: "Anda tidak akan bisa mengembalikannya!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        cancelButtonText: 'Batal',
                        confirmButtonText: 'Ya, hapus!'
                    })
                    .then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
            });

        });
    </script>
    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <!-- end hightlight js -->
</x-layout.default>
