<template>
    <div :class="{ '-translate-x-50': !open }"
        class="fixed aside bg-white shadow-[0px_12px_33px_rgba(0,0,0,0.07)] flex h-screen max-w-53 flex-col rounded-xl ">
        <!-- up logo -->
        <div :class="{ '-right-7': !open }" class="absolute -right-4 top-3 z-20 cursor-pointer">
            <div @click="toggle_aside()"
                class="aside_flesh bg-orange-500 shadow-md border border-gray-100 w-8 h-8 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2"
                    stroke="currentColor" class="flesh size-4 text-white">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
            </div>
        </div>

        <!-- up logo -->
        <div class="flex min-h-10 w-full gap-4 items-center justify-center border-[rgba(0,0,0,0.13)] border-b">
            <img src="/images/Y-TRACK_dark.svg" class="object-contain w-[70px] h-[26px]" />
        </div>
        <!-- main content -->
        <div class="side  overflow-y-auto flex flex-col justify-between w-full  h-full">
            <div class="buttons flex flex-col gap-2 py-4">

                <div>
                    <router-link :to="{name : 'DashboardHome'}">
                        <div class="toggle_button self-center flex h-fit max-w-full w-50 flex-col items-stretch ">
                            <div
                                class="up-btn flex w-full items-center gap-2 overflow-hidden px-3 py-[9px] rounded-[75px]">
                                <div class="flex w-full items-stretch gap-2 my-auto">
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                        stroke-width="1.5" stroke="currentColor" class="size-5">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M3.75 6A2.25 2.25 0 0 1 6 3.75h2.25A2.25 2.25 0 0 1 10.5 6v2.25a2.25 2.25 0 0 1-2.25 2.25H6a2.25 2.25 0 0 1-2.25-2.25V6ZM3.75 15.75A2.25 2.25 0 0 1 6 13.5h2.25a2.25 2.25 0 0 1 2.25 2.25V18a2.25 2.25 0 0 1-2.25 2.25H6A2.25 2.25 0 0 1 3.75 18v-2.25ZM13.5 6a2.25 2.25 0 0 1 2.25-2.25H18A2.25 2.25 0 0 1 20.25 6v2.25A2.25 2.25 0 0 1 18 10.5h-2.25a2.25 2.25 0 0 1-2.25-2.25V6ZM13.5 15.75a2.25 2.25 0 0 1 2.25-2.25H18a2.25 2.25 0 0 1 2.25 2.25V18A2.25 2.25 0 0 1 18 20.25h-2.25A2.25 2.25 0 0 1 13.5 18v-2.25Z" />
                                    </svg>

                                    <p class="font-medium  flex-1">Dashboard</p>
                                </div>

                            </div>

                        </div>
                    </router-link>
                </div>

                <div class="toggle_button self-center flex h-fit max-w-full w-50 flex-col items-stretch ">
                    <div class="up-btn flex w-full items-center gap-2 overflow-hidden px-3 py-[9px] rounded-[75px]">
                        <div class="flex w-full items-center gap-2 justify-between my-auto">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6v12m-3-2.818.879.659c1.171.879 3.07.879 4.242 0 1.172-.879 1.172-2.303 0-3.182C13.536 12.219 12.768 12 12 12c-.725 0-1.45-.22-2.003-.659-1.106-.879-1.106-2.303 0-3.182s2.9-.879 4.006 0l.415.33M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-12 0h.008v.008H6V12M12 9v3.75m3-6v6" />
                            </svg>


                            <p class="  font-medium flex-1">Financial Managment</p>
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="flesh size-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>

                    </div>
                    <ul class="flex flex-col ml-3 gap-3 hidden">
                        <router-link to="/dashboard/Incomes" custom v-slot="{ isActive, navigate }">
                            <li @click="navigate" class="flex gap-2" :class="{ 'router-link-active': isActive }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 18.75a60.07 60.07 0 0 1 15.797 2.101c.727.198 1.453-.342 1.453-1.096V18.75M3.75 4.5v.75A.75.75 0 0 1 3 6h-.75m0 0v-.375c0-.621.504-1.125 1.125-1.125H20.25M2.25 6v9m18-10.5v.75c0 .414.336.75.75.75h.75m-1.5-1.5h.375c.621 0 1.125.504 1.125 1.125v9.75c0 .621-.504 1.125-1.125 1.125h-.375m1.5-1.5H21a.75.75 0 0 0-.75.75v.75m0 0H3.75m0 0h-.375a1.125 1.125 0 0 1-1.125-1.125V15m1.5 1.5v-.75A.75.75 0 0 0 3 15h-.75M15 10.5a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm3 0h.008v.008H18V10.5Zm-12 0h.008v.008H6V10.5Z" />
                                </svg>
                                Income
                            </li>
                        </router-link>

                        <router-link to="/dashboard/Expences" custom v-slot="{ isActive, navigate }">
                            <li @click="navigate" class="flex gap-2" :class="{ 'router-link-active': isActive }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M2.25 6 9 12.75l4.286-4.286a11.948 11.948 0 0 1 4.306 6.43l.776 2.898m0 0 3.182-5.511m-3.182 5.51-5.511-3.181" />
                                </svg>
                                Expenses
                            </li>
                        </router-link>
                        
                        <router-link to="/dashboard/Bills" custom v-slot="{ isActive, navigate }">
                            <li @click="navigate" class="flex gap-2" :class="{ 'router-link-active': isActive }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M8.25 18.75a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h6m-9 0H3.375a1.125 1.125 0 0 1-1.125-1.125V14.25m17.25 4.5a1.5 1.5 0 0 1-3 0m3 0a1.5 1.5 0 0 0-3 0m3 0h1.125c.621 0 1.129-.504 1.09-1.124a17.902 17.902 0 0 0-3.213-9.193 2.056 2.056 0 0 0-1.58-.86H14.25M16.5 18.75h-2.25m0-11.177v-.958c0-.568-.422-1.048-.987-1.106a48.554 48.554 0 0 0-10.026 0 1.106 1.106 0 0 0-.987 1.106v7.635m12-6.677v6.677m0 4.5v-4.5m0 0h-12" />
                                </svg>
                                Bills
                            </li>
                        </router-link>

                        <router-link to="/dashboard/Transactions_History" custom v-slot="{ isActive, navigate }">
                            <li @click="navigate" class="flex gap-2" :class="{ 'router-link-active': isActive }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3.75 3v11.25A2.25 2.25 0 0 0 6 3.75h2.25M3.75 3h-1.5m1.5 0h16.5m0 0h1.5m-1.5 0v11.25A2.25 2.25 0 0 1 18 16.5h-2.25m-7.5 0h7.5m-7.5 0-1 3m8.5-3 1 3m0 0 .5 1.5m-.5-1.5h-9.5m0 0-.5 1.5M9 11.25v1.5M12 9v3.75m3-6v6" />
                                </svg>
                                Transactions History
                            </li>
                        </router-link>


                        <router-link to="/dashboard/Goals" custom v-slot="{ isActive, navigate }">
                            <li @click="navigate" class="flex gap-2" :class="{ 'router-link-active': isActive }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                    viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M3 3v1.5M3 21v-6m0 0 2.77-.693a9 9 0 0 1 6.208.682l.108.054a9 9 0 0 0 6.086.71l3.114-.732a48.524 48.524 0 0 1-.005-10.499l-3.11.732a9 9 0 0 1-6.085-.711l-.108-.054a9 9 0 0 0-6.208-.682L3 4.5M3 15V4.5" />
                                </svg>
                                Goals
                            </li>
                        </router-link>

                    </ul>
                </div>
                <div class="toggle_button self-center flex h-fit max-w-full w-50 flex-col items-stretch ">
                    <div class="up-btn flex w-full items-center gap-2 overflow-hidden px-3 py-[9px] rounded-[75px]">
                        <div class="flex w-full justify-between gap-2 items-center my-auto">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="size-5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M10.5 6a7.5 7.5 0 1 0 7.5 7.5h-7.5V6Z" />
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M13.5 10.5H21A7.5 7.5 0 0 0 13.5 3v7.5Z" />
                            </svg>

                            <p class="  font-medium flex-1">Invoice & Clients</p>

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                                stroke="currentColor" class="flesh size-3">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                            </svg>
                        </div>
                    </div>
                    <ul class="flex flex-col ml-3 gap-3 hidden">
                        <router-link to="/dashboard/Invoices" custom v-slot="{ isActive, navigate }">
                            <li @click="navigate" class="flex gap-2" :class="{ 'router-link-active': isActive }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor" class="size-4">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                                Invoice Generator
                            </li>
                        </router-link>
                        
                        <router-link to="/dashboard/Clients" custom v-slot="{ isActive, navigate }">
                            <li @click="navigate" class="flex gap-2" :class="{ 'router-link-active': isActive }">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 0 0 3.741-.479 3 3 0 0 0-4.682-2.72m.94 3.198.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0 1 12 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 0 1 6 18.719m12 0a5.971 5.971 0 0 0-.941-3.197m0 0A5.995 5.995 0 0 0 12 12.75a5.995 5.995 0 0 0-5.058 2.772m0 0a3 3 0 0 0-4.681 2.72 8.986 8.986 0 0 0 3.74.477m.94-3.197a5.971 5.971 0 0 0-.94 3.197M15 6.75a3 3 0 1 1-6 0 3 3 0 0 1 6 0Zm6 3a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Zm-13.5 0a2.25 2.25 0 1 1-4.5 0 2.25 2.25 0 0 1 4.5 0Z" />
                                </svg>
                                Manage Clients
                            </li>
                        </router-link>
                    </ul>
                </div>
                
                <router-link :to="{name : 'Notifications'}">
                        <div class="toggle_button self-center flex h-fit max-w-full w-50 flex-col items-stretch ">
                            
                            <div
                                class="up-btn flex w-full items-center gap-2 overflow-hidden px-3 py-[9px] rounded-[75px]">
                                <div class="flex w-full items-stretch gap-2 my-auto relative">
                                    <div class="relative">
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                            stroke-width="1.5" stroke="currentColor" class="size-5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                        </svg>
                                        <span v-if="unreadCount > 0" 
                                            class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full h-4 w-4 flex items-center justify-center">
                                            {{ unreadCount }}
                                        </span>
                                    </div>
                                    <p class="font-medium flex-1">Notifications</p>
                                </div>
                            </div>
                       
                        </div>
                    </router-link>
              
            </div>
            <!-- user menue -->
            <div v-if="isMenueShown" class="flex flex-col w-38 bg-[#0D1117] justify-center rounded absolute -right-38 bottom-6">
                    <router-link to="/dashboard/ProfileSettings">
                        <button
                            class="flex items-center gap-1.5 bg-transparent border-0 p-2.5 text-white cursor-pointer rounded relative hover:bg-[#21262C] focus:bg-[#1A1F24] focus:outline-none group w-full">
                            <span
                                class="absolute top-1 -left-2.5 w-1.5 h-4/5 bg-orange-500 rounded opacity-0 group-focus:opacity-100"></span>
                                <v-icon name="bi-person" />
                            Public profile
                        </button>
                    </router-link>
                    <button @click="logout"
                        class="flex items-center gap-1.5 bg-transparent border-0 p-2.5 text-white cursor-pointer rounded relative hover:bg-[#21262C] focus:bg-[#1A1F24] focus:outline-none group w-full">
                        <span
                            class="absolute top-1 -left-2.5 w-1.5 h-4/5 bg-orange-500 rounded opacity-0 group-focus:opacity-100"></span>
                       <v-icon name="ri-logout-circle-r-line" />
                        Logout
                    </button>
            </div>

            <div @click="showMenue" class="cursor-pointer border-slate-200 hover:bg-gray-100 flex w-full items-center gap-[9px] font-medium p-3 border-t">
                <div class="self-stretch flex items-center gap-[9px] flex-1 shrink basis-[0%] my-auto">
                    <img :src="`https://ui-avatars.com/api/?name=${ user.name }&background=random&color=fff&size=128`"
                        class="aspect-[1.03] object-contain w-[31px] self-stretch shrink-0 my-auto rounded-[75px]" />
                    <div class="self-stretch flex-1 shrink basis-[0%] my-auto">
                        <div class="text-slate-500 text-[9px] leading-[15px]">
                            Welcome back 👋
                        </div>
                        <div class="text-[rgba(8,16,33,1)] text-[11px] leading-none">
                            {{ user.name }}
                        </div>
                    </div>
                </div>
                    <v-icon name="bi-chevron-right" />
            </div>
        </div>
    </div>
</template>

<script>
import auth from '../stores/auth';
import { useNotificationStore } from '../stores/notificationStore';

export default {
    name: 'Aside',
    props: {
        isOpen: {
            type: Boolean,
            required: true
        },
        user: {
            type : Object,
            default : () => []
        }
    },
    setup() {
        const notificationStore = useNotificationStore();
        return { notificationStore };
    },
    computed: {
        unreadCount() {
            return this.notificationStore.notifications?.filter(n => !n.is_read).length || 0;
        }
    },
    data() {
        return {
            open: true,
            isMenueShown : false
        }
    },
    emits: ['toggle-aside'],
    methods: {
        toggle_btns() {
            const up_btns = document.querySelectorAll('.up-btn');

            up_btns.forEach((btn) => {
                const subMenu = btn.nextElementSibling;
                const flesh = btn.querySelector('.flesh');

                btn.addEventListener('click', (e) => {
                    e.preventDefault();

                    // Toggle sub-menu visibility
                    if (subMenu && subMenu.classList.contains('hidden')) {
                        // Prepare for transition
                        subMenu.classList.remove('hidden');
                        subMenu.classList.add('opacity-0', 'max-h-0');

                        // Trigger reflow to ensure transition works
                        void subMenu.offsetWidth;

                        // Animate in
                        subMenu.classList.remove('opacity-0', 'max-h-0');
                        subMenu.classList.add('opacity-100', 'max-h-screen');
                        flesh.classList.add('rotate-87');
                    } else if (subMenu) {
                        // Animate out
                        subMenu.classList.add('opacity-0', 'max-h-0');
                        subMenu.classList.remove('opacity-100', 'max-h-screen');
                        flesh.classList.remove('rotate-87');

                        // Hide after transition
                        setTimeout(() => {
                            subMenu.classList.add('hidden');
                        }, 300);
                    }
                });
            });
        },
        toggle_aside() {
            const aside = document.querySelector('.aside');
            const flesh = document.querySelector('.aside_flesh');
            const fleshIcon = document.querySelector('.flesh');

            if (aside && flesh && fleshIcon) {
                this.open = !this.open;
                fleshIcon.classList.toggle('rotate-180');
            }
            this.$emit('toggle-aside', this.open);
        },
        
       showMenue(){
            if(this.isMenueShown){
              return  this.isMenueShown = false;
            }
            return this.isMenueShown = true;
       } ,
        async logout() {
            auth().logout();
        }
    },
    mounted() {
        this.toggle_btns();
    },
    created(){
        this.notificationStore.fetchNotifications();
    }
}
</script>