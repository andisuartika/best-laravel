<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div x-data="withdraw">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl">Daftar Withdraw</h2>

            <div class="flex items-center gap-3 flex-wrap sm:flex-nowrap w-full sm:w-auto">
                <button class="btn btn-primary" @click="openWithdrawForm">
                    + Withdraw
                </button>
            </div>
        </div>

        <!-- Modal Form Withdraw -->
        <div class="fixed inset-0 bg-[black]/60 z-[999] overflow-y-auto hidden" :class="showWithdrawModal && '!block'">
            <div class="flex items-center justify-center min-h-screen px-4" @click.self="showWithdrawModal = false">
                <div x-show="showWithdrawModal" x-transition class="panel border-0 p-0 rounded-lg overflow-hidden max-w-lg w-full my-8">
                    <button type="button" class="absolute top-4 right-4 text-white-dark hover:text-dark" @click="showWithdrawModal = false">✕</button>
                    <h3 class="text-lg font-medium bg-[#fbfbfb] dark:bg-[#121c2c] px-5 py-3">Form Withdraw</h3>
                    <div class="p-5">
                        <form @submit.prevent="submitWithdraw">
                            <div class="mb-4">
                                <label>Saldo Sekarang</label>
                                <input type="text" class="form-input bg-gray-100" :value="balanceFormatted" disabled />
                            </div>
                            <div class="mb-4">
                                <label>Jumlah Penarikan</label>
                                <input type="number" class="form-input" x-model.number="withdrawForm.amount" min="0" step="0.01" required />
                            </div>
                            <div class="mb-4">
                                <label>Pilih Bank (Wallet)</label>
                                <select class="form-select" x-model.number="withdrawForm.bank_id" required>
                                    <option value="">Pillh Bank</option>
                                    <template x-for="bank in banks" :key="bank.id">
                                        <option :value="bank.id" x-text="bank.bank_name + ' - ' + bank.acc_number"></option>
                                    </template>
                                </select>
                            </div>
                            <div class="flex justify-end gap-2 mt-6">
                                <button type="button" class="btn btn-outline-danger" @click="showWithdrawModal = false">Batal</button>
                                <button type="submit" class="btn btn-primary">Kirim Permintaan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Detail Withdraw -->
        <div class="fixed inset-0 bg-black/60 z-[999] flex items-center justify-center"
                x-show="showDetailModal"
                x-transition
                x-cloak
            >

                <div x-show="showDetailModal" x-transition
                    class="bg-white dark:bg-gray-800 rounded-xl shadow-md w-full max-w-sm p-5 relative">
                    <button type="button"
                            class="absolute top-3 right-3 text-gray-500 hover:text-red-600 text-lg"
                            @click="showDetailModal = false">
                        &times;
                    </button>
                    <h3 class="text-lg font-semibold mb-4 border-b pb-2">Detail Withdraw</h3>

                    <div class="text-sm space-y-2">
                        <p><strong>Bank:</strong> <span x-text="detail.bank"></span></p>
                        <p><strong>Jumlah:</strong> Rp <span x-text="detail.amount"></span></p>
                        <p><strong>Status:</strong> <span x-text="detail.status"></span></p>
                        <p><strong>Tanggal Request:</strong> <span x-text="detail.request_date"></span></p>
                        <template x-if="detail.note">
                            <p><strong>Catatan:</strong> <span x-text="detail.note"></span></p>
                        </template>
                    </div>
                </div>
            </div>

        <!-- Tabel Withdraw -->
        <div class="mt-6 panel p-0 border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Bank</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in withdrawList" :key="item.id">
                            <tr>
                                <td x-text="item.bank"></td>
                                <td x-text="'Rp ' + item.amount"></td>
                                <td>
                                    <span class="badge" :class="item.status === 'approved' ? 'badge-outline-success' : item.status === 'rejected' ? 'badge-outline-danger' : 'badge-outline-warning'" x-text="item.status"></span>
                                </td>
                                <td x-text="item.request_date"></td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-outline-info" @click="showDetail(item)">Detail</button>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('withdraw', () => ({
                showWithdrawModal: false,
                showDetailModal: false,
                withdrawList: @json($withdrawals),
                banks: @json($banks),
                balance: @json($balance),
                withdrawForm: {
                    amount: '',
                    bank_id: null,
                },
                detail: {},

                get balanceFormatted() {
                    return 'Rp ' + parseFloat(this.balance).toLocaleString('id-ID');
                },

                openWithdrawForm() {
                    this.withdrawForm = { amount: '', bank_id: null };
                    this.showWithdrawModal = true;
                },

                showDetail(item) {
                    this.detail = item;
                    this.showDetailModal = true;
                },

                async submitWithdraw() {
                    try {
                        const response = await fetch('/withdraw', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: JSON.stringify(this.withdrawForm)
                        });

                        const result = await response.json();

                        if (!response.ok) throw result;

                        Swal.fire('Berhasil!', 'Withdraw berhasil dikirim.', 'success');
                        this.showWithdrawModal = false;
                    } catch (err) {
                        Swal.fire('Gagal!', err?.message || 'Terjadi kesalahan.', 'error');
                        console.error(err);
                    }
                },
            }))
        })
    </script>
</x-layout.default>
