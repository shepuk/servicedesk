<script setup>
import AppLayout from "@/Layouts/AppLayout.vue";
import Welcome from "@/Components/Welcome.vue";
import { ref, onMounted } from "vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { usePage } from "@inertiajs/vue3";
import { router, useForm } from "@inertiajs/vue3";
import PrimaryButton from "../Components/PrimaryButton.vue";
import DialogModal from "../Components/DialogModal.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";
import TextInput from "../Components/TextInput.vue";
import TicketKanbanBoard from "@/Components/TicketKanbanBoard.vue";
import TicketDataTable from "@/Components/TicketDataTable.vue";
import { useCookies } from "vue3-cookies";
import Dropdown from "@/Components/Dropdown.vue";
import DropdownLink from "@/Components/DropdownLink.vue";

import { ChevronDown } from "lucide-vue-next";
import { Kanban } from "lucide-vue-next";
import { AlignLeft } from "lucide-vue-next";
import { ChevronRight } from "lucide-vue-next";
import { MoreVertical } from "lucide-vue-next";
import { Captions } from "lucide-vue-next";
import { Plus } from "lucide-vue-next";
import { Settings2 } from "lucide-vue-next";
import { Eye } from "lucide-vue-next";
</script>

<template>
    <AppLayout title="Tickets">
        <!-- <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tickets
            </h2>
        </template> -->

        <div class="flex flex-row items-center gap-4 -ml-[23px] pl-8 py-8 mb-4 w-full fixed backdrop-blur">
            <div class="flex flex-col">
                <h1 class="text-[30px] font-bold text-zinc-800 leading-none">
                    Dashboard
                </h1>
                <div>
                    <!-- <div class="flex items-center text-sm text-zinc-800">
                        dashboard > tickets > {{ ticketView }} view
                    </div> -->
                </div>
            </div>
            <div
                class="flex flex-row gap-2 px-4 border shadow-sm hover:shadow-md transition-all [&>button]:p-2 [&>button]:h-full"
            >

            <button v-tooltip.bottom="'Views'" class="">
                    <Eye color="#27272A" strokeWidth="2" size="18" />
                </button>
                <button v-tooltip.bottom="'Preferences'" class="">
                    <Settings2 color="#27272A" strokeWidth="2" size="18" />
                </button>
            </div>
        </div>



     <h1 class="pt-28">Content!</h1>
    </AppLayout>
</template>

<!-- <template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <Welcome />
                </div>
            </div>
        </div>
    </AppLayout>
</template> -->
