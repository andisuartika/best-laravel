<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div x-data="contacts">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl">Kontak Desa {{ Auth::user()->village()->get()->implode('name') }}</h2>
            <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                <div class="flex gap-3">
                    <div>
                        <button type="button" class="btn btn-primary" @click="addContact">
                            <svg class="mr-2" width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M17 12C19.7614 12 22 9.76142 22 7C22 4.23858 19.7614 2 17 2C14.2386 2 12 4.23858 12 7C12 7.79984 12.1878 8.55582 12.5217 9.22624C12.6105 9.4044 12.64 9.60803 12.5886 9.80031L12.2908 10.9133C12.1615 11.3965 12.6035 11.8385 13.0867 11.7092L14.1997 11.4114C14.392 11.36 14.5956 11.3895 14.7738 11.4783C15.4442 11.8122 16.2002 12 17 12Z"
                                    stroke="#ffff" stroke-width="1.5" />
                                <path d="M15 7H19M17 9L17 5" stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                                <path opacity="0.5"
                                    d="M8.03759 7.31617L8.6866 8.4791C9.2723 9.52858 9.03718 10.9053 8.11471 11.8278C8.11471 11.8278 8.11471 11.8278 8.11471 11.8278C8.11459 11.8279 6.99588 12.9468 9.02451 14.9755C11.0525 17.0035 12.1714 15.8861 12.1722 15.8853C12.1722 15.8853 12.1722 15.8853 12.1722 15.8853C13.0947 14.9628 14.4714 14.7277 15.5209 15.3134L16.6838 15.9624C18.2686 16.8468 18.4557 19.0692 17.0628 20.4622C16.2258 21.2992 15.2004 21.9505 14.0669 21.9934C12.1588 22.0658 8.91828 21.5829 5.6677 18.3323C2.41713 15.0817 1.93421 11.8412 2.00655 9.93309C2.04952 8.7996 2.7008 7.77423 3.53781 6.93723C4.93076 5.54428 7.15317 5.73144 8.03759 7.31617Z"
                                    stroke="#ffff" stroke-width="1.5" stroke-linecap="round" />
                            </svg>

                            Tambah Kontak
                        </button>
                        <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden"
                            :class="addContactModal && '!block'">
                            <div class="flex items-center justify-center min-h-screen px-4"
                                @click.self="addContactModal = false">
                                <div x-show="addContactModal" x-transition x-transition.duration.300
                                    class="panel border-0 p-0 rounded-lg overflow-hidden md:w-full max-w-lg w-[90%] my-8">
                                    <button type="button"
                                        class="absolute top-4 ltr:right-4 rtl:left-4 text-white-dark hover:text-dark"
                                        @click="addContactModal = false">

                                        <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px"
                                            viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"
                                            stroke-linecap="round" stroke-linejoin="round" class="w-6 h-6">
                                            <line x1="18" y1="6" x2="6" y2="18"></line>
                                            <line x1="6" y1="6" x2="18" y2="18"></line>
                                        </svg>
                                    </button>
                                    <h3 class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] ltr:pl-5 rtl:pr-5 py-3 ltr:pr-[50px] rtl:pl-[50px]"
                                        x-text="params.id ? 'Edit Kontak' : '  Tambah Kontak'"></h3>
                                    <div class="p-5">
                                        <form x-data="{ params.id: {{ $param->id ?? 'null' }} }"
                                            x-bind:action="params.id ? '{{ route('update.contact-desa') }}' :
                                                '{{ route('store.contact-desa') }}'"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="id" x-model="params.id">
                                            <div class="mb-5">
                                                <label for="name">Jenis Kontak</label>
                                                <input id="name" type="text" placeholder="WA/FB/IG/PHONE"
                                                    class="form-input" name="name" x-model="params.name" required />
                                            </div>
                                            <div class="mb-5">
                                                <label for="contact">Kontak/Link</label>
                                                <input id="contact" type="text" placeholder="Enter Contact"
                                                    class="form-input" name="contact" x-model="params.contact"
                                                    required />
                                            </div>
                                            <div class="mb-5">
                                                <label for="status">Status</label>
                                                <select id="status" class="form-select text-white-dark"
                                                    name="status" x-model="params.status" required>
                                                    <option value="ON">ON</option>
                                                    <option value="OFF">OFF</option>
                                                </select>
                                            </div>
                                            <div class="flex justify-end items-center mt-8">
                                                <button type="button" class="btn btn-outline-danger"
                                                    @click="addContactModal = false">Cancel</button>
                                                <button type="submit" class="btn btn-primary ltr:ml-4 rtl:mr-4"
                                                    x-text="params.id ? 'Update' : 'Add'"></button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="relative ">
                    <input type="text" placeholder="Cari Kontak" class="form-input py-2 ltr:pr-11 rtl:pl-11 peer"
                        x-model="searchUser" @keyup="searchContacts" />
                    <div
                        class="absolute ltr:right-[11px] rtl:left-[11px] top-1/2 -translate-y-1/2 peer-focus:text-primary">

                        <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5"
                                opacity="0.5"></circle>
                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="mt-5 panel p-0 border-0 overflow-hidden">
            <template x-if="displayType === 'list'">
                <div class="table-responsive">
                    <table class="table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Kontak</th>
                                <th>Status</th>
                                <th class="!text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="contact in filterdContactsList" :key="contact.id">
                                <tr>
                                    <td>
                                        <div x-text="contact.name"></div>
                                    </td>
                                    <td x-text="contact.contact"></td>
                                    <td x-text="contact.status" class="whitespace-nowrap"></td>
                                    <td>
                                        <div class="flex gap-4 items-center justify-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                @click="editContact(contact)">Edit</button>
                                            <form id="deleteForm" action="{{ route('delete.contact-desa') }}"
                                                method="POST">
                                                @csrf
                                                <input type="hidden" name="id" x-model="contact.id">
                                                <a href="javascript:;"
                                                    class="btn btn-sm btn-outline-danger delete_confirm">Delete</a>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
            </template>
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
                        }
                    })
            });

        });
    </script>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("contacts", () => ({
                defaultParams: {
                    id: null,
                    name: '',
                    contact: '',
                    status: '',
                },
                displayType: 'list',
                addContactModal: false,
                editContactModal: false,
                params: {
                    id: null,
                    name: '',
                    contact: '',
                    status: '',
                },
                filterdContactsList: [],
                searchUser: '',
                contactList: @json($contacts),

                init() {
                    this.searchContacts();
                },

                addContact() {
                    this.params = this.defaultParams;
                    this.addContactModal = true;
                },

                editContact(contact) {
                    if (contact) {
                        this.params = JSON.parse(JSON.stringify(contact));
                    }
                    this.addContactModal = true;
                },

                searchContacts() {
                    this.filterdContactsList = this.contactList.filter((d) => d.name.toLowerCase()
                        .includes(this.searchUser.toLowerCase()));
                },


            }));
        });
    </script>
</x-layout.default>
