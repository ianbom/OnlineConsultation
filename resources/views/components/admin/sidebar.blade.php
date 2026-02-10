<div :class="{ 'dark text-white-dark': $store.app.semidark }">
    <nav x-data="sidebar"
        class="sidebar fixed min-h-screen h-full top-0 bottom-0 w-[260px] shadow-[5px_0_25px_0_rgba(94,92,154,0.1)] z-50 transition-all duration-300">
        <div class="bg-secondary dark:bg-[#0e1726] h-full">
            <div class="flex justify-between items-center px-4 py-3">
                <a href="/" class="main-logo flex items-center shrink-0">
                    <img class="w-8 ml-[5px] flex-none" src="/LogoPqNew.png"
                        alt="image" />
                    <span
                        class="text-xl ltr:ml-1.5 rtl:mr-1.5  font-semibold  align-middle lg:inline dark:text-white-light">PersonaQuality</span>
                </a>
                <a href="javascript:;"
                    class="collapse-icon w-8 h-8 rounded-full flex items-center hover:bg-gray-500/10 dark:hover:bg-dark-light/10 dark:text-white-light transition duration-300 rtl:rotate-180"
                    @click="$store.app.toggleSidebar()">
                    <svg class="w-5 h-5 m-auto" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        xmlns="http://www.w3.org/2000/svg">
                        <path d="M13 19L7 12L13 5" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                            stroke-linejoin="round" />
                        <path opacity="0.5" d="M16.9998 19L10.9998 12L16.9998 5" stroke="currentColor"
                            stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                    </svg>
                </a>
            </div>
            <ul class="perfect-scrollbar relative font-semibold space-y-0.5 h-[calc(100vh-80px)] overflow-y-auto overflow-x-hidden  p-4 py-0"
                x-data="{ activeDropdown: null }">
                 <li class="nav-item">
                    <ul>
                        <li class="nav-item">
                            <a href="/admin/dashboard" class="group">
                                <div class="flex items-center">
                                    <svg class="group-hover:!text-primary shrink-0" width="20" height="20" viewBox="0 0 24 24"
                                        fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M2 12.2039C2 9.91549 2 8.77128 2.5192 7.82274C3.0384 6.87421 3.98695 6.28551 5.88403 5.10813L7.88403 3.86687C9.88939 2.62229 10.8921 2 12 2C13.1079 2 14.1106 2.62229 16.116 3.86687L18.116 5.10812C20.0131 6.28551 20.9616 6.87421 21.4808 7.82274C22 8.77128 22 9.91549 22 12.2039V13.725C22 17.6258 22 19.5763 20.8284 20.7881C19.6569 22 17.7712 22 14 22H10C6.22876 22 4.34315 22 3.17157 20.7881C2 19.5763 2 17.6258 2 13.725V12.2039Z"
                                            fill="currentColor" />
                                        <path
                                            d="M9 17.25C8.58579 17.25 8.25 17.5858 8.25 18C8.25 18.4142 8.58579 18.75 9 18.75H15C15.4142 18.75 15.75 18.4142 15.75 18C15.75 17.5858 15.4142 17.25 15 17.25H9Z"
                                            fill="currentColor" />
                                    </svg>

                                    <span
                                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Dashboard</span>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">

                    <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Counselors Data</span>
                </h2>

                <li class="nav-item">
                    <ul>
                        <li class="nav-item">
                            <a href="/admin/counselor" class="group">
                                <div class="flex items-center">

                                    <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                            fill="currentColor" />
                                        <path
                                            d="M4 20C4 16.6863 7.58172 14 12 14C16.4183 14 20 16.6863 20 20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span
                                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Counselors</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/workday" class="group">
                                <div class="flex items-center">

                                    <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V15C21 17.8284 21 19.2426 20.1213 20.1213C19.2426 21 17.8284 21 15 21H9C6.17157 21 4.75736 21 3.87868 20.1213C3 19.2426 3 17.8284 3 15V9Z"
                                            fill="currentColor" />
                                        <path
                                            d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V9.5C21 9.5 21 9.5 3 9.5C3 9.5 3 9.5 3 9Z"
                                            fill="currentColor" />
                                        <circle cx="9" cy="15" r="1" fill="currentColor" />
                                        <circle cx="12" cy="15" r="1" fill="currentColor" />
                                        <circle cx="15" cy="15" r="1" fill="currentColor" />
                                        <circle cx="9" cy="18" r="1" fill="currentColor" />
                                        <circle cx="12" cy="18" r="1" fill="currentColor" />
                                    </svg>
                                    <span
                                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Work Days</span>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                 <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">

                    <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Bookings Data</span>
                </h2>

                <li class="nav-item">
                    <ul>
                        <li class="nav-item">
                            <a href="/admin/booking" class="group">
                                <div class="flex items-center">

                                    <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V15C21 17.8284 21 19.2426 20.1213 20.1213C19.2426 21 17.8284 21 15 21H9C6.17157 21 4.75736 21 3.87868 20.1213C3 19.2426 3 17.8284 3 15V9Z"
                                            fill="currentColor" />
                                        <path
                                            d="M3 9C3 6.17157 3 4.75736 3.87868 3.87868C4.75736 3 6.17157 3 9 3H15C17.8284 3 19.2426 3 20.1213 3.87868C21 4.75736 21 6.17157 21 9V9.5H3V9Z"
                                            fill="currentColor" />
                                        <path d="M8 15.5L10 17.5L16 11.5" stroke="currentColor" stroke-width="1.8"
                                            stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <span
                                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Bookings</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="/admin/refund" class="group">
                                <div class="flex items-center">

                                    <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M3.99971 5.81L7.08971 2.72C7.37971 2.43 7.37971 1.95 7.08971 1.66C6.79971 1.37 6.31971 1.37 6.02971 1.66L1.34971 6.34C1.01971 6.67 1.01971 7.21 1.34971 7.54L6.02971 12.22C6.31971 12.51 6.79971 12.51 7.08971 12.22C7.37971 11.93 7.37971 11.45 7.08971 11.16L3.99971 8.07C3.99971 8.07 3.99971 8.07 3.99971 8.07"
                                            fill="currentColor" />
                                        <path
                                            d="M20 3.5H10C8.067 3.5 6.5 5.067 6.5 7V14C6.5 15.933 8.067 17.5 10 17.5H20C21.933 17.5 23.5 15.933 23.5 14V7C23.5 5.067 21.933 3.5 20 3.5Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M12.75 11.25C12.75 12.0784 12.0784 12.75 11.25 12.75C10.4216 12.75 9.75 12.0784 9.75 11.25C9.75 10.4216 10.4216 9.75 11.25 9.75C12.0784 9.75 12.75 10.4216 12.75 11.25Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span
                                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Refund</span>
                                </div>
                            </a>
                        </li>

                    </ul>
                </li>

                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">

                    <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Clients Data</span>
                </h2>

                <li class="nav-item">
                    <ul>
                        <li class="nav-item">
                            <a href="/admin/client" class="group">
                                <div class="flex items-center">

                                    <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M16 11C17.6569 11 19 9.65685 19 8C19 6.34315 17.6569 5 16 5C14.3431 5 13 6.34315 13 8C13 9.65685 14.3431 11 16 11Z"
                                            fill="currentColor" />
                                        <path
                                            d="M8 11C9.65685 11 11 9.65685 11 8C11 6.34315 9.65685 5 8 5C6.34315 5 5 6.34315 5 8C5 9.65685 6.34315 11 8 11Z"
                                            fill="currentColor" />
                                        <path
                                            d="M2 20C2 17.2386 4.68629 15 8 15C11.3137 15 14 17.2386 14 20C14 21.1046 13.1046 22 12 22H4C2.89543 22 2 21.1046 2 20Z"
                                            fill="currentColor" />
                                        <path opacity="0.5"
                                            d="M14.5 20C14.5 17.7234 16.4101 15.8146 18.9054 15.2013C20.9207 15.8619 22 17.1537 22 18.8C22 20.5673 20.5673 22 18.8 22H16.5C15.3954 22 14.5 21.1046 14.5 20Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span
                                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Clients</span>
                                </div>
                            </a>
                        </li>


                    </ul>
                </li>

                <h2
                    class="py-3 px-7 flex items-center uppercase font-extrabold bg-white-light/30 dark:bg-dark dark:bg-opacity-[0.08] -mx-4 mb-1">

                    <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                        fill="none" stroke-linecap="round" stroke-linejoin="round">
                        <line x1="5" y1="12" x2="19" y2="12"></line>
                    </svg>
                    <span>Account</span>
                </h2>

                <li class="nav-item">
                    <ul>
                        <li class="nav-item">
                            <a href="/admin/profile" class="group">
                                <div class="flex items-center">
                                    <svg class="group-hover:!text-primary shrink-0" width="20" height="20"
                                        viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.5"
                                            d="M12 12C14.7614 12 17 9.76142 17 7C17 4.23858 14.7614 2 12 2C9.23858 2 7 4.23858 7 7C7 9.76142 9.23858 12 12 12Z"
                                            fill="currentColor" />
                                        <path
                                            d="M4 20C4 16.6863 7.58172 14 12 14C16.4183 14 20 16.6863 20 20C20 21.1046 19.1046 22 18 22H6C4.89543 22 4 21.1046 4 20Z"
                                            fill="currentColor" />
                                    </svg>
                                    <span
                                        class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Profile</span>
                                </div>
                            </a>
                        </li>
                        <li class="nav-item">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit" class="group w-full text-left">
                                    <div class="flex items-center">
                                        <svg class="group-hover:!text-danger shrink-0" width="20" height="20"
                                            viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path opacity="0.5"
                                                d="M15 2H14C11.1716 2 9.75736 2 8.87868 2.87868C8 3.75736 8 5.17157 8 8V16C8 18.8284 8 20.2426 8.87868 21.1213C9.75736 22 11.1716 22 14 22H15C17.8284 22 19.2426 22 20.1213 21.1213C21 20.2426 21 18.8284 21 16V8C21 5.17157 21 3.75736 20.1213 2.87868C19.2426 2 17.8284 2 15 2Z"
                                                fill="currentColor" />
                                            <path
                                                d="M8 8C8 6.46249 8 5.34287 8.14114 4.5H8C5.17157 4.5 3.75736 4.5 2.87868 5.37868C2 6.25736 2 7.67157 2 10.5V13.5C2 16.3284 2 17.7426 2.87868 18.6213C3.75736 19.5 5.17157 19.5 8 19.5H8.14114C8 18.6571 8 17.5375 8 16V8Z"
                                                fill="currentColor" />
                                            <path
                                                d="M12.2929 8.29289C12.6834 7.90237 13.3166 7.90237 13.7071 8.29289L16.7071 11.2929C17.0976 11.6834 17.0976 12.3166 16.7071 12.7071L13.7071 15.7071C13.3166 16.0976 12.6834 16.0976 12.2929 15.7071C11.9024 15.3166 11.9024 14.6834 12.2929 14.2929L13.5858 13H5C4.44772 13 4 12.5523 4 12C4 11.4477 4.44772 11 5 11H13.5858L12.2929 9.70711C11.9024 9.31658 11.9024 8.68342 12.2929 8.29289Z"
                                                fill="currentColor" />
                                        </svg>
                                        <span
                                            class="ltr:pl-3 rtl:pr-3 text-black dark:text-[#506690] dark:group-hover:text-white-dark">Logout</span>
                                    </div>
                                </button>
                            </form>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </nav>
</div>


<script>
    document.addEventListener("alpine:init", () => {
        Alpine.data("sidebar", () => ({
            init() {
                const selector = document.querySelector('.sidebar ul a[href="' + window.location
                    .pathname + '"]');
                if (selector) {
                    selector.classList.add('active');
                    const ul = selector.closest('ul.sub-menu');
                    if (ul) {
                        let ele = ul.closest('li.menu').querySelectorAll('.nav-link');
                        if (ele) {
                            ele = ele[0];
                            setTimeout(() => {
                                ele.click();
                            });
                        }
                    }
                }
            },
        }));
    });
</script>
