<x-layout.default>
<div x-data="invoiceList">
    <script src="/assets/js/simple-datatables.js"></script>

    <div class="flex justify-end mb-4">
        <label class="mr-2 font-semibold">Filter Type:</label>
        <select x-model="filterType" @change="applyFilter" class="border rounded px-2 py-1">
            <option value="">All</option>
            <option value="ticket">Destination</option>
            <option value="tour">Tour</option>
            <option value="homestay">Homestay</option>
        </select>
    </div>

    <div class="panel px-0 border-[#e0e6ed] dark:border-[#1b2e4b]">
        <div class="invoice-table">
            <table id="myTable" class="whitespace-nowrap"></table>
        </div>
    </div>
</div>

<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data('invoiceList', () => ({
            selectedRows: [],
            items: @json($bookings),
            rawItems: [],
            searchText: '',
            filterType: '',
            datatable: null,
            dataArr: [],

            init() {
                this.rawItems = this.items;
                this.setTableData();
                this.initializeTable();
            },

            applyFilter() {
                this.items = this.rawItems.filter(item => {
                    return this.filterType === '' || item.type === this.filterType;
                });

                this.datatable.destroy();
                this.setTableData();
                this.initializeTable();
            },

            initializeTable() {
                this.datatable = new simpleDatatables.DataTable('#myTable', {
                    data: {
                        headings: [
                            '<input type="checkbox" class="form-checkbox" :checked="checkAllCheckbox" :value="checkAllCheckbox" @change="checkAll($event.target.checked)"/>',
                            "Booking Code",
                            'Type',
                            "Name",
                            "Email",
                            "Date",
                            "Amount",
                            "Status",
                            "Actions",
                        ],
                        data: this.dataArr
                    },
                    perPage: 10,
                    columns: [
                        {
                            select: 0,
                            sortable: false,
                            render: (data) => {
                                return `<input type="checkbox" class="form-checkbox mt-1" :id="'chk' + ${data}" :value="(${data})" x-model.number="selectedRows" />`;
                            }
                        },
                        {
                            select: 1,
                            render: (data) => {
                                return `<a href="/transaction/invoice/${data}" class="text-primary underline font-semibold hover:no-underline">#${data}</a>`;
                            }
                        },
                        {
                            select: 5,
                            render: (data) => {
                                return `<div class="font-semibold">${data}</div>`;
                            }
                        },
                        {
                            select: 7,
                            render: (data) => {
                                let styleClass = '';
                                switch (data.toLowerCase()) {
                                    case 'pending':
                                        styleClass = 'badge-outline-warning';
                                        break;
                                    case 'settlement':
                                    case 'paid':
                                        styleClass = 'badge-outline-success';
                                        break;
                                    case 'canceled':
                                        styleClass = 'badge-outline-danger';
                                        break;
                                    default:
                                        styleClass = 'badge-outline-secondary';
                                }
                                return `<span class="badge ${styleClass}">${data}</span>`;
                            }
                        },
                        {
                            select: 8,
                            sortable: false,
                            render: (data) => {
                                return `<div class="flex gap-4 items-center">
                                    <a href="/transaction/invoice/${data}" class="hover:text-primary">
                                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" class="w-5 h-5">
                                            <path opacity="0.5" d="M3.27 15.3C2.42 14.19 2 13.64 2 12C2 10.36 2.42 9.81 3.27 8.7C4.97 6.5 7.82 4 12 4C16.18 4 19.03 6.5 20.73 8.7C21.58 9.81 22 10.36 22 12C22 13.64 21.58 14.19 20.73 15.3C19.03 17.5 16.18 20 12 20C7.82 20 4.97 17.5 3.27 15.3Z" stroke="currentColor" stroke-width="1.5"/>
                                            <path d="M15 12C15 13.66 13.66 15 12 15C10.34 15 9 13.66 9 12C9 10.34 10.34 9 12 9C13.66 9 15 10.34 15 12Z" stroke="currentColor" stroke-width="1.5"/>
                                        </svg>
                                    </a>
                                </div>`;
                            }
                        }
                    ]
                });
            },

            checkAllCheckbox() {
                return this.items.length && this.selectedRows.length === this.items.length;
            },

            checkAll(isChecked) {
                this.selectedRows = isChecked ? this.items.map(d => d.id) : [];
            },

            setTableData() {
                this.dataArr = this.items.map(item => [
                    item.id,
                    item.invoice,
                    item.type,
                    item.name,
                    item.email,
                    item.date,
                    item.amount,
                    item.status,
                    item.action
                ]);
            }
        }))
    })
</script>
</x-layout.default>
