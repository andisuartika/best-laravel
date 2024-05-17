<x-layout.default>

    <script defer src="/assets/js/apexcharts.js"></script>
    <div x-data="finance">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Finance</span>
            </li>
        </ul>
        <div class="pt-5">
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-6 mb-6 text-white">
                <!-- Users Visit -->
                <div class="panel bg-gradient-to-r from-cyan-500 to-cyan-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Pengunjung</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">
                                <li><a href="javascript:;" @click="toggle">View Report</a></li>
                                <li><a href="javascript:;" @click="toggle">Edit Report</a></li>
                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> 250</div>
                        <div class="badge bg-white/30">+ 10% </div>
                    </div>
                    <div class="flex items-center font-semibold mt-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path opacity="0.5"
                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                            <path
                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                        Last Week 200
                    </div>
                </div>

                <!-- Sessions -->
                <div class="panel bg-gradient-to-r from-violet-500 to-violet-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Penjualan Tiket</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">

                                <li><a href="javascript:;" @click="toggle">View Report</a></li>
                                <li><a href="javascript:;" @click="toggle">Edit Report</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> Rp 1.250.000 </div>
                        <div class="badge bg-white/30">+ 5% </div>
                    </div>
                    <div class="flex items-center font-semibold mt-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path opacity="0.5"
                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                            <path
                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                        Last Week Rp 900.000
                    </div>
                </div>

                <!-- Destinasi -->
                <div class="panel bg-gradient-to-r from-blue-500 to-blue-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Destinasi</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">
                                <li><a href="javascript:;" @click="toggle">View Report</a></li>
                                <li><a href="javascript:;" @click="toggle">Edit Report</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> 10 </div>
                    </div>
                    <div class="flex items-center font-semibold mt-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path opacity="0.5"
                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                            <path
                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                        Destinasi Aktif 8
                    </div>
                </div>

                <!-- Akomodasi -->
                <div class="panel bg-gradient-to-r from-fuchsia-500 to-fuchsia-400">
                    <div class="flex justify-between">
                        <div class="ltr:mr-1 rtl:ml-1 text-md font-semibold">Akomodasi</div>
                        <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                            <a href="javascript:;" @click="toggle">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hover:opacity-80 opacity-70">
                                    <circle cx="5" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle opacity="0.5" cx="12" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                    <circle cx="19" cy="12" r="2" stroke="currentColor"
                                        stroke-width="1.5" />
                                </svg>
                            </a>
                            <ul x-cloak x-show="open" x-transition x-transition.duration.300ms
                                class="ltr:right-0 rtl:left-0 text-black dark:text-white-dark">
                                <li><a href="javascript:;" @click="toggle">View Report</a></li>
                                <li><a href="javascript:;" @click="toggle">Edit Report</a></li>

                            </ul>
                        </div>
                    </div>
                    <div class="flex items-center mt-5">
                        <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3"> 5 </div>
                    </div>
                    <div class="flex items-center font-semibold mt-5">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 ltr:mr-2 rtl:ml-2 shrink-0">
                            <path opacity="0.5"
                                d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                            <path
                                d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z"
                                stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                        Akomodasi Aktif 5
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <!-- Favorites -->
                <div>
                    <div class="flex items-center mb-5 font-bold">
                        <span class="text-lg">Destinasi Baru</span>
                        <a href="javascript:;"
                            class="ltr:ml-auto rtl:mr-auto text-primary hover:text-black dark:hover:text-white-dark">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 md:mb-5">
                        <div
                            class="space-y-5 rounded-md border border-white-light bg-white p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),0px_12px_24px_-4px_rgba(145,158,171,0.12)] dark:border-[#1B2E4B] dark:bg-black">
                            <div class="max-h-56 overflow-hidden rounded-md">
                                <img src="/assets/images/knowledge/image-1.jpg" alt="..."
                                    class="w-full object-cover" />
                            </div>
                            <h5 class="text-sm dark:text-white">Destinasi Baru</h5>
                        </div>

                        <div
                            class="space-y-5 rounded-md border border-white-light bg-white p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),0px_12px_24px_-4px_rgba(145,158,171,0.12)] dark:border-[#1B2E4B] dark:bg-black">
                            <div class="max-h-56 overflow-hidden rounded-md">
                                <img src="/assets/images/knowledge/image-2.jpg" alt="..."
                                    class="w-full object-cover" />
                            </div>
                            <h5 class="text-sm dark:text-white">Destinasi Baru</h5>
                        </div>

                        <div
                            class="space-y-5 rounded-md border border-white-light bg-white p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),0px_12px_24px_-4px_rgba(145,158,171,0.12)] dark:border-[#1B2E4B] dark:bg-black">
                            <div class="max-h-56 overflow-hidden rounded-md">
                                <img src="/assets/images/knowledge/image-3.jpg" alt="..."
                                    class="w-full object-cover" />
                            </div>
                            <h5 class="text-sm dark:text-white">Destinasi Baru</h5>
                        </div>
                    </div>
                </div>

                <div>
                    <div class="flex items-center mb-5 font-bold">
                        <span class="text-lg">Destinasi Favorit</span>
                        <a href="javascript:;"
                            class="ltr:ml-auto rtl:mr-auto text-primary hover:text-black dark:hover:text-white-dark">
                            Lihat Semua
                        </a>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
                        <div
                            class="space-y-5 rounded-md border border-white-light bg-white p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),0px_12px_24px_-4px_rgba(145,158,171,0.12)] dark:border-[#1B2E4B] dark:bg-black">
                            <div class="max-h-56 overflow-hidden rounded-md">
                                <img src="/assets/images/knowledge/image-4.jpg" alt="..."
                                    class="w-full object-cover" />
                            </div>
                            <h5 class="text-sm dark:text-white">Destinasi Favorit</h5>
                        </div>

                        <div
                            class="space-y-5 rounded-md border border-white-light bg-white p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),0px_12px_24px_-4px_rgba(145,158,171,0.12)] dark:border-[#1B2E4B] dark:bg-black">
                            <div class="max-h-56 overflow-hidden rounded-md">
                                <img src="/assets/images/knowledge/image-2.jpg" alt="..."
                                    class="w-full object-cover" />
                            </div>
                            <h5 class="text-sm dark:text-white">Destinasi Favorit</h5>
                        </div>

                        <div
                            class="space-y-5 rounded-md border border-white-light bg-white p-5 shadow-[0px_0px_2px_0px_rgba(145,158,171,0.20),0px_12px_24px_-4px_rgba(145,158,171,0.12)] dark:border-[#1B2E4B] dark:bg-black">
                            <div class="max-h-56 overflow-hidden rounded-md">
                                <img src="/assets/images/knowledge/image-1.jpg" alt="..."
                                    class="w-full object-cover" />
                            </div>
                            <h5 class="text-sm dark:text-white">Destinasi Favorit</h5>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 xl:grid-cols-2 gap-6">
                <div class="grid gap-6 xl:grid-flow-row">
                    <!-- Transaksi Hari Ini -->
                    <div class="panel overflow-hidden">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-lg font-bold">Transaksi Hari Ini</div>
                                <div class="text-success"> Tangal {{ now() }}</div>
                            </div>
                            <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                                <a href="javascript:;" @click="toggle">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 hover:opacity-80 opacity-70">
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
                                    <li><a href="javascript:;" @click="toggle">View Report</a></li>
                                    <li><a href="javascript:;" @click="toggle">Edit Report</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="relative mt-10">
                            <div class="absolute -bottom-12 ltr:-right-12 rtl:-left-12 w-24 h-24">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="text-success opacity-20 w-full h-full">
                                    <circle opacity="0.5" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                <div>
                                    <div class="text-primary">Penjualan Tiket</div>
                                    <div class="mt-2 font-semibold text-2xl">Rp 150.000</div>
                                </div>
                                <div>
                                    <div class="text-primary">Akomodasi</div>
                                    <div class="mt-2 font-semibold text-2xl">Rp 0</div>
                                </div>
                                <div>
                                    <div class="text-primary">Paket Wisata</div>
                                    <div class="mt-2 font-semibold text-2xl">Rp 200.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Transaksi Minggu Ini -->
                    <div class="panel overflow-hidden">
                        <div class="flex items-center justify-between">
                            <div>
                                <div class="text-lg font-bold">Transaksi Minggu Ini</div>
                                <div class="text-success"> Tangal {{ now() }}</div>
                            </div>
                            <div x-data="dropdown" @click.outside="open = false" class="dropdown">
                                <a href="javascript:;" @click="toggle">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                        xmlns="http://www.w3.org/2000/svg"
                                        class="w-5 h-5 hover:opacity-80 opacity-70">
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
                                    <li><a href="javascript:;" @click="toggle">View Report</a></li>
                                    <li><a href="javascript:;" @click="toggle">Edit Report</a></li>

                                </ul>
                            </div>
                        </div>
                        <div class="relative mt-10">
                            <div class="absolute -bottom-12 ltr:-right-12 rtl:-left-12 w-24 h-24">
                                <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                    xmlns="http://www.w3.org/2000/svg" class="text-success opacity-20 w-full h-full">
                                    <circle opacity="0.5" cx="12" cy="12" r="10"
                                        stroke="currentColor" stroke-width="1.5" />
                                    <path d="M8.5 12.5L10.5 14.5L15.5 9.5" stroke="currentColor" stroke-width="1.5"
                                        stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-6">
                                <div>
                                    <div class="text-primary">Penjualan Tiket</div>
                                    <div class="mt-2 font-semibold text-2xl">Rp 550.000</div>
                                </div>
                                <div>
                                    <div class="text-primary">Akomodasi</div>
                                    <div class="mt-2 font-semibold text-2xl">Rp 350.000</div>
                                </div>
                                <div>
                                    <div class="text-primary">Paket Wisata</div>
                                    <div class="mt-2 font-semibold text-2xl">Rp 600.000</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Recent Transactions -->
                <div class="panel">
                    <div class="mb-5 text-lg font-bold">Transaksi Terakhir</div>
                    <div class="table-responsive">
                        <table>
                            <thead>
                                <tr>
                                    <th class="ltr:rounded-l-md rtl:rounded-r-md">ID</th>
                                    <th>Tanggal</th>
                                    <th>Nama</th>
                                    <th>Jumlah</th>
                                    <th class="text-center ltr:rounded-r-md rtl:rounded-l-md">STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-semibold">#01</td>
                                    <td class="whitespace-nowrap">Apr 14, 2024</td>
                                    <td class="whitespace-nowrap">Eric Page</td>
                                    <td>Rp 100.000</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-success/20 text-success rounded-full hover:top-0">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">#02</td>
                                    <td class="whitespace-nowrap">Apr 14, 2024</td>
                                    <td class="whitespace-nowrap">Nita Parr</td>
                                    <td>Rp 99.000</td>
                                    <td class="text-center">
                                        <span class="badge bg-info/20 text-info rounded-full hover:top-0">In
                                            Process</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">#03</td>
                                    <td class="whitespace-nowrap">Apr 13, 2024</td>
                                    <td class="whitespace-nowrap">Carl Bell</td>
                                    <td>Rp 200.000</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-danger/20 text-danger rounded-full hover:top-0">Pending</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">#04</td>
                                    <td class="whitespace-nowrap">Apr 13, 2024</td>
                                    <td class="whitespace-nowrap">Dan Hart</td>
                                    <td>Rp 300.000</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-success/20 text-success rounded-full hover:top-0">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">#05</td>
                                    <td class="whitespace-nowrap">Apr 13, 2024</td>
                                    <td class="whitespace-nowrap">Jake Ross</td>
                                    <td>Rp 500.000</td>
                                    <td class="text-center">
                                        <span
                                            class="badge bg-success/20 text-success rounded-full hover:top-0">Completed</span>
                                    </td>
                                </tr>
                                <tr>
                                    <td class="font-semibold">#06</td>
                                    <td class="whitespace-nowrap">Apr 12, 2024</td>
                                    <td class="whitespace-nowrap">Anna Bell</td>
                                    <td>Rp 750.000</td>
                                    <td class="text-center">
                                        <span class="badge bg-info/20 text-info rounded-full hover:top-0">In
                                            Process</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
        document.addEventListener("alpine:init", () => {
            // finance
            Alpine.data("finance", () => ({
                init() {
                    const bitcoin = null;
                    const ethereum = null;
                    const litecoin = null;
                    const binance = null;
                    const tether = null;
                    const solana = null;

                    setTimeout(() => {
                        this.bitcoin = new ApexCharts(this.$refs.bitcoin, this.bitcoinOptions);
                        this.bitcoin.render();

                        this.ethereum = new ApexCharts(this.$refs.ethereum, this
                            .ethereumOptions);
                        this.ethereum.render();

                        this.litecoin = new ApexCharts(this.$refs.litecoin, this
                            .litecoinOptions);
                        this.litecoin.render();

                        this.binance = new ApexCharts(this.$refs.binance, this.binanceOptions);
                        this.binance.render();

                        this.tether = new ApexCharts(this.$refs.tether, this.tetherOptions);
                        this.tether.render();

                        this.solana = new ApexCharts(this.$refs.solana, this.solanaOptions);
                        this.solana.render();
                    }, 300);

                },

                get bitcoinOptions() {
                    return {
                        series: [{
                            data: [21, 9, 36, 12, 44, 25, 59, 41, 25, 66]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#00ab55'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get ethereumOptions() {
                    return {
                        series: [{
                            data: [44, 25, 59, 41, 66, 25, 21, 9, 36, 12]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#e7515a'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get litecoinOptions() {
                    return {
                        series: [{
                            data: [9, 21, 36, 12, 66, 25, 44, 25, 41, 59]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#00ab55'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get binanceOptions() {
                    return {
                        series: [{
                            data: [25, 44, 25, 59, 41, 21, 36, 12, 19, 9]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#e7515a'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get tetherOptions() {
                    return {
                        series: [{
                            data: [21, 59, 41, 44, 25, 66, 9, 36, 25, 12]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#00ab55'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                },

                get solanaOptions() {
                    return {
                        series: [{
                            data: [21, -9, 36, -12, 44, 25, 59, -41, 66, -25]
                        }],
                        chart: {
                            height: 45,
                            type: 'line',
                            sparkline: {
                                enabled: true
                            },
                        },
                        stroke: {
                            width: 2
                        },
                        markers: {
                            size: 0
                        },
                        colors: ['#e7515a'],
                        grid: {
                            padding: {
                                top: 0,
                                bottom: 0,
                                left: 0
                            }
                        },
                        tooltip: {
                            x: {
                                show: false
                            },
                            y: {
                                title: {
                                    formatter: formatter = () => {
                                        return '';
                                    },
                                },
                            },
                        },
                        responsive: [{
                            breakPoint: 576,
                            options: {
                                chart: {
                                    height: 95
                                },
                                grid: {
                                    padding: {
                                        top: 45,
                                        bottom: 0,
                                        left: 0
                                    }
                                }
                            }
                        }],
                    }
                }
            }));
        });
    </script>

</x-layout.default>
