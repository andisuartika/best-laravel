<x-layout.default>
    <script src="https://cdn.ckeditor.com/ckeditor5/41.3.1/classic/ckeditor.js"></script>
    <script src="/assets/js/file-upload-with-preview.iife.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <div x-data="form">
        <ul class="flex space-x-2 rtl:space-x-reverse">
            <li>
                <a href="javascript:;" class="text-primary hover:underline">Profile Desa</a>
            </li>
            <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
                <span>Informasi</span>
            </li>
        </ul>
        <div
            class="panel flex items-center overflow-x-auto whitespace-nowrap p-3 text-primary __web-inspector-hide-shortcut__ mt-3">
            <div class="rounded-full bg-primary p-1.5 text-white ring-2 ring-primary/30 ltr:mr-3 rtl:ml-3">
                <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="h-3.5 w-3.5">
                    <path
                        d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z"
                        stroke="currentColor" stroke-width="1.5"></path>
                    <path opacity="0.5" d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </div>
            <span class="ltr:mr-3 rtl:ml-3">Informasi Desa : </span> Silahkan lengkapi data Desa Wisata
        </div>
        <div class="pt-5 space-y-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                <!-- Text & Icon -->
                <div class="panel lg:col-span-2">
                    <!-- basic -->
                    <div class="mb-5" x-data="{ activeTab: {{ session('success') != null ? session('success') : 1 }} }">

                        <div class="inline-block w-full">
                            <div class="relative z-[1]">
                                <div class="bg-primary w-[15%] h-1 absolute ltr:left-0 rtl:right-0 top-[30px] m-auto -z-[1] transition-[width]"
                                    :class="{
                                        'w-[15%]': activeTab === 1,
                                        'w-5/12': activeTab === 2,
                                        'w-8/12': activeTab === 3,
                                        'w-full': activeTab ===
                                            4
                                    }">
                                </div>
                                <ul class="mb-5 grid grid-cols-4">
                                    <li class="mx-auto">
                                        <a href="javascript:;"
                                            class="border-[3px] border-[#f3f2ee] bg-white dark:bg-[#253b5c] dark:border-[#1b2e4b] flex justify-center items-center w-16 h-16 rounded-full"
                                            :class="{ '!border-primary !bg-primary text-white': activeTab === 1 }"
                                            @click="activeTab = 1">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.25 7.70031C5.25 4.10215 8.30876 1.25 12 1.25C15.608 1.25 18.6116 3.97488 18.7454 7.45788L19.2231 7.61714C19.6863 7.77148 20.0922 7.90676 20.4142 8.05657C20.7623 8.21853 21.0814 8.42714 21.3253 8.76554C21.5692 9.10394 21.6662 9.47259 21.7098 9.85407C21.7501 10.207 21.75 10.6348 21.75 11.123V16.8712C21.75 17.4806 21.7501 18.0005 21.7028 18.4176C21.653 18.8563 21.5418 19.2875 21.2404 19.6553C21.0674 19.8665 20.8573 20.0445 20.6205 20.1805C20.2081 20.4173 19.7645 20.4561 19.3236 20.433C18.9044 20.4111 18.3915 20.3256 17.7904 20.2254L17.7488 20.2185C16.456 20.003 15.9351 19.9216 15.4274 19.9641C15.2417 19.9796 15.0571 20.0074 14.875 20.0471C14.3774 20.1558 13.8988 20.3891 12.716 20.9805C12.6749 21.0011 12.6342 21.0214 12.594 21.0415C11.2114 21.7331 10.3595 22.1592 9.44031 22.2923C9.16384 22.3323 8.88482 22.3522 8.60546 22.3516C7.67668 22.3499 6.77995 22.0508 5.32536 21.5657C5.28328 21.5517 5.24074 21.5375 5.19772 21.5231L4.81415 21.3953L4.77684 21.3828C4.31373 21.2285 3.90783 21.0932 3.5858 20.9434C3.23766 20.7815 2.91861 20.5729 2.67471 20.2345C2.4308 19.8961 2.33379 19.5274 2.29024 19.1459C2.24995 18.793 2.24997 18.3652 2.25 17.877L2.25 12.8572C2.24997 12.0711 2.24994 11.4085 2.31729 10.8895C2.38759 10.3478 2.54652 9.81811 2.98262 9.4198C3.11082 9.30271 3.25213 9.20085 3.40375 9.11626C3.91953 8.8285 4.47226 8.84521 5.00841 8.94983C5.11717 8.97105 5.23109 8.99718 5.35019 9.02754C5.28411 8.5817 5.25 8.13723 5.25 7.70031ZM5.74869 10.7093C5.32072 10.5713 4.99224 10.475 4.72113 10.4221C4.32599 10.345 4.19646 10.3917 4.13459 10.4262C4.08405 10.4544 4.03694 10.4883 3.99421 10.5274C3.9419 10.5751 3.85663 10.6833 3.80482 11.0825C3.75151 11.4933 3.75 12.0575 3.75 12.908V17.8377C3.75 18.3768 3.75114 18.7181 3.78055 18.9758C3.80779 19.2143 3.85234 19.303 3.89157 19.3574C3.9308 19.4118 4.00083 19.4821 4.21849 19.5834C4.45364 19.6928 4.77709 19.8018 5.28849 19.9723L5.67205 20.1001C7.29563 20.6413 7.95089 20.8504 8.6083 20.8516C8.81478 20.852 9.02101 20.8374 9.22537 20.8078C9.87582 20.7136 10.5009 20.411 12.0452 19.6389C12.0765 19.6232 12.1074 19.6078 12.138 19.5925C13.1987 19.062 13.852 18.7352 14.555 18.5817C14.8014 18.5279 15.051 18.4903 15.3023 18.4693C16.0193 18.4093 16.7344 18.5286 17.8945 18.7221C17.9278 18.7276 17.9614 18.7332 17.9954 18.7389C18.6497 18.8479 19.0779 18.9181 19.4019 18.9351C19.7138 18.9514 19.821 18.9098 19.8735 18.8797C19.9524 18.8344 20.0225 18.775 20.0801 18.7046C20.1185 18.6578 20.1771 18.5589 20.2123 18.2486C20.2489 17.9262 20.25 17.4923 20.25 16.829V11.1623C20.25 10.6232 20.2489 10.2819 20.2195 10.0242C20.1922 9.7857 20.1477 9.69703 20.1084 9.64261C20.0692 9.58818 19.9992 9.51787 19.7815 9.41661C19.5464 9.30722 19.2229 9.19821 18.7115 9.02774L18.6527 9.00813C18.4625 10.3095 17.9996 11.6233 17.3173 12.7959C16.4048 14.364 15.0697 15.7299 13.3971 16.4595C12.5094 16.8468 11.4906 16.8468 10.6029 16.4595C8.93027 15.7299 7.59519 14.364 6.68273 12.7959C6.29871 12.136 5.9842 11.4313 5.74869 10.7093ZM12 2.75C9.06383 2.75 6.75 5.00208 6.75 7.70031C6.75 9.11775 7.18744 10.6808 7.97922 12.0415C8.77121 13.4026 9.88753 14.5109 11.2027 15.0847C11.708 15.3051 12.292 15.3051 12.7973 15.0847C14.1125 14.5109 15.2288 13.4026 16.0208 12.0415C16.8126 10.6808 17.25 9.11775 17.25 7.70031C17.25 5.00208 14.9362 2.75 12 2.75ZM12 6.75C11.3096 6.75 10.75 7.30964 10.75 8C10.75 8.69036 11.3096 9.25 12 9.25C12.6904 9.25 13.25 8.69036 13.25 8C13.25 7.30964 12.6904 6.75 12 6.75ZM9.25 8C9.25 6.48122 10.4812 5.25 12 5.25C13.5188 5.25 14.75 6.48122 14.75 8C14.75 9.51878 13.5188 10.75 12 10.75C10.4812 10.75 9.25 9.51878 9.25 8Z"
                                                    fill="#CDD3EF" />
                                            </svg>
                                        </a>
                                        <span class="text-center block mt-2"
                                            :class="{ 'text-primary': activeTab === 1 }">Profile</span>
                                    </li>
                                    <li class="mx-auto">
                                        <a href="javascript:;"
                                            class="border-[3px] border-[#f3f2ee] bg-white dark:bg-[#253b5c] dark:border-[#1b2e4b] flex justify-center items-center w-16 h-16 rounded-full"
                                            :class="{ '!border-primary !bg-primary text-white': activeTab === 2 }"
                                            @click="activeTab = 2">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M10.9265 2.36021C11.2799 2.57626 11.3912 3.03789 11.1752 3.3913C11.0184 3.64775 11.0577 3.97821 11.2702 4.19075L11.3681 4.28863C11.9568 4.87729 12.1738 5.74206 11.9329 6.53894C11.8131 6.93543 11.3945 7.1597 10.998 7.03985C10.6015 6.91999 10.3773 6.50141 10.4971 6.10492C10.578 5.83734 10.5051 5.54695 10.3074 5.34929L10.2096 5.25141C9.50704 4.54889 9.37716 3.45659 9.89537 2.60892C10.1114 2.25551 10.5731 2.14416 10.9265 2.36021Z"
                                                    fill="#CDD3EF" />
                                                <path
                                                    d="M17.6892 4.7217C18.0954 4.80294 18.3588 5.19806 18.2776 5.60423L18.1336 6.32416C17.9354 7.31498 17.2215 8.12364 16.2629 8.44317C15.815 8.59248 15.4814 8.97035 15.3889 9.43333L15.2449 10.1533C15.1636 10.5594 14.7685 10.8229 14.3623 10.7416C13.9562 10.6604 13.6928 10.2653 13.774 9.8591L13.918 9.13916C14.1161 8.14835 14.83 7.33968 15.7886 7.02015C16.2365 6.87084 16.5701 6.49297 16.6627 6.02999L16.8067 5.31005C16.8879 4.90388 17.283 4.64047 17.6892 4.7217Z"
                                                    fill="#CDD3EF" />
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M11.7185 8.81308C10.8999 7.99439 10.2253 7.31977 9.63896 6.88505C9.03319 6.43593 8.35996 6.11944 7.58466 6.30247C6.80936 6.48549 6.34875 7.06964 6.00779 7.74226C5.67776 8.39329 5.37611 9.29836 5.01002 10.3967L3.27998 15.5869C2.83663 16.9168 2.47687 17.996 2.328 18.8329C2.17779 19.6773 2.19294 20.5341 2.82904 21.1702C3.46515 21.8063 4.322 21.8215 5.16641 21.6713C6.00323 21.5224 7.08241 21.1627 8.41228 20.7193L13.6025 18.9893C14.7008 18.6232 15.606 18.3215 16.257 17.9915C16.9296 17.6505 17.5138 17.1899 17.6968 16.4146C17.8798 15.6393 17.5633 14.9661 17.1142 14.3603C16.6795 13.774 16.0049 13.0994 15.1862 12.2808L11.7185 8.81308ZM8.69422 8.05251C8.71099 8.06455 8.72811 8.07704 8.74559 8.09C9.2317 8.45041 9.82802 9.04391 10.7022 9.91808L11.462 10.6779C11.4469 10.7172 11.4302 10.7616 11.4123 10.8108C11.3352 11.022 11.2339 11.3229 11.133 11.6908C10.9321 12.4229 10.7272 13.4402 10.7272 14.5555C10.7272 15.6176 10.933 16.6352 11.132 17.375C11.2149 17.6831 11.2979 17.9477 11.3671 18.1533L8.73243 19.0315C8.72157 18.9822 8.70955 18.9272 8.69653 18.867C8.6356 18.5853 8.55313 18.1911 8.46708 17.7419C8.29333 16.8349 8.11132 15.7354 8.05559 14.8855C7.96353 13.4817 8.14336 11.6498 8.35599 10.1344C8.46128 9.38405 8.57264 8.72455 8.65763 8.25294C8.67047 8.18169 8.68271 8.11477 8.69422 8.05251ZM6.95433 9.35363C6.796 9.78402 6.62217 10.3037 6.41321 10.9306L4.72371 15.9991C4.25474 17.406 3.93207 18.3802 3.80481 19.0956C3.67659 19.8164 3.79593 20.0158 3.8897 20.1096C3.98348 20.2033 4.18292 20.3227 4.90369 20.1945C5.49409 20.0894 6.26086 19.8513 7.30168 19.5076C7.28382 19.4281 7.25947 19.3184 7.23043 19.1841C7.1676 18.8936 7.08263 18.4875 6.99387 18.0241C6.81799 17.1059 6.62092 15.9309 6.5588 14.9836C6.45615 13.4182 6.65541 11.4592 6.87054 9.92601C6.89826 9.72851 6.92637 9.53716 6.95433 9.35363ZM12.7901 17.6789L13.0687 17.5861C14.2415 17.1951 15.039 16.9272 15.5788 16.6536C16.1087 16.385 16.206 16.2009 16.2369 16.07C16.2678 15.939 16.2631 15.7309 15.9093 15.2537C15.5489 14.7676 14.9554 14.1713 14.0812 13.2971L12.6446 11.8605C12.6232 11.9323 12.6013 12.0082 12.5795 12.0877C12.4013 12.7372 12.2272 13.6154 12.2272 14.5555C12.2272 15.1741 12.3123 15.7905 12.4252 16.3343C12.4734 16.5663 12.5266 16.7852 12.5805 16.9853C12.6549 17.262 12.7292 17.4983 12.7901 17.6789Z"
                                                    fill="#CDD3EF" />
                                                <path
                                                    d="M20.3306 12.73C20.6259 12.4681 21.0466 12.4016 21.4083 12.5598L21.6998 12.6872C22.0793 12.8532 22.5215 12.68 22.6874 12.3005C22.8534 11.921 22.6802 11.4788 22.3007 11.3129L22.0092 11.1854C21.1118 10.793 20.0682 10.9579 19.3354 11.6077C19.0092 11.8969 18.5345 11.945 18.157 11.727L17.9441 11.6041C17.5854 11.397 17.1267 11.5199 16.9196 11.8787C16.7125 12.2374 16.8354 12.6961 17.1941 12.9032L17.407 13.0261C18.3437 13.5669 19.5213 13.4476 20.3306 12.73Z"
                                                    fill="#CDD3EF" />
                                                <path
                                                    d="M13.9789 4.058C13.8627 4.09485 13.7621 4.19537 13.5611 4.39643C13.36 4.59749 13.2595 4.69802 13.2227 4.81425C13.1915 4.91257 13.1915 5.01812 13.2227 5.11644C13.2595 5.23268 13.36 5.3332 13.5611 5.53426C13.7621 5.73532 13.8627 5.83585 13.9789 5.87269C14.0772 5.90386 14.1828 5.90386 14.2811 5.87269C14.3973 5.83585 14.4979 5.73532 14.6989 5.53426C14.9 5.3332 15.0005 5.23268 15.0374 5.11644C15.0685 5.01812 15.0685 4.91257 15.0374 4.81425C15.0005 4.69802 14.9 4.59749 14.6989 4.39643C14.4979 4.19537 14.3973 4.09485 14.2811 4.058C14.1828 4.02683 14.0772 4.02683 13.9789 4.058Z"
                                                    fill="#CDD3EF" />
                                                <path
                                                    d="M19.4683 7.46833C19.7137 7.22294 19.8364 7.10025 19.9748 7.04692C20.1368 6.9845 20.3162 6.9845 20.4782 7.04692C20.6166 7.10025 20.7393 7.22294 20.9847 7.46833C21.2301 7.71372 21.3528 7.83642 21.4061 7.97483C21.4685 8.13681 21.4685 8.3162 21.4061 8.47818C21.3528 8.61659 21.2301 8.73929 20.9847 8.98468C20.7393 9.23007 20.6166 9.35277 20.4782 9.4061C20.3162 9.46851 20.1368 9.46851 19.9748 9.4061C19.8364 9.35277 19.7137 9.23007 19.4683 8.98468C19.223 8.73929 19.1003 8.61659 19.0469 8.47818C18.9845 8.3162 18.9845 8.13681 19.0469 7.97483C19.1003 7.83642 19.223 7.71372 19.4683 7.46833Z"
                                                    fill="#CDD3EF" />
                                                <path
                                                    d="M7.68604 3.9409C7.47657 3.73143 7.13696 3.73143 6.92749 3.9409C6.71802 4.15037 6.71802 4.48999 6.92749 4.69945C7.13696 4.90892 7.47657 4.90892 7.68604 4.69945C7.89551 4.48999 7.89551 4.15037 7.68604 3.9409Z"
                                                    fill="#CDD3EF" />
                                                <path
                                                    d="M19.0583 15.3135C19.2678 15.104 19.6074 15.104 19.8169 15.3135C20.0264 15.5229 20.0264 15.8625 19.8169 16.072C19.6074 16.2815 19.2678 16.2815 19.0583 16.072C18.8489 15.8625 18.8489 15.5229 19.0583 15.3135Z"
                                                    fill="#CDD3EF" />
                                                <path
                                                    d="M18.2587 9.74155C18.0492 9.53208 17.7096 9.53208 17.5001 9.74155C17.2907 9.95102 17.2907 10.2906 17.5001 10.5001C17.7096 10.7096 18.0492 10.7096 18.2587 10.5001C18.4681 10.2906 18.4681 9.95102 18.2587 9.74155Z"
                                                    fill="#CDD3EF" />
                                            </svg>
                                        </a>
                                        <span class="text-center block mt-2"
                                            :class="{ 'text-primary': activeTab === 2 }">Welcoming</span>
                                    </li>
                                    <li class="mx-auto">
                                        <a href="javascript:;"
                                            class="border-[3px] border-[#f3f2ee] bg-white dark:bg-[#253b5c] dark:border-[#1b2e4b] flex justify-center items-center w-16 h-16 rounded-full"
                                            :class="{ '!border-primary !bg-primary text-white': activeTab === 3 }"
                                            @click="activeTab = 3">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M5.25 8.10747C5.25 4.3328 8.25958 1.25 12 1.25C15.7404 1.25 18.75 4.3328 18.75 8.10747C18.75 9.9148 18.2356 11.85 17.3281 13.5209C16.4221 15.1891 15.0919 16.6514 13.4148 17.4353C12.517 17.8549 11.483 17.8549 10.5852 17.4353C8.90807 16.6514 7.57789 15.1891 6.6719 13.5209C5.76445 11.85 5.25 9.9148 5.25 8.10747ZM12 2.75C9.113 2.75 6.75 5.13601 6.75 8.10747C6.75 9.64677 7.19305 11.3375 7.99005 12.805C8.78851 14.2752 9.90972 15.4638 11.2204 16.0764C11.7156 16.3079 12.2844 16.3079 12.7796 16.0764C14.0903 15.4638 15.2115 14.2752 16.01 12.805C16.8069 11.3375 17.25 9.64677 17.25 8.10747C17.25 5.13601 14.887 2.75 12 2.75ZM12 6.75C11.3096 6.75 10.75 7.30964 10.75 8C10.75 8.69036 11.3096 9.25 12 9.25C12.6904 9.25 13.25 8.69036 13.25 8C13.25 7.30964 12.6904 6.75 12 6.75ZM9.25 8C9.25 6.48122 10.4812 5.25 12 5.25C13.5188 5.25 14.75 6.48122 14.75 8C14.75 9.51878 13.5188 10.75 12 10.75C10.4812 10.75 9.25 9.51878 9.25 8ZM3.62731 14.5342C3.88455 14.8589 3.82989 15.3306 3.50523 15.5878C2.93157 16.0424 2.75 16.443 2.75 16.75C2.75 16.993 2.86028 17.288 3.19064 17.6296C3.52438 17.9747 4.04582 18.3252 4.75556 18.6471C6.00981 19.2159 7.74351 19.6466 9.75 19.8343V19.375C9.75 19.0807 9.9221 18.8136 10.1901 18.692C10.4581 18.5704 10.7724 18.6168 10.9939 18.8106L12.4939 20.1231C12.6566 20.2655 12.75 20.4712 12.75 20.6875C12.75 20.9038 12.6566 21.1095 12.4939 21.2519L10.9939 22.5644C10.7724 22.7582 10.4581 22.8046 10.1901 22.683C9.9221 22.5614 9.75 22.2943 9.75 22V21.3404C7.56512 21.1487 5.60927 20.6813 4.13599 20.0131C3.32214 19.644 2.62069 19.1979 2.11244 18.6724C1.60081 18.1434 1.25 17.494 1.25 16.75C1.25 15.7998 1.81667 15.012 2.5737 14.4122C2.89836 14.1549 3.37008 14.2096 3.62731 14.5342ZM20.3727 14.5342C20.6299 14.2096 21.1016 14.1549 21.4263 14.4122C22.1833 15.012 22.75 15.7998 22.75 16.75C22.75 18.1281 21.5819 19.1606 20.2034 19.8514C18.7617 20.5738 16.791 21.0851 14.5756 21.3096C14.1635 21.3514 13.7956 21.0512 13.7538 20.6391C13.7121 20.227 14.0123 19.859 14.4244 19.8173C16.522 19.6047 18.3014 19.1266 19.5314 18.5103C20.8246 17.8623 21.25 17.2066 21.25 16.75C21.25 16.443 21.0684 16.0424 20.4948 15.5878C20.1701 15.3306 20.1155 14.8589 20.3727 14.5342Z"
                                                    fill="#CDD3EF" />
                                            </svg>
                                        </a>
                                        <span class="text-center block mt-2"
                                            :class="{ 'text-primary': activeTab === 3 }">Destination</span>
                                    </li>
                                    <li class="mx-auto">
                                        <a href="javascript:;"
                                            class="border-[3px] border-[#f3f2ee] bg-white dark:bg-[#253b5c] dark:border-[#1b2e4b] flex justify-center items-center w-16 h-16 rounded-full"
                                            :class="{ '!border-primary !bg-primary text-white': activeTab === 4 }"
                                            @click="activeTab = 4">
                                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none"
                                                xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd"
                                                    d="M16.25 3.75V5.43953L18.25 7.03953V3.75H16.25ZM19.75 8.23953V3.5C19.75 2.80964 19.1904 2.25 18.5 2.25H16C15.3097 2.25 14.75 2.80964 14.75 3.5V4.23953L14.3426 3.91362C12.9731 2.81796 11.027 2.81796 9.65742 3.91362L1.53151 10.4143C1.20806 10.6731 1.15562 11.1451 1.41438 11.4685C1.67313 11.792 2.1451 11.8444 2.46855 11.5857L3.25003 10.9605V21.25H2.00003C1.58581 21.25 1.25003 21.5858 1.25003 22C1.25003 22.4142 1.58581 22.75 2.00003 22.75H22C22.4142 22.75 22.75 22.4142 22.75 22C22.75 21.5858 22.4142 21.25 22 21.25H20.75V10.9605L21.5315 11.5857C21.855 11.8444 22.3269 11.792 22.5857 11.4685C22.8444 11.1451 22.792 10.6731 22.4685 10.4143L19.75 8.23953ZM19.25 9.76047L13.4056 5.08492C12.5838 4.42753 11.4162 4.42753 10.5945 5.08492L4.75003 9.76047V21.25H8.25003L8.25003 16.9506C8.24999 16.2858 8.24996 15.7129 8.31163 15.2542C8.37773 14.7625 8.52679 14.2913 8.90904 13.909C9.29128 13.5268 9.76255 13.3777 10.2542 13.3116C10.7129 13.2499 11.2858 13.25 11.9507 13.25H12.0494C12.7143 13.25 13.2871 13.2499 13.7459 13.3116C14.2375 13.3777 14.7088 13.5268 15.091 13.909C15.4733 14.2913 15.6223 14.7625 15.6884 15.2542C15.7501 15.7129 15.7501 16.2858 15.75 16.9506L15.75 21.25H19.25V9.76047ZM14.25 21.25V17C14.25 16.2717 14.2484 15.8009 14.2018 15.454C14.1581 15.1287 14.0875 15.0268 14.0304 14.9697C13.9733 14.9126 13.8713 14.842 13.546 14.7982C13.1991 14.7516 12.7283 14.75 12 14.75C11.2717 14.75 10.8009 14.7516 10.4541 14.7982C10.1288 14.842 10.0268 14.9126 9.9697 14.9697C9.9126 15.0268 9.84199 15.1287 9.79826 15.454C9.75162 15.8009 9.75003 16.2717 9.75003 17V21.25H14.25ZM12 8.25C11.3097 8.25 10.75 8.80964 10.75 9.5C10.75 10.1904 11.3097 10.75 12 10.75C12.6904 10.75 13.25 10.1904 13.25 9.5C13.25 8.80964 12.6904 8.25 12 8.25ZM9.25003 9.5C9.25003 7.98122 10.4812 6.75 12 6.75C13.5188 6.75 14.75 7.98122 14.75 9.5C14.75 11.0188 13.5188 12.25 12 12.25C10.4812 12.25 9.25003 11.0188 9.25003 9.5Z"
                                                    fill="#CDD3EF" />
                                            </svg>
                                        </a>
                                        <span class="text-center block mt-2"
                                            :class="{ 'text-primary': activeTab === 4 }">Accomodation</span>
                                    </li>
                                </ul>
                            </div>
                            <div>
                                <template x-if="activeTab === 1">

                                    <form id="myForm" action="{{ route('store.info-desa') }}" method="POST"
                                        class="py-5" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="section" value="profile">

                                        <label for="ctnFile" class="text-sm">Silahkan lengkapi Profile Desa
                                            Wisata</label>
                                        <textarea id="editor" name="profile" required>{{ $village == null ? '' : $village->profile }}</textarea>
                                        <style>
                                            .ck-editor__editable[role="textbox"] {
                                                /* Editing area */
                                                min-height: 200px;
                                            }
                                        </style>
                                        <script>
                                            ClassicEditor
                                                .create(document.querySelector('#editor'))
                                                .catch(error => {
                                                    console.error(error);
                                                });
                                        </script>
                                        <!-- single file -->
                                        <div class="py-5">
                                            <div>
                                                <label for="ctnFile">Gambar untuk profile Desa Wisata</label>
                                                <input id="ctnFile" type="file"
                                                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                                                    onchange="readURL(this);" name="profile-img" required />
                                                <div class="p-5">
                                                    @if ($village != null && $village->profile_img != null)
                                                        <img id="preview" src="{{ asset($village->profile_img) }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @else
                                                        <img id="preview"
                                                            src="{{ asset('assets/images/file-preview.svg') }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @endif
                                                </div>
                                                <script>
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                $('#preview')
                                                                    .attr('src', e.target.result);
                                                            };

                                                            reader.readAsDataURL(input.files[0]);
                                                        }
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </form>
                                </template>
                                <template x-if="activeTab === 2">
                                    <form id="myForm" action="{{ route('store.info-desa') }}" method="POST"
                                        class="py-5" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="section" value="welcoming">
                                        <!-- basic -->
                                        <label for="ctnFile" class="text-sm">Silahkan lengkapi dengan Kata
                                            Sambutan</label>
                                        <textarea id="editor1" name="welcoming" required>{{ $village == null ? '' : $village->welcoming }}</textarea>
                                        <style>
                                            .ck-editor__editable[role="textbox"] {
                                                /* Editing area */
                                                min-height: 200px;
                                            }
                                        </style>
                                        <script>
                                            ClassicEditor
                                                .create(document.querySelector('#editor1'))
                                                .catch(error => {
                                                    console.error(error);
                                                });
                                        </script>
                                        <!-- single file -->
                                        <div class="py-5">
                                            <div>
                                                <label for="ctnFile">Gambar untuk sambutan</label>
                                                <input id="ctnFile" type="file"
                                                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                                                    onchange="readURL(this);" name="welcoming-img" required />
                                                <div class="p-5">
                                                    @if ($village != null && $village->welcoming_img != null)
                                                        <img id="preview" src="{{ asset($village->welcoming_img) }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @else
                                                        <img id="preview"
                                                            src="{{ asset('assets/images/file-preview.svg') }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @endif
                                                </div>
                                                <script>
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                $('#preview')
                                                                    .attr('src', e.target.result);
                                                            };

                                                            reader.readAsDataURL(input.files[0]);
                                                        }
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </form>
                                </template>
                                <template x-if="activeTab === 3">
                                    <form id="myForm" action="{{ route('store.info-desa') }}" method="POST"
                                        class="py-5" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="section" value="destination">
                                        <!-- basic -->
                                        <label for="ctnFile" class="text-sm">Silahkan lengkapi dengan Deskripsi
                                            Destinasi</label>
                                        <textarea id="editor2" name="destination" required>{{ $village == null ? '' : $village->destination }}</textarea>
                                        <style>
                                            .ck-editor__editable[role="textbox"] {
                                                /* Editing area */
                                                min-height: 200px;
                                            }
                                        </style>
                                        <script>
                                            ClassicEditor
                                                .create(document.querySelector('#editor2'))
                                                .catch(error => {
                                                    console.error(error);
                                                });
                                        </script>
                                        <!-- single file -->
                                        <div class="py-5">
                                            <div>
                                                <label for="ctnFile">Gambar untuk Destinasi</label>
                                                <input id="ctnFile" type="file"
                                                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                                                    onchange="readURL(this);" name="destination-img" required />
                                                <div class="p-5">
                                                    @if ($village != null && $village->destination_img != null)
                                                        <img id="preview"
                                                            src="{{ asset($village->destination_img) }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @else
                                                        <img id="preview"
                                                            src="{{ asset('assets/images/file-preview.svg') }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @endif
                                                </div>
                                                <script>
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                $('#preview')
                                                                    .attr('src', e.target.result);
                                                            };

                                                            reader.readAsDataURL(input.files[0]);
                                                        }
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </form>
                                </template>
                                <template x-if="activeTab === 4">
                                    <form id="myForm" action="{{ route('store.info-desa') }}" method="POST"
                                        class="py-5" enctype="multipart/form-data">
                                        @csrf
                                        <input type="hidden" name="section" value="accomodation">
                                        <!-- basic -->
                                        <label for="ctnFile" class="text-sm">Silahkan lengkapi dengan Deskripsi
                                            Akomodasi</label>
                                        <textarea id="editor3" name="accomodation" required>{{ $village == null ? '' : $village->accomodation }}</textarea>
                                        <style>
                                            .ck-editor__editable[role="textbox"] {
                                                /* Editing area */
                                                min-height: 200px;
                                            }
                                        </style>
                                        <script>
                                            ClassicEditor
                                                .create(document.querySelector('#editor3'))
                                                .catch(error => {
                                                    console.error(error);
                                                });
                                        </script>
                                        <!-- single file -->
                                        <div class="py-5">
                                            <div>
                                                <label for="ctnFile">Gambar untuk akomodasi</label>
                                                <input id="ctnFile" type="file"
                                                    class="form-input file:py-2 file:px-4 file:border-0 file:font-semibold p-0 file:bg-primary/90 ltr:file:mr-5 rtl:file:ml-5 file:text-white file:hover:bg-primary"
                                                    onchange="readURL(this);" name="accomodation-img" required />
                                                <div class="p-5">
                                                    @if ($village != null && $village->accomodation_img != null)
                                                        <img id="preview"
                                                            src="{{ asset($village->accomodation_img) }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @else
                                                        <img id="preview"
                                                            src="{{ asset('assets/images/file-preview.svg') }}"
                                                            alt="your image"
                                                            class="rounded-md m-auto object-fit"style="width: 746px;" />
                                                    @endif
                                                </div>
                                                <script>
                                                    function readURL(input) {
                                                        if (input.files && input.files[0]) {
                                                            var reader = new FileReader();

                                                            reader.onload = function(e) {
                                                                $('#preview')
                                                                    .attr('src', e.target.result);
                                                            };

                                                            reader.readAsDataURL(input.files[0]);
                                                        }
                                                    }
                                                </script>
                                            </div>
                                        </div>
                                    </form>
                                </template>
                            </div>
                            <div class="flex justify-between">
                                <div class="flex gap-3">
                                    <button type="button" class="btn btn-primary" :disabled="activeTab === 1"
                                        @click="activeTab--">Back</button>
                                    <button type="button" class="btn btn-primary" :disabled="activeTab === 4"
                                        @click="activeTab++">Next</button>
                                </div>
                                <button type="button" id="submitButton" class="btn btn-success">Simpan</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start hightlight js -->
    <link rel="stylesheet" href="{{ Vite::asset('resources/css/highlight.min.css') }}">
    <script src="/assets/js/highlight.min.js"></script>
    <script src="https://unpkg.com/file-upload-with-preview/dist/file-upload-with-preview.iife.js"></script>
    <!-- end hightlight js -->

    <script>
        // Wait for the DOM to fully load
        document.addEventListener('DOMContentLoaded', function() {
            // Select the button by its ID
            const submitButton = document.getElementById('submitButton');
            // Add a click event listener to the button
            submitButton.addEventListener('click', function(event) {
                // Prevent the default action of the button
                event.preventDefault();
                // Select the form by its ID and submit it
                document.getElementById('myForm').submit();
            });
        });
    </script>
    <!-- script -->
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
                title: 'Berhasil disimpan!',
                padding: '10px 20px',
            });
        </script>
    @endif
    <script>
        document.addEventListener("alpine:init", () => {
            Alpine.data("form", () => ({
                // highlightjs
                codeArr: [],
                toggleCode(name) {
                    if (this.codeArr.includes(name)) {
                        this.codeArr = this.codeArr.filter((d) => d != name);
                    } else {
                        this.codeArr.push(name);

                        setTimeout(() => {
                            document.querySelectorAll('pre.code').forEach(el => {
                                hljs.highlightElement(el);
                            });
                        });
                    }
                }
            }));
        });
    </script>


</x-layout.default>
