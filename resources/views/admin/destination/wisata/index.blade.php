<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div x-data="contacts">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl uppercase">Lokasi Desa Wisata {{ Auth::user()->village()->get()->implode('name') }}</h2>
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
                            Tambah Destinasi Wisata
                        </button>
                    </div>
                </div>
                <div class="relative ">
                    <input type="text" placeholder="Search Destinasi"
                        class="form-input py-2 ltr:pr-11 rtl:pl-11 peer" x-model="searchUser" @keyup="searchContacts" />
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
            <template x-if="displayType === 'list'">
                <div class="table-responsive">
                    <table class="table-striped table-hover">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Alamat</th>
                                <th>Pengelola</th>
                                <th>Kategori</th>
                                <th>Oprasional</th>
                                <th class="!text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>
                                    <div>Sudaji Village</div>
                                </td>
                                <td>
                                    <div>Desa Sudaji</div>
                                </td>
                                <td class="whitespace-nowrap">
                                    <div>BUMDES Desa Sudaji</div>
                                </td>
                                <td>
                                    <div>Budaya</div>
                                </td>
                                <td>
                                    <div>07:00 - 22:00 WITA</div>
                                </td>

                                <td>
                                    <div class="flex gap-4 items-center justify-center">
                                        <button type="button" class="btn btn-sm btn-outline-primary"
                                            @click="editContact(contact)">Edit</button>
                                        <form action="{{ route('delete.contact-desa') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" x-model="contact.id">
                                            <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            {{-- <template x-for="contact in filterdContactsList" :key="contact.id">
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
                                            <form action="{{ route('delete.contact-desa') }}" method="POST">
                                                @csrf
                                                <input type="hidden" name="id" x-model="contact.id">
                                                <button type="submit"
                                                    class="btn btn-sm btn-outline-danger">Delete</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </template> --}}
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
                contactList: @json($destinations),

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
