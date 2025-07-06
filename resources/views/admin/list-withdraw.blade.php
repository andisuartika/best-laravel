<x-layout.default>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <div x-data="withdrawApproval">
        <div class="flex items-center justify-between flex-wrap gap-4">
            <h2 class="text-xl">Kelola Withdraw</h2>
        </div>

        <!-- Modal Approve -->
        <div class="fixed inset-0 bg-black/60 z-[999] flex items-center justify-center" x-show="showApproveModal" x-transition x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md w-full max-w-sm p-5 relative">
                <!-- Judul Modal -->
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">
                    Approve Withdraw
                </h3>
                <div class="text-sm space-y-3">
                    <p><strong>Nama User:</strong> <span x-text="selected.user"></span></p>
                    <p><strong>Bank:</strong> <span x-text="selected.bank"></span></p>
                    <p><strong>No. Rekening:</strong> <span x-text="selected.acc_number"></span></p>
                    <p><strong>Nama di Rekening:</strong> <span x-text="selected.acc_holder"></span></p>
                    <p><strong>Jumlah:</strong> <span x-text="'Rp ' + currency(selected.amount)"></span></p>
                    <div>
                        <label class="font-semibold">Metode Pembayaran</label>
                        <input type="text" class="form-input mt-1" x-model="selected.payment_method">
                    </div>
                    <div>
                        <label class="font-semibold">Referensi Pembayaran</label>
                        <input type="text" class="form-input mt-1" x-model="selected.payment_ref">
                    </div>
                    <div class="flex justify-end mt-4 gap-2">
                        <button class="btn btn-outline-secondary" @click="showApproveModal = false">Batal</button>
                        <button class="btn btn-primary" @click="submitApproval">Approve</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal Reject -->
        <div class="fixed inset-0 bg-black/60 z-[999] flex items-center justify-center" x-show="showRejectModal" x-transition x-cloak>
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md w-full max-w-sm p-5 relative">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Tolak Withdraw</h3>
                <div class="text-sm space-y-2">
                    <p>Berikan alasan penolakan:</p>
                    <textarea class="form-textarea w-full" rows="3" x-model="rejectNote"></textarea>
                    <div class="flex justify-end mt-4 gap-2">
                        <button class="btn btn-outline-secondary" @click="showRejectModal = false">Batal</button>
                        <button class="btn btn-danger" @click="submitRejection">Tolak</button>
                    </div>
                </div>
            </div>
        </div>

         <!-- Modal Detail -->
        <div
            class="fixed inset-0 bg-black/60 z-[999] flex items-center justify-center"
            x-show="showDetailModal"
            x-transition
            x-cloak
        >
            <div class="bg-white dark:bg-gray-800 rounded-xl shadow-md w-full max-w-sm p-5 relative">
                <!-- Judul -->
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">Detail Withdraw</h3>

                <!-- Konten -->
                <div class="text-sm space-y-2">
                    <p><strong>Nama User:</strong> <span x-text="selected.user"></span></p>
                    <p><strong>Bank:</strong> <span x-text="selected.bank"></span></p>
                    <p><strong>No. Rekening:</strong> <span x-text="selected.acc_number"></span></p>
                    <template x-if="selected.acc_holder">
                        <p><strong>Nama di Rekening:</strong> <span x-text="selected.acc_holder"></span></p>
                    </template>
                    <p><strong>Jumlah:</strong> Rp <span x-text="currency(selected.amount)"></span></p>
                    <p><strong>Status:</strong> <span x-text="selected.status"></span></p>
                    <p><strong>Tanggal Request:</strong> <span x-text="selected.request_date"></span></p>
                    <template x-if="selected.payment_method">
                        <p><strong>Metode Pembayaran:</strong> <span x-text="selected.payment_method"></span></p>
                    </template>
                    <template x-if="selected.payment_ref">
                        <p><strong>Referensi Pembayaran:</strong> <span x-text="selected.payment_ref"></span></p>
                    </template>
                    <template x-if="selected.note">
                        <p><strong>Catatan:</strong> <span x-text="selected.note"></span></p>
                    </template>
                </div>
                <div class="flex justify-end mt-4 gap-2">
                        <button class="btn btn-outline-secondary" @click="showDetailModal = false">Close</button>
                </div>
            </div>
        </div>


        <!-- Tabel Withdraw -->
        <div class="mt-6 panel p-0 border-0 overflow-hidden">
            <div class="table-responsive">
                <table class="table-striped table-hover">
                    <thead>
                        <tr>
                            <th>User</th>
                            <th>Bank</th>
                            <th>Jumlah</th>
                            <th>Status</th>
                            <th>Tanggal</th>
                            <th class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in withdrawals" :key="item.id">
                            <tr>
                                <td x-text="item.user"></td>
                                <td x-text="item.bank"></td>
                                <td x-text="'Rp ' + currency(item.amount)"></td>
                                <td><span class="badge" :class="item.status === 'approved' ? 'badge-outline-success' : item.status === 'rejected' ? 'badge-outline-danger' : 'badge-outline-warning'" x-text="item.status"></span></td>
                                <td x-text="item.request_date"></td>
                                <td class="text-center">
                                    <div class="flex justify-center gap-2">
                                        <!-- Jika pending, tampilkan tombol approve & reject -->
                                        <template x-if="item.status === 'pending'">
                                            <div class="flex gap-2">
                                                <button class="btn btn-sm btn-outline-primary" @click="openApprove(item)">Approve</button>
                                                <button class="btn btn-sm btn-outline-danger" @click="openReject(item)">Reject</button>
                                            </div>
                                        </template>

                                        <!-- Jika sudah diproses, tampilkan tombol detail -->
                                        <template x-if="item.status !== 'pending'">
                                            <button class="btn btn-sm btn-outline-info" @click="openDetail(item)">Detail</button>
                                        </template>
                                    </div>
                                </td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <script>
         function currency(value) {
            return Number(value).toLocaleString('id-ID');
        }
    document.addEventListener('alpine:init', () => {
        Alpine.data('withdrawApproval', () => ({
            withdrawals: @json($withdrawals),
            selected: {},
            rejectNote: '',
            showApproveModal: false,
            showRejectModal: false,
            showDetailModal: false,

            openApprove(item) {
                this.selected = JSON.parse(JSON.stringify(item));
                this.showApproveModal = true;
            },

            openReject(item) {
                this.selected = item;
                this.rejectNote = '';
                this.showRejectModal = true;
            },

            openDetail(item) {
                this.selected = item;
                this.showDetailModal = true;
            },


            async submitApproval() {
                try {
                    const res = await fetch(`/list-withdraw/${this.selected.id}/approve`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({
                            payment_method: this.selected.payment_method,
                            payment_ref: this.selected.payment_ref,
                        })
                    });

                    if (!res.ok) throw await res.json();

                    Swal.fire('Berhasil!', 'Withdraw berhasil diapprove.', 'success');
                    this.showApproveModal = false;
                    setTimeout(() => location.reload(), 1000);

                } catch (err) {
                    console.error(err);
                    Swal.fire('Gagal!', err.message || 'Gagal approve withdraw.', 'error');
                }
            },

            async submitRejection() {
                try {
                    const res = await fetch(`/list-withdraw/${this.selected.id}/reject`, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                        },
                        body: JSON.stringify({ note: this.rejectNote })
                    });

                    if (!res.ok) throw await res.json();

                    Swal.fire('Ditolak!', 'Withdraw berhasil ditolak.', 'success');
                    this.showRejectModal = false;
                    setTimeout(() => location.reload(), 1000);

                } catch (err) {
                    console.error(err);
                    Swal.fire('Gagal!', err.message || 'Gagal menolak withdraw.', 'error');
                }
            },
        }))
    })
    </script>
</x-layout.default>
