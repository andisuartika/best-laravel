<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div x-data="contacts">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl">Pengelola Destinasi</h2>
            <div class="flex sm:flex-row flex-col sm:items-center sm:gap-3 gap-4 w-full sm:w-auto">
                <div class="flex gap-3">
                    <div>
                        <button type="button" class="btn btn-primary" @click="addContact">

                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2">
                                <circle cx="10" cy="6" r="4" stroke="currentColor" stroke-width="1.5" />
                                <path opacity="0.5"
                                    d="M18 17.5C18 19.9853 18 22 10 22C2 22 2 19.9853 2 17.5C2 15.0147 5.58172 13 10 13C14.4183 13 18 15.0147 18 17.5Z"
                                    stroke="currentColor" stroke-width="1.5" />
                                <path d="M21 10H19M19 10H17M19 10L19 8M19 10L19 12" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Tambah Pengelola
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
                                        x-text="params.id ? 'Edit Contact' : 'Tambah Pengelola'"></h3>
                                    <div class="p-5">
                                        <form x-data="{ params.id: {{ $param->id ?? 'null' }} }"
                                            x-bind:action="params.id ? '{{ route('manager.update') }}' : '{{ route('manager.store') }}'"
                                            method="POST">
                                            @csrf
                                            <input type="hidden" name="id" id="id" x-model="params.id">
                                            <div class="mb-5">
                                                <label for="name">Nama</label>
                                                <input id="name" type="text" placeholder="Nama Pengelola"
                                                    class="form-input" name="name" x-model="params.name" required />
                                            </div>
                                            <div class="mb-5">
                                                <label for="position">Jabatan</label>
                                                <input id="position" type="text" placeholder="Jabatan Pengelola"
                                                    class="form-input" name="position" x-model="params.position" />
                                            </div>
                                            <div class="mb-5">
                                                <label for="phone">No Telepon</label>
                                                <input id="phone" type="text" placeholder="No Telepon"
                                                    class="form-input" name="phone" x-model="params.phone" />
                                            </div>
                                            <div class="mb-5">
                                                <label for="wa">No WhatsApp</label>
                                                <input id="wa" type="text" placeholder="No WhatsApp"
                                                    class="form-input" name="wa" x-model="params.wa" />
                                            </div>
                                            <div class="mb-5">
                                                <label for="email">Email</label>
                                                <input id="email" type="text" placeholder="Email"
                                                    class="form-input" name="email" x-model="params.email" />
                                            </div>
                                            <div class="mb-5">
                                                <label for="website">Alamat Website</label>
                                                <input id="website" type="text" placeholder="Website"
                                                    class="form-input" name="website" x-model="params.website" />
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
                    <input type="text" placeholder="Cari Pengelola"
                        class="form-input py-2 ltr:pr-11 rtl:pl-11 peer" x-model="searchUser"
                        @keyup="searchContacts" />
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
                                <th>#Code</th>
                                <th>Nama</th>
                                <th>Jabatan</th>
                                <th>Telepon</th>
                                <th>WhatsApp</th>
                                <th>Email</th>
                                <th>Website</th>
                                <th class="!text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="item in filterdContactsList" :key="item.id">
                                <tr>
                                    <td>
                                        <div x-text="item.code"></div>
                                    </td>
                                    <td x-text="item.name"></td>
                                    <td x-text="item.position ? item.position : '-'"></td>
                                    <td x-text="item.phone ? item.phone : '-'"></td>
                                    <td x-text="item.wa ? item.wa : '-'"></td>
                                    <td x-text="item.email ? item.email : '-'"></td>
                                    <td x-text="item.website ? item.website : '-'" class="whitespace-nowrap">
                                    </td>
                                    <td>
                                        <div class="flex gap-4 items-center justify-center">
                                            <button type="button" class="btn btn-sm btn-outline-primary"
                                                @click="editContact(item)">Edit</button>
                                            <form action="{{ route('manager.delete') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" x-model="item.id">
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">Delete</button>
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
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("contacts", () => ({
                defaultParams: {
                    id: null,
                    code: '',
                    name: '',
                    position: '',
                    phone: '',
                    wa: '',
                    email: '',
                    website: '',
                },
                displayType: 'list',
                addContactModal: false,
                editContactModal: false,
                params: {
                    id: null,
                    code: '',
                    name: '',
                    position: '',
                    phone: '',
                    wa: '',
                    email: '',
                    website: '',
                },
                filterdContactsList: [],
                searchUser: '',
                contactList: @json($managers),

                init() {
                    this.searchContacts();
                },

                addContact() {
                    this.params = this.defaultParams;
                    this.addContactModal = true;
                },

                editContact(manager) {
                    if (manager) {
                        this.params = JSON.parse(JSON.stringify(manager));
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
