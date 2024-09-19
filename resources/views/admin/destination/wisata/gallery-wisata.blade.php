<x-layout.default>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="/assets/js/file-upload-with-preview.iife.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel='stylesheet' type='text/css' media='screen' href="{{ Vite::asset('resources/css/fancybox.css') }}">
    <script src="/assets/js/fancybox.umd.js"></script>
    <div>
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="{{ route('destination.index') }}" class="text-primary hover:underline">Destinasi Wisata</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <a href="{{ route('destination.index') }}" class="text-primary hover:underline">Lokasi Wisata</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Galeri</span>
            </li>
        </ul>
        <div
            class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary __web-inspector-hide-shortcut__ mt-3">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none"
                    xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" clip-rule="evenodd"
                        d="M4.25 8.51464C4.25 4.45264 7.77146 1.25 12 1.25C16.2285 1.25 19.75 4.45264 19.75 8.51464C19.75 12.3258 17.3871 16.8 13.5748 18.4292C12.574 18.8569 11.426 18.8569 10.4252 18.4292C6.61289 16.8 4.25 12.3258 4.25 8.51464ZM12 2.75C8.49655 2.75 5.75 5.38076 5.75 8.51464C5.75 11.843 7.85543 15.6998 11.0147 17.0499C11.639 17.3167 12.361 17.3167 12.9853 17.0499C16.1446 15.6998 18.25 11.843 18.25 8.51464C18.25 5.38076 15.5034 2.75 12 2.75ZM12 7.75C11.3096 7.75 10.75 8.30964 10.75 9C10.75 9.69036 11.3096 10.25 12 10.25C12.6904 10.25 13.25 9.69036 13.25 9C13.25 8.30964 12.6904 7.75 12 7.75ZM9.25 9C9.25 7.48122 10.4812 6.25 12 6.25C13.5188 6.25 14.75 7.48122 14.75 9C14.75 10.5188 13.5188 11.75 12 11.75C10.4812 11.75 9.25 10.5188 9.25 9ZM3.59541 14.9966C3.87344 15.3036 3.84992 15.7779 3.54288 16.0559C2.97519 16.57 2.75 17.0621 2.75 17.5C2.75 18.2637 3.47401 19.2048 5.23671 19.998C6.929 20.7596 9.31952 21.25 12 21.25C14.6805 21.25 17.071 20.7596 18.7633 19.998C20.526 19.2048 21.25 18.2637 21.25 17.5C21.25 17.0621 21.0248 16.57 20.4571 16.0559C20.1501 15.7779 20.1266 15.3036 20.4046 14.9966C20.6826 14.6895 21.1569 14.666 21.4639 14.9441C22.227 15.635 22.75 16.5011 22.75 17.5C22.75 19.2216 21.2354 20.5305 19.3788 21.3659C17.4518 22.2331 14.8424 22.75 12 22.75C9.15764 22.75 6.54815 22.2331 4.62116 21.3659C2.76457 20.5305 1.25 19.2216 1.25 17.5C1.25 16.5011 1.77305 15.635 2.53605 14.9441C2.84309 14.666 3.31738 14.6895 3.59541 14.9966Z"
                        fill="currentColor" />
                </svg>

            </div>
            <span class="ltr:mr-3 rtl:ml-3">Lokasi Desa Wisata: </span> Silahkan lengkapi data desa wisata untuk
            menambah destinasi wisata baru
        </div>
        <div class="pt-5 space-y-8">
            <div class="grid grid-cols-1 gap-6">
                <div class="panel">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Galeri Destinasi Wisata</h5>
                    </div>
                    <div>
                        <h5 class="text-lg font-semibold dark:text-white-light">Galeri {{ $destination->name }}
                        </h5>
                        <p class="mb-4">
                            Tambahkan Gambar Destinasi Wisata
                        </p>
                        <div class="flex xl:flex-row flex-col gap-2.5">
                            <div class="panel px-6 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                                <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 md:mb-5">
                                    @foreach ($galleries as $i => $gallery)
                                        <div
                                            class="max-w-[22rem] w-full bg-white shadow-[4px_6px_10px_-3px_#bfc9d4] rounded border border-[#e0e6ed] dark:border-[#1b2e4b] dark:bg-[#191e3a] dark:shadow-none">
                                            <div class="py-7 px-6">
                                                <div
                                                    class="-mt-7 mb-7 -mx-6 rounded-tl rounded-tr h-[260px] overflow-hidden">
                                                    <a href="javascript:;" class="md:row-span-2 md:col-span-2">
                                                        <img src="{{ asset($gallery->url) }}" alt="image-gallery"
                                                            data-fancybox="gallery"
                                                            class="rounded-md w-full h-full object-cover" />
                                                    </a>
                                                </div>
                                                <p class="text-primary text-xs mb-1.5 font-bold">
                                                    {{ $gallery->created_at->DiffForHumans() }}</p>
                                                <h5
                                                    class="text-[#3b3f5c] text-[15px] font-bold mb-4 dark:text-white-light">
                                                    {{ $gallery->title ?? '............' }}</h5>
                                                <p class="text-white-dark ">
                                                    {{ $gallery->description ?? '............' }}</p>
                                                <form action="{{ route('destination.gallery.destroy') }}"
                                                    method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $gallery->id }}">
                                                    <button type="button"
                                                        class="btn btn-danger mt-6 delete_confirm">Hapus
                                                        Gambar</button>
                                                </form>
                                            </div>
                                        </div>
                                    @endforeach

                                </div>
                            </div>
                            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                                <div class="panel mb-5">
                                    <form action="{{ route('destination.gallery.store', $destination) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="text-2xl font-semibold uppercase mb-5">Tambah Gambar</div>
                                        <div>
                                            <label for="title">Judul</label>
                                            <input class="form-input" type="text" name="title"
                                                placeholder="Judul Gambar">
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
                                                    <img id="preview"
                                                        src="{{ asset('assets/images/file-preview.svg') }}"
                                                        alt="your image"
                                                        class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @error('image')
                                                        <div class="text-danger mt-1">{{ $message }}</div>
                                                    @enderror
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
                                        <div
                                            class="grid xl:grid-cols-1 lg:grid-cols-4 sm:grid-cols-2 grid-cols-1 gap-4 mt-5">
                                            <button type="sumbit" class="btn btn-success w-full gap-2">

                                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                    xmlns="http://www.w3.org/2000/svg"
                                                    class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                                                    <path
                                                        d="M3.46447 20.5355C4.92893 22 7.28595 22 12 22C16.714 22 19.0711 22 20.5355 20.5355C22 19.0711 22 16.714 22 12C22 11.6585 22 11.4878 21.9848 11.3142C21.9142 10.5049 21.586 9.71257 21.0637 9.09034C20.9516 8.95687 20.828 8.83317 20.5806 8.58578L15.4142 3.41944C15.1668 3.17206 15.0431 3.04835 14.9097 2.93631C14.2874 2.414 13.4951 2.08581 12.6858 2.01515C12.5122 2 12.3415 2 12 2C7.28595 2 4.92893 2 3.46447 3.46447C2 4.92893 2 7.28595 2 12C2 16.714 2 19.0711 3.46447 20.5355Z"
                                                        stroke="currentColor" stroke-width="1.5" />
                                                    <path
                                                        d="M17 22V21C17 19.1144 17 18.1716 16.4142 17.5858C15.8284 17 14.8856 17 13 17H11C9.11438 17 8.17157 17 7.58579 17.5858C7 18.1716 7 19.1144 7 21V22"
                                                        stroke="currentColor" stroke-width="1.5" />
                                                    <path opacity="0.5" d="M7 8H13" stroke="currentColor"
                                                        stroke-width="1.5" stroke-linecap="round" />
                                                </svg>
                                                Simpan </button>
                                        </div>
                                    </form>
                                </div>
                            </div>
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
        @if (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: '{{ session('error') }}',
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
                            title: 'Are you sure?',
                            text: "You won't be able to revert this!",
                            icon: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Yes, delete it!'
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
        <!-- start hightlight js -->
        <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
        <script src="/assets/js/highlight.min.js"></script>
        <script>
            document.addEventListener("alpine:init", () => {
                Alpine.data("lightbox", () => ({
                    allcontrols: 1,
                    items: [],

                    bindFancybox() {
                        Fancybox.bind('[data-fancybox="gallery"]', {
                            Carousel: {
                                Navigation: {
                                    prevTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M11 5l-7 7 7 7"/><path d="M4 12h16"/></svg>',
                                    nextTpl: '<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M4 12h16"/><path d="M13 5l7 7-7 7"/></svg>',
                                },
                            },
                        });
                    }
                }));
            });
        </script>
</x-layout.default>
