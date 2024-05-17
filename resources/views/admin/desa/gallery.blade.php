<x-layout.default>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <div x-data="invoiceList">

        <ul class="flex space-x-2 mb-5 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Profile Desa</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Gallery Desa</span>
            </li>
        </ul>
        <div class="flex xl:flex-row flex-col gap-2.5">
            <div class="panel px-6 flex-1 py-6 ltr:xl:mr-6 rtl:xl:ml-6">
                <h5 class="text-lg font-semibold dark:text-white-light">Gallery Desa </h5>
                <div class="table-responsive">
                    <table>
                        <thead>
                            <tr>
                                <th><input type="checkbox" class="form-checkbox" /></th>
                                <th>Image</th>
                                <th>Title</th>
                                <th>Description</th>
                                <th class="!text-center">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($galleries as $i => $gallery)
                                <tr x-init="bindFancybox()">
                                    <td><input type="checkbox" class="form-checkbox" /></td>
                                    <td class="whitespace-nowrap">
                                        <div class="flex items-center font-semibold">
                                            <div class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                                <a href="javascript:;"
                                                    class="{{ $i == 3 ? 'md:row-span-2 md:col-span-2' : '' }}">
                                                    <img class="h-8 w-8 rounded-full object-cover"
                                                        src="{{ asset($gallery->image) }}"
                                                        data-caption="{{ $gallery->title }}">
                                                </a>
                                            </div>
                                        </div>
                                    </td>
                                    <td>{{ $gallery->title }}</td>
                                    <td>{{ $gallery->title }}</td>
                                    <td class="text-center">
                                        <ul class="flex items-center justify-center gap-2">
                                            <li>
                                                <form action="{{ route('delete.gallery-desa') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="id" value="{{ $gallery->id }}">
                                                    <button type="submit">
                                                        <svg width="24" height="24" viewBox="0 0 24 24"
                                                            fill="none" xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-danger">
                                                            <path d="M20.5001 6H3.5" stroke="currentColor"
                                                                stroke-width="1.5" stroke-linecap="round"></path>
                                                            <path
                                                                d="M18.8334 8.5L18.3735 15.3991C18.1965 18.054 18.108 19.3815 17.243 20.1907C16.378 21 15.0476 21 12.3868 21H11.6134C8.9526 21 7.6222 21 6.75719 20.1907C5.89218 19.3815 5.80368 18.054 5.62669 15.3991L5.16675 8.5"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round"></path>
                                                            <path opacity="0.5" d="M9.5 11L10 16" stroke="currentColor"
                                                                stroke-width="1.5" stroke-linecap="round"></path>
                                                            <path opacity="0.5" d="M14.5 11L14 16"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round"></path>
                                                            <path opacity="0.5"
                                                                d="M6.5 6C6.55588 6 6.58382 6 6.60915 5.99936C7.43259 5.97849 8.15902 5.45491 8.43922 4.68032C8.44784 4.65649 8.45667 4.62999 8.47434 4.57697L8.57143 4.28571C8.65431 4.03708 8.69575 3.91276 8.75071 3.8072C8.97001 3.38607 9.37574 3.09364 9.84461 3.01877C9.96213 3 10.0932 3 10.3553 3H13.6447C13.9068 3 14.0379 3 14.1554 3.01877C14.6243 3.09364 15.03 3.38607 15.2493 3.8072C15.3043 3.91276 15.3457 4.03708 15.4286 4.28571L15.5257 4.57697C15.5433 4.62992 15.5522 4.65651 15.5608 4.68032C15.841 5.45491 16.5674 5.97849 17.3909 5.99936C17.4162 6 17.4441 6 17.5 6"
                                                                stroke="currentColor" stroke-width="1.5"></path>
                                                        </svg>
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="xl:w-96 w-full xl:mt-0 mt-6">
                <div class="panel mb-5">
                    <form action="{{ route('store.gallery-desa') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="text-2xl font-semibold uppercase mb-5">Add Image</div>
                        <div>
                            <label for="title">Title</label>
                            <input class="form-input" type="text" name="title" placeholder="Enter Title Image">
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
                                Save </button>
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

    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <!-- end hightlight js -->
</x-layout.default>
