<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div x-data="contacts">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl uppercase">Lokasi Desa Wisata {{ Auth::user()->village()->get()->implode('name') }}</h2>
            <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                <div class="flex gap-3">
                    <div>
                        <a href="{{ route('destination.create') }}" type="button" class="btn btn-primary">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                <circle cx="10" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
                                <path opacity="0.5"
                                    d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path d="M21 10H19M19 10H17M19 10L19 8M19 10L19 12" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Tambah Destinasi Wisata
                        </a>
                    </div>
                </div>
                <div class="relative ">
                    <input type="text" placeholder="Search Destinasi"
                        class="form-input py-2 ltr:pr-11 rtl:pl-11 peer" />
                    <div
                        class="absolute ltr:right-[11px] rtl:left-[11px] top-1/2 -translate-y-1/2 peer-focus:text-primary">

                        <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5"
                                opacity="0.5"></circle>
                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            </path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 panel p-0 border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Pengelola</th>
                            <th>Status</th>
                            <th class="!text-center">Actions</th>
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
                                        <div class="p-0.5 bg-white-dark/30 rounded-full w-max ltr:mr-2 rtl:ml-2">
                                            <img class="h-8 w-8 rounded-full object-cover"
                                                src="{{ $destination->thumbnail_url }}">
                                        </div>
                                        <div>{{ $destination->name }}</div>
                                    </div>
                                </td>
                                <td>{{ $destination->address }}</td>
                                <td class="whitespace-nowrap">{{ $destination->manager()->get()->implode('name') }}
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
                                                        <h5 class="font-bold text-lg">Ubah Status Destinasi Wisata</h5>
                                                        <button type="button" class="text-white-dark hover:text-dark"
                                                            @click="toggle">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="24px"
                                                                height="24px" viewBox="0 0 24 24" fill="none"
                                                                stroke="currentColor" stroke-width="1.5"
                                                                stroke-linecap="round" stroke-linejoin="round"
                                                                class="h-6 w-6">
                                                                <line x1="18" y1="6" x2="6"
                                                                    y2="18"></line>
                                                                <line x1="6" y1="6" x2="18"
                                                                    y2="18"></line>
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
                                                                    <label for="status">Status Destinasi</label>
                                                                    <select id="status" name="status"
                                                                        class="form-select text-white-dark" required>
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
                                                                <button type="button" class="btn btn-outline-danger"
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
                                    <div class="flex gap-4 items-center justify-center">

                                        <a href="{{ route('destination.edit', $destination) }}" type="button"
                                            class="btn btn-sm btn-outline-primary">Edit</a>
                                        <a href="{{ route('destination.gallery', $destination) }}" type="button"
                                            class="btn btn-sm btn-outline-secondary">Gallery</a>

                                        <form action="{{ route('destination.destroy', $destination) }}"
                                            method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <input type="hidden" name="id" value="{{ $destination->id }}">
                                            <a href="javascript:;"
                                                class="btn btn-sm btn-outline-danger delete_confirm">Delete</a>
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
