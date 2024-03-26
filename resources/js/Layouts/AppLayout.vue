<script setup>
import { ref } from "vue";
import { Head, Link, router } from "@inertiajs/vue3";
import ApplicationMark from "@/Components/ApplicationMark.vue";
import Banner from "@/Components/Banner.vue";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";
import NavLink from "@/Components/NavLink.vue";
import ResponsiveNavLink from "@/Components/ResponsiveNavLink.vue";
import Tooltip from "primevue/tooltip";

import { StickyNote } from "lucide-vue-next";
import { LayoutDashboard } from "lucide-vue-next";
import { Laptop } from "lucide-vue-next";
import { Building } from "lucide-vue-next";
import { Users } from "lucide-vue-next";
import { Settings } from "lucide-vue-next";
import { LifeBuoy } from "lucide-vue-next";
import { Gem } from "lucide-vue-next";
import { GitPullRequestCreateArrow } from "lucide-vue-next";
import { CalendarCheck } from "lucide-vue-next";
import { Ticket } from "lucide-vue-next";
import { GalleryThumbnails } from "lucide-vue-next";
import { Store } from "lucide-vue-next";
import { Settings2 } from "lucide-vue-next";
import { BadgeCheck } from "lucide-vue-next";
import { ClipboardList } from "lucide-vue-next";
import { AlarmClockMinus } from "lucide-vue-next";
import { ChevronDown } from "lucide-vue-next";
import { Bell } from "lucide-vue-next";
import { ShipWheel } from "lucide-vue-next";
import { Sailboat } from "lucide-vue-next";
import { Ghost } from "lucide-vue-next";
import { Gauge } from "lucide-vue-next";
import { LibraryBig } from "lucide-vue-next";

defineProps({
    title: String,
    justJoinedTeams: Object,
});

const showingNavigationDropdown = ref(false);

const switchToTeam = (team) => {
    router.put(
        route("current-team.update"),
        {
            team_id: team.id,
        },
        {
            preserveState: false,
        }
    );
};

const logout = () => {
    router.post(route("logout"));
};
</script>

<template>
    <div class="flex flex-row flex-nowrap">
        <div
            class="fixed backdrop-blur sidebar-menu min-w-[55px] w-[55px] transition-all flex flex-col items-center pt-2 bg-[#F1ECE6]x shadow-lg h-screen"
        >
            <img src="../../images/logo.png" class="pl-2 pr-1 pt-3 pb-4" />
            <!-- <p class="logo-font text-[35px] pb-2 text-[#545454]">
                g<span class="logo-font text-[40px] pb-4 hidden">alleon</span>
            </p> -->
            <!-- <Sailboat color="#27272A" strokeWidth="1.5" size="22" size="40" class="mb-3"/> -->

            <NavLink
                v-tooltip="'Dashboard'"
                class="py-4"
                :href="route('dashboard')"
                :active="route().current('dashboard')"
            >
                <Gauge color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'Tickets'"
                class="py-4"
                :href="route('tickets.index')"
                :active="route().current('tickets.index')"
                ><Ticket color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'Assets'"
                :href="route('assets.index')"
                :active="route().current('assets.index')"
                class="py-4"
                ><ClipboardList color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'Companies'"
                :href="route('companies.index')"
                :active="route().current('companies.index')"
                class="py-4"
                ><Store color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'People'"
                :href="route('people.index')"
                :active="route().current('people.index')"
                class="py-4"
                ><Users color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'Alerts'"
                :href="route('alerts.index')"
                :active="route().current('alerts.index')"
                class="py-4"
                ><AlarmClockMinus color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'Library'"
                :href="route('library.index')"
                :active="route().current('library.index')"
                class="py-4"
                ><LibraryBig color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>

            <div class="h-[1px] w-3/4 my-2 bg-[#cfcfcf]"></div>

            <NavLink
                v-tooltip="'Settings'"
                :href="route('settings.index')"
                :active="route().current('settings.index')"
                class="py-4"
                ><Settings2 color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'Membership'"
                :href="route('membership.index')"
                :active="route().current('membership.index')"
                class="py-4"
                ><BadgeCheck color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>

            <NavLink
                v-tooltip="'Support'"
                :href="route('support.index')"
                :active="route().current('support.index')"
                class="py-4"
                ><LifeBuoy color="#27272A" strokeWidth="1.5" size="22"
            /></NavLink>
            <NavLink
                v-tooltip="'Feature Request'"
                :href="route('roadmap.index')"
                :active="route().current('roadmap.index')"
                class="py-4"
                ><GitPullRequestCreateArrow
                    color="#27272A"
                    strokeWidth="1.5"
                    size="22"
            /></NavLink>

            <div
                v-tooltip="'Boo!'"
                class="group mt-auto w-full h-12 flex items-center justify-center self-end"
            >
                <Ghost
                    class="-mb-20 group-hover:mb-0 transition-all duration-300"
                    color="#27272A"
                    strokeWidth="1.5"
                    size="28"
                />
            </div>
        </div>

        <div class="grow pl-16">
            <Head :title="title" />

            <Banner />

            <div class="min-h-screen">
                <nav class="right-1 top-0 py-4 fixed z-[2]">
                    <!-- Primary Navigation Menu -->
                    <div class="mx-auto px-4 pt-1">
                        <div class="flex justify-between h-16">
                            <div class="flex">
                                <!-- Logo -->
                                <!-- <div class="shrink-0 flex items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationMark class="block h-9 w-auto" />
                                </Link>
                            </div> -->
                                <!-- <span class="text-slate-800 my-auto"
                                    ><span class="logo-font text-[26px]"
                                        >galleon</span
                                    >
                                    <span class="text-[22px]">•</span
                                    ><span class="text-[22px]">desk</span></span
                                > -->

                                <!-- Navigation Links -->
                                <!-- <div
                                class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex"
                            >
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Dashboard
                                </NavLink>
                            </div> -->
                            </div>

                            <div class="hidden sm:flex sm:items-center sm:ms-6">
                                <div class="ms-3 relative">
                                    <!-- Teams Dropdown -->
                                    <Dropdown
                                        v-if="
                                            $page.props.jetstream
                                                .hasTeamFeatures
                                        "
                                        align="right"
                                        width="60"
                                    >
                                        <template #trigger>
                                            <span
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    v-if="
                                                        $page.props.auth.user
                                                            .current_team
                                                    "
                                                    type="button"
                                                    class="px-4 border shadow-sm hover:shadow-md transition-all flex items-center gap-1 py-2 text-black h-[34px]"
                                                >
                                                    {{
                                                        $page.props.auth.user
                                                            .current_team.name
                                                    }}

                                                    <ChevronDown
                                                        color="#27272A"
                                                        size="15"
                                                    />
                                                </button>
                                                <button
                                                    v-else
                                                    type="button"
                                                    class="px-4 border shadow-sm hover:shadow-md transition-all flex items-center gap-1 py-2 text-black h-[34px]"
                                                >
                                                    Create a team

                                                    <ChevronDown
                                                        color="#27272A"
                                                        size="18"
                                                    />
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <div class="w-60">
                                                <!-- Team Management -->
                                                <div
                                                    class="block px-4 py-2 text-xs text-gray-400"
                                                >
                                                    Manage Team
                                                </div>

                                                <!-- Team Settings -->
                                                <DropdownLink
                                                    v-if="
                                                        $page.props.auth.user
                                                            .current_team
                                                    "
                                                    :href="
                                                        route(
                                                            'teams.show',
                                                            $page.props.auth
                                                                .user
                                                                .current_team
                                                        )
                                                    "
                                                >
                                                    Team Settings
                                                </DropdownLink>

                                                <!-- <DropdownLink v-if="!$page.props.jetstream.canCreateTeams" :href="route('teams.create')"> -->
                                                <DropdownLink
                                                    v-if="
                                                        $page.props.auth.user
                                                            .all_teams.length <
                                                        1
                                                    "
                                                    :href="
                                                        route('teams.create')
                                                    "
                                                >
                                                    Create New Team
                                                </DropdownLink>

                                                <!-- Team Switcher -->

                                                <template
                                                    v-if="
                                                        $page.props.auth.user
                                                            .all_teams.length >
                                                        1
                                                    "
                                                >
                                                    <div
                                                        class="border-t border-gray-200"
                                                    />

                                                    <div
                                                        class="block px-4 py-2 text-xs text-gray-400"
                                                    >
                                                        Switch Teams
                                                    </div>

                                                    <template
                                                        v-for="team in $page
                                                            .props.auth.user
                                                            .all_teams"
                                                        :key="team.id"
                                                    >
                                                        <form
                                                            @submit.prevent="
                                                                switchToTeam(
                                                                    team
                                                                )
                                                            "
                                                        >
                                                            <DropdownLink
                                                                as="button"
                                                            >
                                                                <div
                                                                    class="flex items-center"
                                                                >
                                                                    <svg
                                                                        v-if="
                                                                            team.id ==
                                                                            $page
                                                                                .props
                                                                                .auth
                                                                                .user
                                                                                .current_team_id
                                                                        "
                                                                        class="me-2 h-5 w-5 text-green-400"
                                                                        xmlns="http://www.w3.org/2000/svg"
                                                                        fill="none"
                                                                        viewBox="0 0 24 24"
                                                                        stroke-width="1.5"
                                                                        stroke="currentColor"
                                                                    >
                                                                        <path
                                                                            stroke-linecap="round"
                                                                            stroke-linejoin="round"
                                                                            d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                                                                        />
                                                                    </svg>

                                                                    <div>
                                                                        {{
                                                                            team.name
                                                                        }}
                                                                    </div>
                                                                </div>
                                                            </DropdownLink>
                                                        </form>
                                                    </template>
                                                </template>
                                            </div>
                                        </template>
                                    </Dropdown>
                                </div>

                                <!-- Settings Dropdown -->
                                <div class="ms-3 relative">
                                    <Dropdown align="right" width="48">
                                        <template #trigger>
                                            <button
                                                v-if="
                                                    $page.props.jetstream
                                                        .managesProfilePhotos
                                                "
                                                class="flex text-sm rounded-full focus:outline-none transition hover:shadow-lg focus:shadow-lg"
                                            >
                                                <img
                                                    class="h-8 w-8 rounded-full object-cover"
                                                    :src="
                                                        $page.props.auth.user
                                                            .profile_photo_url
                                                    "
                                                    :alt="
                                                        $page.props.auth.user
                                                            .name
                                                    "
                                                />
                                            </button>

                                            <span
                                                v-else
                                                class="inline-flex rounded-md"
                                            >
                                                <button
                                                    type="button"
                                                    class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150"
                                                >
                                                    {{
                                                        $page.props.auth.user
                                                            .name
                                                    }}

                                                    <svg
                                                        class="ms-2 -me-0.5 h-4 w-4"
                                                        xmlns="http://www.w3.org/2000/svg"
                                                        fill="none"
                                                        viewBox="0 0 24 24"
                                                        stroke-width="1.5"
                                                        stroke="currentColor"
                                                    >
                                                        <path
                                                            stroke-linecap="round"
                                                            stroke-linejoin="round"
                                                            d="M19.5 8.25l-7.5 7.5-7.5-7.5"
                                                        />
                                                    </svg>
                                                </button>
                                            </span>
                                        </template>

                                        <template #content>
                                            <!-- Account Management -->
                                            <div
                                                class="block px-4 py-2 text-xs text-gray-400"
                                            >
                                                Manage Account
                                            </div>

                                            <DropdownLink
                                                :href="route('profile.show')"
                                            >
                                                Profile
                                            </DropdownLink>

                                            <DropdownLink
                                                v-if="
                                                    $page.props.jetstream
                                                        .hasApiFeatures
                                                "
                                                :href="
                                                    route('api-tokens.index')
                                                "
                                            >
                                                API Tokens
                                            </DropdownLink>

                                            <div
                                                class="border-t border-gray-200"
                                            />

                                            <!-- Authentication -->
                                            <form @submit.prevent="logout">
                                                <DropdownLink as="button">
                                                    Log Out
                                                </DropdownLink>
                                            </form>
                                        </template>
                                    </Dropdown>
                                </div>

                                <!-- Notification -->
                                <!-- <button
                                    type="button"
                                    class="ms-3 inline-flex items-center gap-2 border border-transparent font-bold focus:outline-none transition ease-in-out duration-150 bg-zinc-800 hover:shadow-lg rounded-full text-white py-2 px-4 text-sm"
                                >
                                    <Bell color="#fff" size="15" />
                                </button> -->
                            </div>

                            <!-- Hamburger -->
                            <div class="-me-2 flex items-center sm:hidden">
                                <button
                                    class="inline-flex items-center justify-center p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none focus:bg-gray-100 focus:text-gray-500 transition duration-150 ease-in-out"
                                    @click="
                                        showingNavigationDropdown =
                                            !showingNavigationDropdown
                                    "
                                >
                                    <svg
                                        class="h-6 w-6"
                                        stroke="currentColor"
                                        fill="none"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            :class="{
                                                hidden: showingNavigationDropdown,
                                                'inline-flex':
                                                    !showingNavigationDropdown,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M4 6h16M4 12h16M4 18h16"
                                        />
                                        <path
                                            :class="{
                                                hidden: !showingNavigationDropdown,
                                                'inline-flex':
                                                    showingNavigationDropdown,
                                            }"
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M6 18L18 6M6 6l12 12"
                                        />
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    <!-- Responsive Navigation Menu -->
                    <div
                        :class="{
                            block: showingNavigationDropdown,
                            hidden: !showingNavigationDropdown,
                        }"
                        class="sm:hidden"
                    >
                        <div class="pt-2 pb-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                            >
                                Dashboard
                            </ResponsiveNavLink>
                        </div>

                        <!-- Responsive Settings Options -->
                        <div class="pt-4 pb-1 border-t border-gray-200">
                            <div class="flex items-center px-4">
                                <div
                                    v-if="
                                        $page.props.jetstream
                                            .managesProfilePhotos
                                    "
                                    class="shrink-0 me-3"
                                >
                                    <img
                                        class="h-10 w-10 rounded-full object-cover"
                                        :src="
                                            $page.props.auth.user
                                                .profile_photo_url
                                        "
                                        :alt="$page.props.auth.user.name"
                                    />
                                </div>

                                <div>
                                    <div
                                        class="font-medium text-base text-gray-800"
                                    >
                                        {{ $page.props.auth.user.name }}
                                    </div>
                                    <div
                                        class="font-medium text-sm text-gray-500"
                                    >
                                        {{ $page.props.auth.user.email }}
                                    </div>
                                </div>
                            </div>

                            <div class="mt-3 space-y-1">
                                <ResponsiveNavLink
                                    :href="route('profile.show')"
                                    :active="route().current('profile.show')"
                                >
                                    Profile
                                </ResponsiveNavLink>

                                <ResponsiveNavLink
                                    v-if="$page.props.jetstream.hasApiFeatures"
                                    :href="route('api-tokens.index')"
                                    :active="
                                        route().current('api-tokens.index')
                                    "
                                >
                                    API Tokens
                                </ResponsiveNavLink>

                                <!-- Authentication -->
                                <form method="POST" @submit.prevent="logout">
                                    <ResponsiveNavLink as="button">
                                        Log Out
                                    </ResponsiveNavLink>
                                </form>

                                <!-- Team Management -->
                                <template
                                    v-if="$page.props.jetstream.hasTeamFeatures"
                                >
                                    <div class="border-t border-gray-200" />

                                    <div
                                        class="block px-4 py-2 text-xs text-gray-400"
                                    >
                                        Manage Team
                                    </div>

                                    <!-- Team Settings -->
                                    <!-- <ResponsiveNavLink :href="route('teams.show', $page.props.auth.user.current_team)" :active="route().current('teams.show')">
                                    Team Settings
                                </ResponsiveNavLink> -->

                                    <ResponsiveNavLink
                                        v-if="
                                            $page.props.jetstream.canCreateTeams
                                        "
                                        :href="route('teams.create')"
                                        :active="
                                            route().current('teams.create')
                                        "
                                    >
                                        Create New Team
                                    </ResponsiveNavLink>

                                    <!-- Team Switcher -->
                                    <!-- <template v-if="$page.props.auth.user.all_teams.length > 1">
                                    <div class="border-t border-gray-200" />

                                    <div class="block px-4 py-2 text-xs text-gray-400">
                                        Switch Teams
                                    </div>

                                    <template v-for="team in $page.props.auth.user.all_teams" :key="team.id">
                                        <form @submit.prevent="switchToTeam(team)">
                                            <ResponsiveNavLink as="button">
                                                <div class="flex items-center">
                                                    <svg v-if="team.id == $page.props.auth.user.current_team_id" class="me-2 h-5 w-5 text-green-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                    </svg>
                                                    <div>{{ team.name }}</div>
                                                </div>
                                            </ResponsiveNavLink>
                                        </form>
                                    </template>
                                </template> -->
                                </template>
                            </div>
                        </div>
                    </div>
                </nav>

                <!-- Page Heading -->
                <!-- <header v-if="$slots.header" class="">
                    <div class="mx-auto py-2 pb-4 mb-4 shadow px-4">
                        <slot name="header" />
                    </div>
                </header> -->

                <!-- Page Content -->
                <main class="px-8 h-full">
                    <slot />
                </main>
            </div>
        </div>
    </div>

    <div
        class="fixed bottom-0 right-0 text-sm bg-zinc-700 z-10 flex flex-row gap-4 px-6 rounded-tl-md"
    >
        <a href="/" class="text-zinc-300 hover:text-white">Galleon</a>
        <a href="/" class="text-zinc-300 hover:text-white">About</a>
        <a href="/" class="text-zinc-300 hover:text-white">Terms</a>
        <a href="/" class="text-zinc-300 hover:text-white">Privacy</a>
        <a href="/" class="text-zinc-300 hover:text-white">Contact</a>
        <a href="/" class="text-zinc-300 hover:text-white">Community</a>
    </div>
</template>
