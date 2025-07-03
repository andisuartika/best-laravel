<x-layout.default>


    <div x-data="invoicePreview">
        <div class="flex items-center lg:justify-end justify-center flex-wrap gap-4 mb-6">
            <button type="button" class="btn btn-info gap-2">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5">
                    <path
                        d="M17.4975 18.4851L20.6281 9.09373C21.8764 5.34874 22.5006 3.47624 21.5122 2.48782C20.5237 1.49939 18.6511 2.12356 14.906 3.37189L5.57477 6.48218C3.49295 7.1761 2.45203 7.52305 2.13608 8.28637C2.06182 8.46577 2.01692 8.65596 2.00311 8.84963C1.94433 9.67365 2.72018 10.4495 4.27188 12.0011L4.55451 12.2837C4.80921 12.5384 4.93655 12.6658 5.03282 12.8075C5.22269 13.0871 5.33046 13.4143 5.34393 13.7519C5.35076 13.9232 5.32403 14.1013 5.27057 14.4574C5.07488 15.7612 4.97703 16.4131 5.0923 16.9147C5.32205 17.9146 6.09599 18.6995 7.09257 18.9433C7.59255 19.0656 8.24576 18.977 9.5522 18.7997L9.62363 18.79C9.99191 18.74 10.1761 18.715 10.3529 18.7257C10.6738 18.745 10.9838 18.8496 11.251 19.0285C11.3981 19.1271 11.5295 19.2585 11.7923 19.5213L12.0436 19.7725C13.5539 21.2828 14.309 22.0379 15.1101 21.9985C15.3309 21.9877 15.5479 21.9365 15.7503 21.8474C16.4844 21.5244 16.8221 20.5113 17.4975 18.4851Z"
                        stroke="currentColor" stroke-width="1.5" />
                    <path opacity="0.5" d="M6 18L21 3" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                </svg>
                Send Invoice </button>

            <button type="button" class="btn btn-primary gap-2" @click="print">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="w-5 h-5">
                    <path
                        d="M6 17.9827C4.44655 17.9359 3.51998 17.7626 2.87868 17.1213C2 16.2426 2 14.8284 2 12C2 9.17157 2 7.75736 2.87868 6.87868C3.75736 6 5.17157 6 8 6H16C18.8284 6 20.2426 6 21.1213 6.87868C22 7.75736 22 9.17157 22 12C22 14.8284 22 16.2426 21.1213 17.1213C20.48 17.7626 19.5535 17.9359 18 17.9827"
                        stroke="currentColor" stroke-width="1.5" />
                    <path opacity="0.5" d="M9 10H6" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path d="M19 14L5 14" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path
                        d="M18 14V16C18 18.8284 18 20.2426 17.1213 21.1213C16.2426 22 14.8284 22 12 22C9.17157 22 7.75736 22 6.87868 21.1213C6 20.2426 6 18.8284 6 16V14"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                    <path opacity="0.5"
                        d="M17.9827 6C17.9359 4.44655 17.7626 3.51998 17.1213 2.87868C16.2427 2 14.8284 2 12 2C9.17158 2 7.75737 2 6.87869 2.87868C6.23739 3.51998 6.06414 4.44655 6.01733 6"
                        stroke="currentColor" stroke-width="1.5" />
                    <circle opacity="0.5" cx="17" cy="10" r="1" fill="currentColor" />
                    <path opacity="0.5" d="M15 16.5H9" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                    <path opacity="0.5" d="M13 19H9" stroke="currentColor" stroke-width="1.5"
                        stroke-linecap="round" />
                </svg>
                Print </button>

        </div>
        <div class="panel">
            <div class="flex justify-between flex-wrap gap-4 px-4">
                <div class="text-2xl font-semibold uppercase">Invoice</div>
                <div class="shrink-0">
                    <img src="/assets/images/logo.svg" alt="image"
                        class="w-14 ltr:ml-auto rtl:mr-auto" />
                </div>
            </div>
            <div class="ltr:text-right rtl:text-left px-4">
                <div class="space-y-1 mt-6 text-white-dark">
                    <div>{{ $data['address'] }}</div>
                    <div>{{ $data['email'] }}</div>
                    <div>{{ $data['phone'] }}</div>
                </div>
            </div>

            <hr class="border-[#e0e6ed] dark:border-[#1b2e4b] my-6">
            <div class="flex justify-between lg:flex-row flex-col gap-6 flex-wrap">
                <div class="flex-1">
                    <div class="space-y-1 text-white-dark">
                        <div>Customer:</div>
                        <div class="text-black dark:text-white font-semibold">{{ $booking->name }}</div>
                        <div>{{ $booking->email }}</div>
                        <div>{{ $booking->phone }}</div>
                    </div>
                </div>
                <div class="flex justify-between sm:flex-row flex-col gap-6 lg:w-2/3">
                    <div class="xl:1/3 lg:w-2/5 sm:w-1/2">
                        <div class="flex items-center w-full justify-between mb-2">
                            <div class="text-white-dark">Invoice :</div>
                            <div>#{{ $booking->booking_code }}</div>
                        </div>
                        <div class="flex items-center w-full justify-between mb-2">
                            <div class="text-white-dark">Transaction Date :</div>
                            <div>{{ \Carbon\Carbon::parse($booking->booking_date)->format('d M Y') }}</div>
                        </div>
                        @if($data['item_type'] !== 'homestay')
                              <div class="flex items-center w-full justify-between mb-2">
                                <div class="text-white-dark">Valid Date :</div>
                                <div>{{ \Carbon\Carbon::parse($data['checkin'])->format('d M Y') }}</div>
                            </div>
                        @endif
                        @if($data['item_type'] == 'homestay')
                            <div class="flex items-center w-full justify-between mb-2">
                                <div class="text-white-dark">Check In Date :</div>
                                <div>{{ \Carbon\Carbon::parse($data['checkin'])->format('d M Y') }}</div>
                            </div>
                            <div class="flex items-center w-full justify-between mb-2">
                                <div class="text-white-dark">Check In Date :</div>
                                <div>{{ \Carbon\Carbon::parse($data['checkout'])->format('d M Y') }}</div>
                            </div>
                        @endif
                    </div>
                    <div class="xl:1/3 lg:w-2/5 sm:w-1/2">
                        <div class="flex items-center w-full justify-between mb-2 ">
                            <div class="text-white-dark">Payment Method:</div>
                            <div class="whitespace-nowrap">Midtrans</div>
                        </div>
                        <div class="flex items-center w-full justify-between mb-2">
                            <div class="text-white-dark">Payment Status:</div>
                            <div>{{ $booking->payment_status }}</div>
                        </div>
                        <div class="flex items-center w-full justify-between mb-2">
                            <div class="text-white-dark">Booking Status:</div>
                            <div>{{ $booking->booking_status }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="table-responsive mt-6">
                <table class="table-striped">
                    <thead>
                        <tr>
                            <template x-for="item in columns" :key="item.key">
                                <th :class="[item.class]" x-text="item.label"></th>
                            </template>
                        </tr>
                    </thead>
                    <tbody>
                        <template x-for="item in items" :key="item.id">
                            <tr>
                                <td x-text="item.no"></td>
                                <td x-text="item.title"></td>
                                <td x-text="item.quantity"></td>
                                <td class="ltr:text-right rtl:text-left" x-text="`${item.price}`"></td>
                                <td class="ltr:text-right rtl:text-left" x-text="`${item.amount}`"></td>
                            </tr>
                        </template>
                    </tbody>
                </table>
            </div>
            <div class="grid sm:grid-cols-2 grid-cols-1 px-4 mt-6">
                <div></div>
                <div class="ltr:text-right rtl:text-left space-y-2">
                    <div class="flex items-center">
                        <div class="flex-1">Subtotal</div>
                        <div class="w-[37%]">{{ $data['sub_total']}}</div>
                    </div>
                    <div class="flex items-center">
                        <div class="flex-1">Tax</div>
                        <div class="w-[37%]">{{ $data['tax'] }}</div>
                    </div>
                    <div class="flex items-center font-semibold text-lg">
                        <div class="flex-1">Grand Total</div>
                        <div class="w-[37%]">@currency($booking->total_amount)</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data('invoicePreview', () => ({
                items: @json($data['item_details']),
                columns: [{
                        key: 'no',
                        label: 'NO'
                    },
                    {
                        key: 'title',
                        label: 'ITEMS'
                    },
                    {
                        key: 'quantity',
                        label: 'QTY'
                    },
                    {
                        key: 'price',
                        label: 'PRICE',
                        class: 'ltr:text-right rtl:text-left'
                    },
                    {
                        key: 'amount',
                        label: 'AMOUNT',
                        class: 'ltr:text-right rtl:text-left'
                    },
                ],

                print() {
                    window.print();
                }
            }));
        });
    </script>
</x-layout.default>
