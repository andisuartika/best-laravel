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
                <a href="{{ route('homestays.index') }}" class="text-primary hover:underline">Penginapan</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <a href="{{ route('room-type.index') }}" class="text-primary hover:underline">Tipe Kamar</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Galeri Kamar</span>
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
            <span class="ltr:mr-3 rtl:ml-3">Tipe Kamar Penginapan: </span>Galeri Tipe Kamar Penginapan
        </div>
        <div class="pt-5 space-y-8">
            <div class="grid grid-cols-1 gap-6">
                <div class="panel">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Galeri Tipe Kamar</h5>
                    </div>
                    <div>
                        <h5 class="text-lg font-semibold dark:text-white-light">Galeri {{ $room->name }}
                        </h5>
                        <p class="mb-4">
                            Tambahkan Galeri Tipe Kamar
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
                                                <form action="{{ route('room.gallery.destroy') }}" method="POST">
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
                                    <form action="{{ route('room.gallery.store', $room) }}" method="POST"
                                        enctype="multipart/form-data">
                                        @csrf
                                        <div class="text-2xl font-semibold uppercase mb-5">Tambah Gambar</div>
                                        <div>
                                            <label for="title">Title</label>
                                            <input class="form-input" type="text" name="title"
                                                placeholder="Enter Title Image">
                                        </div>
                                        <div class="mt-4">
                                            <label for="description">Description</label>
                                            <textarea id="description" name="description" rows="3" class="form-textarea"
                                                placeholder="Enter Description Image "></textarea>
                                        </div>
                                        <div class="mt-4">
                                            <div>
                                                <label for="image">Image </label>
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

                                                <svg width="24" height="24" viewBox="0 0 24 24"
                                                    fill="none" xmlns="http://www.w3.org/2000/svg"
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
                                                Save </button>
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
