<script setup>
import { ref, onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
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

const { sortedTickets, uncategorisedTickets, teamUsers } = defineProps({
    sortedTickets: Object,
    uncategorisedTickets: Object,
    teamUsers: Object,
});
const page = usePage();

const newBoardForm = useForm({
    title: "",
    description: "",
    processing: false,
});

const { cookies } = useCookies();
const ticketView = ref(cookies.get("ticketView") || "kanban");
const creatingBoard = ref(false);

const saveTicketView = (view) => {
    ticketView.value = view;
    cookies.set("ticketView", view);
};

const startCreatingBoard = () => {
    creatingBoard.value = true;
};

const createBoard = () => {
    newBoardForm.processing = true;
    newBoardForm.post(route("ticketboards.store"), {
        onSuccess: () => {
            allBoards.value = boards;
            newBoardForm.processing = false;
            newBoardForm.reset();
            closeModal();
        },
    });
    //updateActiveBoard(currentlyActiveBoard.value);
};

const closeModal = () => {
    creatingBoard.value = false;
};
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
                    Tickets
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
                <!-- <div class="flex">
                    <button
                        :class="{ 'bg-zinc-300': ticketView === 'kanban' }"
                        class="transition-all hover:bg-zinc-200 px-2 py-1 flex flex-nowrap items-center text-sm"
                        @click="saveTicketView('kanban')"
                    >
                        <Kanban strokeWidth="1" size="20" />
                    </button>
                    <button
                        :class="{ 'bg-zinc-300': ticketView === 'list' }"
                        class="transition-all hover:bg-zinc-200 px-2 py-1 flex flex-nowrap items-center text-sm"
                        @click="saveTicketView('list')"
                    >
                        <AlignLeft strokeWidth="1" size="20" />
                    </button>
                </div> -->

                <button
                    v-tooltip.bottom="'List view'"
                    :class="{ hidden: ticketView === 'list' }"
                    class=""
                    @click="saveTicketView('list')"
                >
                    <!-- List -->
                    <AlignLeft color="#27272A" strokeWidth="2" size="18" />
                </button>
                <button
                    v-tooltip.bottom="'Kanban view'"
                    :class="{ hidden: ticketView === 'kanban' }"
                    class=" "
                    @click="saveTicketView('kanban')"
                >
                    <!-- Kanban -->
                    <Kanban color="#27272A" strokeWidth="2" size="18" />
                </button>

                <!-- <button
                v-tooltip.bottom="'Create'"
                    class=""
                >
                    <Plus color="#27272A" strokeWidth="2" size="18" />
                </button> -->

                <Dropdown
                    v-tooltip.bottom="'Create'"
                    align="left"
                    width="60"
                    class=""
                >
                    <template #trigger>
                        <button class="py-2">
                            <Plus color="#27272A" strokeWidth="2" size="18" />
                        </button>
                    </template>
                    <template #content>
                        <div class="w-60">
                            <DropdownLink
                                href="/">
                                Ticket
                            </DropdownLink>
                            <DropdownLink
                                href="/">
                                Column
                            </DropdownLink>
                            <DropdownLink
                                href="/">
                                Board
                            </DropdownLink>
                        </div>
                    </template>
                </Dropdown>

                <button v-tooltip.bottom="'Preferences'" class="">
                    <Settings2 color="#27272A" strokeWidth="2" size="18" />
                </button>
            </div>
        </div>

        <div v-if="ticketView === 'kanban'" class="pt-32">
            <div v-if="sortedTickets">
                <tabs cache-lifetime="1000">
                    <tab
                        v-for="board in sortedTickets.boards"
                        :name="board.boardname"
                        class=""
                    >
                        <TicketKanbanBoard
                            :columns="board.columns"
                            :boardId="board.id"
                            :teamUsers="teamUsers"
                        />
                    </tab>
                    <tab class="new-board-tab" name="+">
                        This is the content of the first tab
                    </tab>

                    <!-- <div class="text-end -mt-1">
                        <span
                            @click="startCreatingBoard"
                            class="h-full px-2 cursor-pointer font-semibold text-gray-400 hover:text-gray-600"
                            >+ Add Board</span
                        >
                    </div> -->
                </tabs>
            </div>
        </div>

        <div v-if="ticketView === 'list'" class="pt-28 relatice z-[-1]">
            <TicketDataTable
                :sortedTickets="sortedTickets"
                :uncategorisedTickets="uncategorisedTickets"
            />
        </div>

        <!-- <div v-else>
            <button @click="startCreatingBoard">Create your first board</button>
        </div> -->

        <div v-if="page.props.auth.user.current_team === null">
            <p>Create or join a team to start using Galleon•desk</p>
        </div>

        <DialogModal :show="creatingBoard" @close="closeModal">
            <template #title> Create New Board </template>

            <template #content>
                Create a new board to contain your colums and tickets

                <div class="mt-4">
                    <TextInput
                        v-model="newBoardForm.title"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="My new board"
                    />

                    <textarea
                        v-model="newBoardForm.description"
                        type="text"
                        class="mt-1 block w-3/4"
                        placeholder="Description"
                    >
                    </textarea>
                </div>
            </template>

            <template #footer>
                <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

                <PrimaryButton
                    class="ms-3"
                    :class="{ 'opacity-25': newBoardForm.processing }"
                    :disabled="newBoardForm.processing"
                    @click="createBoard"
                >
                    Create Board
                </PrimaryButton>
            </template>
        </DialogModal>
    </AppLayout>
</template>