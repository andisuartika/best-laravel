<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div x-data="banks">
        <div class="flex items-center justify-between flex-nowrap gap-4 w-full">
            <h2 class="text-xl">Daftar Bank</h2>

            <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap w-full sm:w-auto">
                <button type="button" class="btn btn-primary shrink-0" @click="editBank(null)">
                    + Tambah Bank
                </button>

                <!-- Modal Form Tambah/Edit -->
                <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="addBankModal && '!block'">
                    <div class="flex items-center justify-center min-h-screen px-4" @click.self="addBankModal = false">
                        <div x-show="addBankModal" x-transition class="panel border-0 p-0 rounded-lg overflow-hidden max-w-lg w-full my-8">
                            <button type="button" class="absolute top-4 right-4 text-white-dark hover:text-dark" @click="addBankModal = false">✕</button>
                            <h3 class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] px-5 py-3" x-text="params.id ? 'Ubah Bank' : 'Tambah Bank'"></h3>
                            <div class="p-5">
                                <form @submit.prevent="simpanBank">
                                    <div class="mb-4">
                                        <label>Nama Bank</label>
                                        <input type="text" class="form-input" x-model="params.bank_name" placeholder="Contoh: BCA, Mandiri" />
                                    </div>
                                    <div class="mb-4">
                                        <label>Nomor Rekening</label>
                                        <input type="text" class="form-input" x-model="params.acc_number" placeholder="Contoh: 1234567890" />
                                    </div>
                                    <div class="mb-4">
                                        <label>Nama Pemilik Rekening</label>
                                        <input type="text" class="form-input" x-model="params.acc_holder" placeholder="Contoh: John Doe" />
                                    </div>
                                    <div class="mb-4">
                                        <label>Status</label>
                                        <select class="form-select" x-model="params.status" required>
                                            <option value="active">Aktif</option>
                                            <option value="inactive">Nonaktif</option>
                                        </select>
                                        <p class="text-xs mt-1 text-gray-500">Nilai status sekarang: <span x-text="params.status"></span></p>
                                    </div>
                                    <div class="flex justify-end gap-2 mt-6">
                                        <button type="button" class="btn btn-outline-danger" @click="addBankModal = false">Batal</button>
                                        <button type="submit" class="btn btn-primary" x-text="params.id ? 'Perbarui' : 'Tambah'"></button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Input Pencarian -->
                <input type="text" placeholder="Cari nama bank..." class="form-input flex-1 min-w-0" x-model="searchQuery" @input="cariBank" />
            </div>
        </div>

        <!-- Tabel Daftar Bank -->
        <div class="mt-6 panel p-0 border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Nama Bank</th>
                            <th>No. Rekening</th>
                            <th>Nama Pemilik</th>
                            <th>Status</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="bank in filteredBankList" :key="bank.id">
                            <tr>
                                <td x-text="bank.bank_name"></td>
                                <td x-text="bank.acc_number"></td>
                                <td x-text="bank.acc_holder"></td>
                                <td>
                                    <span class="badge" :class="bank.status === 'active' ? 'badge badge-outline-success' : 'badge badge-outline-danger'" x-text="bank.status === 'active' ? 'Aktif' : 'Nonaktif'"></span>
                                </td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2">
                                        <button class="btn btn-sm btn-outline-primary" @click="editBank(bank)">Ubah</button>
                                        <button class="btn btn-sm btn-outline-danger" @click="hapusBank(bank)">Hapus</button>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Script Alpine -->
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('banks', () => ({
                addBankModal: false,
                searchQuery: '',
                bankList: @json($banks),
                filteredBankList: [],
                params: {
                    id: null,
                    bank_name: '',
                    acc_number: '',
                    acc_holder: '',
                    status: 'active',
                },

                init() {
                    this.filteredBankList = this.bankList;
                },

                editBank(bank) {
                    this.params = {
                        id: bank?.id ?? null,
                        bank_name: bank?.bank_name ?? '',
                        acc_number: bank?.acc_number ?? '',
                        acc_holder: bank?.acc_holder ?? '',
                        status: bank?.status ?? 'active',
                    };
                    this.addBankModal = true;
                },

                async simpanBank() {
                    const isEdit = !!this.params.id;
                    const url = isEdit ? `/banks/${this.params.id}` : '/banks';
                    const method = isEdit ? 'PUT' : 'POST';

                    const payload = {
                        bank_name: this.params.bank_name,
                        acc_number: this.params.acc_number,
                        acc_holder: this.params.acc_holder,
                        status: this.params.status,
                    };

                    try {
                        const response = await fetch(url, {
                            method: method,
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                            body: JSON.stringify(payload),
                        });

                        const result = await response.json();

                        if (!response.ok) {
                            throw result;
                        }

                        if (isEdit) {
                            const index = this.bankList.findIndex((b) => b.id === this.params.id);
                            if (index !== -1) this.bankList[index] = { ...this.params };
                        } else {
                            const newId = result.data?.id ?? Math.max(...this.bankList.map((b) => b.id), 0) + 1;
                            this.bankList.unshift({ ...this.params, id: newId });
                        }

                        this.cariBank();
                        this.addBankModal = false;
                        const toast = window.Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        toast.fire({
                            icon: 'success',
                            title: 'Data bank berhasil disimpan.',
                            padding: '10px 20px',
                        });
                    } catch (error) {
                        console.error(error);
                        Swal.fire('Gagal!', 'Gagal menyimpan data bank.', 'error');
                    }
                },

                async hapusBank(bank) {
                  const confirm = await Swal.fire({
                        title: 'Hapus Bank?',
                        text: 'Data bank akan dihapus secara permanen.',
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonText: 'Ya, hapus!',
                        cancelButtonText: 'Batal'
                    });

                    if (!confirm.isConfirmed) return;

                    try {
                        const response = await fetch(`/banks/${bank.id}`, {
                            method: 'DELETE',
                            headers: {
                                'X-CSRF-TOKEN': document
                                    .querySelector('meta[name="csrf-token"]')
                                    .getAttribute('content'),
                            },
                        });

                        if (!response.ok) {
                            throw await response.json();
                        }

                        this.bankList = this.bankList.filter((b) => b.id !== bank.id);
                        this.cariBank();
                        const toast = window.Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        toast.fire({
                            icon: 'success',
                            title: 'Bank berhasil dihapus.',
                            padding: '10px 20px',
                        });
                    } catch (error) {
                        console.error(error);
                        const toast = window.Swal.mixin({
                            toast: true,
                            position: 'top-end',
                            showConfirmButton: false,
                            timer: 3000,
                        });
                        toast.fire({
                            icon: 'error',
                            title: 'Gagal menghapus bank.',
                            padding: '10px 20px',
                        });
                    }
                },

                cariBank() {
                    this.filteredBankList = this.bankList.filter((b) =>
                        b.bank_name.toLowerCase().includes(this.searchQuery.toLowerCase())
                    );
                },
            }));
        });
    </script>
</x-layout.default>
