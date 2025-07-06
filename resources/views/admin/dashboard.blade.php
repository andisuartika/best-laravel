<x-layout.default>

    <script defer src="/assets/js/apexcharts.js"></script>
    <div x-data="analytics">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
        </ul>
        <div class="pt-5">
            <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
                <div class="panel h-full sm:col-span-2 lg:col-span-1">
                    <!-- statistics -->
                    <div class="flex items-center justify-between dark:text-white-light mb-5">
                        <h5 class="font-semibold text-lg ">Transaksi</h5>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg class="w-5 h-5 text-black/70 dark:text-white/70 hover:!text-primary"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0">
                                <li><a href="javascript:;" @click="toggle">This Week</a></li>
                                <li><a href="javascript:;" @click="toggle">Last Week</a></li>
                                <li><a href="javascript:;" @click="toggle">This Month</a></li>
                                <li><a href="javascript:;" @click="toggle">Last Month</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="grid sm:grid-cols-2 gap-8 text-sm text-[#515365] font-bold">
                        <div>
                            <div>
                                <div>Total Transaksi</div>
                                <div class="text-[#f8538d] text-lg">@currency($data['total_transaction'])</div>
                            </div>

                        </div>

                        <div>
                             <div id="chartTransaksi" class="w-full max-w-md mx-auto"></div>
                        </div>
                    </div>
                </div>

                <div class="panel h-full">
                    <div class="flex items-center justify-between dark:text-white-light mb-5">
                        <h5 class="font-semibold text-lg ">Penjualan Tiket</h5>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg class="w-5 h-5 text-black/70 dark:text-white/70 hover:!text-primary"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0">
                                <li><a href="javascript:;" @click="toggle">This Week</a></li>
                                <li><a href="javascript:;" @click="toggle">Last Week</a></li>
                                <li><a href="javascript:;" @click="toggle">This Month</a></li>
                                <li><a href="javascript:;" @click="toggle">Last Month</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class=" text-[#e95f2b] text-3xl font-bold my-10">
                        <span>{{ $data['total_ticket'] }}</span>
                        <svg class="w-5 h-5 text-success inline" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path opacity="0.5"
                                d="M22 7L14.6203 14.3347C13.6227 15.3263 13.1238 15.822 12.5051 15.822C11.8864 15.8219 11.3876 15.326 10.3902 14.3342L10.1509 14.0962C9.15254 13.1035 8.65338 12.6071 8.03422 12.6074C7.41506 12.6076 6.91626 13.1043 5.91867 14.0977L2 18"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                                stroke-linejoin="round" />
                            <path d="M22.0001 12.5458V7H16.418" stroke="currentColor" stroke-width="1.5"
                                stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                    <div id="ticketSalesChart" class="mb-6"></div>

                </div>

                <div class="panel h-full overflow-hidden before:bg-[#1937cc] before:absolute before:-right-44 before:top-0 before:bottom-0 before:m-auto before:rounded-full before:w-96 before:h-96 grid grid-cols-1 content-between"
                    style="background:linear-gradient(0deg,#00c6fb -227%,#005bea)!important;">
                    <div class="flex items-start justify-between text-white-light mb-16 z-[7]">
                        <h5 class="font-semibold text-lg">Total Saldo</h5>

                        <div class="relative text-xl whitespace-nowrap">
                            @currency($data['balance'])
                            <span
                                class="table text-[#d3d3d3] bg-[#4361ee] rounded p-1 text-xs mt-1 ltr:ml-auto rtl:mr-auto">@currency($data['net_today'])
                            </span>
                        </div>
                    </div>
                    <div class="flex items-center justify-between z-10">
                        <div class="flex items-center justify-between">
                            <a href="{{ route('bank.index') }}"
                                class="shadow-[0_0_2px_0_#bfc9d4] rounded p-1 text-white-light hover:bg-[#1937cc] place-content-center ltr:mr-2 rtl:ml-2">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <line x1="12" y1="5" x2="12" y2="19"></line>
                                    <line x1="5" y1="12" x2="19" y2="12"></line>
                                </svg>
                            </a>
                            <a href="{{ route('bank.index') }}"
                                class="shadow-[0_0_2px_0_#bfc9d4] rounded p-1 text-white-light hover:bg-[#1937cc] grid place-content-center">
                                <svg class="w-5 h-5" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path
                                        d="M2 12C2 8.22876 2 6.34315 3.17157 5.17157C4.34315 4 6.22876 4 10 4H14C17.7712 4 19.6569 4 20.8284 5.17157C22 6.34315 22 8.22876 22 12C22 15.7712 22 17.6569 20.8284 18.8284C19.6569 20 17.7712 20 14 20H10C6.22876 20 4.34315 20 3.17157 18.8284C2 17.6569 2 15.7712 2 12Z"
                                        stroke="currentColor" stroke-width="1.5"></path>
                                    <path opacity="0.5" d="M10 16H6" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M14 16H12.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                    <path opacity="0.5" d="M2 10L22 10" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round"></path>
                                </svg>
                            </a>
                        </div>
                        <a href="{{ route('withdraw.index') }}"
                            class="shadow-[0_0_2px_0_#bfc9d4] rounded p-1 text-white-light hover:bg-[#4361ee] z-10">
                            Tarik Saldo
                        </a>
                    </div>
                </div>

            </div>

            <div class="grid lg:grid-cols-3 gap-6 mb-6">
                <div class="panel h-full p-0 lg:col-span-2">
                    <div
                        class="flex items-start justify-between dark:text-white-light mb-5 p-5 border-b  border-[#e0e6ed] dark:border-[#1b2e4b]">
                        <h5 class="font-semibold text-lg ">Transaksi Bulanan</h5>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg class="w-5 h-5 text-black/70 dark:text-white/70 hover:!text-primary"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0">
                                <li><a href="javascript:;" @click="toggle">View</a></li>
                                <li><a href="javascript:;" @click="toggle">Update</a></li>
                                <li><a href="javascript:;" @click="toggle">Download</a></li>
                            </ul>
                        </div>
                    </div>

                    <div id="transactionMonthly"></div>
                </div>

                <div class="panel h-full">
                    <div
                        class="flex items-start justify-between dark:text-white-light mb-5 -mx-5 p-5 pt-0 border-b  border-[#e0e6ed] dark:border-[#1b2e4b]">
                        <h5 class="font-semibold text-lg ">Booking</h5>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg class="w-5 h-5 text-black/70 dark:text-white/70 hover:!text-primary"
                                    viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0">
                                <li><a href="javascript:;" @click="toggle">View All</a></li>
                                <li><a href="javascript:;" @click="toggle">Mark as Read</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="perfect-scrollbar relative h-[360px] pr-3 -mr-3">
                         <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ltr:rounded-l-md rtl:rounded-r-md">ID</th>
                                    <th>NAME</th>
                                    <th>AMOUNT</th>
                                    <th class="text-center ltr:rounded-r-md rtl:rounded-l-md">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data['booking'] as $index => $booking )
                                    <tr>
                                        <td class="font-semibold">#{{ $index +1}}</td>
                                        <td class="whitespace-nowrap">{{ $booking->name }}</td>
                                        <td>@currency($booking->total_amount)</td>
                                        <td class="text-center">
                                            @php
                                                 $status = $booking->booking_status;
                                                $badgeClass = match ($status) {
                                                    'paid' => 'bg-success/20 text-success',
                                                    'pending' => 'bg-warning/20 text-warning',
                                                    'cancelled' => 'bg-danger/20 text-danger',
                                                    default => 'bg-gray-200 text-gray-700',
                                                };
                                            @endphp
                                            <span class="badge {{ $badgeClass }} rounded-full hover:top-0">
                                                {{ ucfirst($status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    </div>
                    </div>
                </div>
            </div>

            <div class="panel mb-6">
            <div class="text-lg font-bold mb-3">Transaksi Terakhir</div>
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                        <th>Kode</th>
                        <th>Tanggal</th>
                        <th>Nama</th>
                        <th>Jumlah</th>
                        <th>Metode Pembayaran</th>
                        <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($data['transactions'] as $trx )
                            <tr>
                                <td>#{{ $trx->transaction_code }}</td>
                                <td>{{ $trx->transaction_date }}</td>
                                <td>{{$trx->book->name ?? '-'}}</td>
                                <td>@currency($trx->amount)</td>
                                <td>{{ $trx->payment_method }}</td>
                                <td><span class="badge bg-success/20 text-success">{{ $trx->payment_status }}</span></td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script>
       //PieChart
        document.addEventListener('DOMContentLoaded', function () {
        const options = {
            series: @json($data['pie_chart']['series']),
            labels: @json($data['pie_chart']['labels']),
            chart: {
                    height: 200,
                    type: 'donut',
                    zoom: {
                        enabled: false
                    },
                    toolbar: {
                        show: false
                    }
                },
            dataLabels: {
                formatter: function (val, opts) {
                    const total = opts.w.config.series.reduce((a, b) => a + b, 0);
                    const value = opts.w.config.series[opts.seriesIndex];
                    return 'Rp ' + value.toLocaleString('id-ID');
                }
            },
            tooltip: {
                y: {
                    formatter: function (val) {
                        return 'Rp ' + val.toLocaleString('id-ID');
                    }
                }
            },
            legend: {
                show: false,
            },
            colors: ['#4361ee', '#805dca', '#e2a03f'],
            responsive: [{
                breakpoint: 480,
                options: {
                    chart: { width: 300 },
                }
            }]
        };

        const chart = new ApexCharts(document.querySelector("#chartTransaksi"), options);
        chart.render();
    });

    //ticket chart
    document.addEventListener('DOMContentLoaded', function () {
            const options = {
                chart: {
                    type: 'area',
                    height: 100,
                    toolbar: { show: false }
                },
                series: [{
                    name: 'Tiket Terbit',
                    data: {!! json_encode($data['ticket_chart']['totals']) !!}
                }],
                xaxis: {
                    categories: {!! json_encode($data['ticket_chart']['dates']) !!},
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        style: {
                            colors: '#999',
                            fontSize: '12px'
                        }
                    }
                },
                stroke: {
                    curve: 'smooth',
                    width: 3,
                    colors: ['#22c55e'] // Hijau tailwind
                },
                fill: {
                    type: 'solid',
                    colors: ['#dcfce7'], // Hijau muda
                    opacity: 0.3
                },
                dataLabels: {
                    enabled: false
                },
                grid: {
                    show: false
                },
                tooltip: {
                    y: {
                        formatter: val => `${val} tiket`
                    }
                }
            };

            const chart = new ApexCharts(document.querySelector("#ticketSalesChart"), options);
            chart.render();
        });


        //transaction monthly chart
        document.addEventListener('DOMContentLoaded', function () {
        const options = {
            chart: {
                type: 'area',
                height: 300,
                toolbar: { show: false }
            },
            series: [{
                name: 'Transaksi',
                data: {!! json_encode($data['transaction_monthly']['totals']) !!}
            }],
            xaxis: {
                    categories: {!! json_encode($data['transaction_monthly']['months']) !!}
            },
            yaxis: {
                    labels: {
                        formatter: function (val) {
                            return 'Rp ' + val.toLocaleString('id-ID');
                        },
                        style: {
                            fontSize: '14px'
                        }
                    }
            },
            stroke: {
                curve: 'smooth',
                width: 3
            },
            fill: {
                type: 'gradient',
                gradient: {
                    shade: 'light',
                    type: 'vertical',
                    shadeIntensity: 0.5,
                    opacityFrom: 0.4,
                    opacityTo: 0.1,
                    stops: [0, 100]
                }
            },
            colors: ['#22c55e'], // hijau
            markers: {
                size: 5,
                colors: ['#22c55e'],
                strokeColor: '#fff',
                strokeWidth: 2
            },
            dataLabels: {
                enabled: false
            },
            tooltip: {
                y: {
                    formatter: val => `Rp ${val.toLocaleString()}`
                }
            },
            grid: {
                borderColor: '#e0e6ed',
                row: {
                    colors: ['transparent'],
                    opacity: 0.5
                }
            }
        };

            const chart = new ApexCharts(document.querySelector("#transactionMonthly"), options);
            chart.render();
        });
    </script>
</x-layout.default>
