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

import { ChevronDown } from "lucide-vue-next";
import { Kanban } from "lucide-vue-next";
import { AlignLeft } from "lucide-vue-next";
import { ChevronRight } from "lucide-vue-next";
import { MoreVertical } from "lucide-vue-next";
import { Captions } from "lucide-vue-next";

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

        <div
            class="flex flex-row items-center justify-between gap-6 py-4 mb-4 border-t border-slate-200"
        >
            <div class="flex flex-col">
                <p class="text-4xl">tickets</p>
                <div>
                    <div class="flex items-center text-sm text-zinc-800">
                        dashboard > tickets > {{ ticketView }} view
                    </div>
                </div>
            </div>
            <div class="flex flex-row">
                <div class="flex">
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
                </div>
                <button
                    class="transition-all hover:bg-zinc-200 py-1 px-2 flex flex-nowrap items-center text-sm"
                >
                    <Captions size="24" strokeWidth="1" />
                </button>
            </div>
        </div>

        <div v-if="ticketView === 'kanban'">
            <div v-if="sortedTickets">
                <tabs>
                    <tab
                        v-for="board in sortedTickets.boards"
                        :name="board.boardname"
                        class="w-full"
                    >
                        <TicketKanbanBoard
                            :columns="board.columns"
                            :boardId="board.id"
                            :teamUsers="teamUsers"
                        />
                    </tab>
                    <div class="text-end -mt-1"><span @click="startCreatingBoard" class="h-full px-2 cursor-pointer font-semibold text-gray-400 hover:text-gray-600">+ Add Board</span></div>
                </tabs>
            </div>
        </div>

        <div v-if="ticketView === 'list'">
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

<!-- <script setup>
import { ref, onMounted } from "vue";
import AppLayout from "@/Layouts/AppLayout.vue";
import TicketsKanban from "@/Components/TicketsKanban.vue";
import { Tabs, Tab } from "vue3-tabs-component";
import { usePage } from "@inertiajs/vue3";
import { router, useForm } from "@inertiajs/vue3";
import PrimaryButton from "../Components/PrimaryButton.vue";
import DialogModal from "../Components/DialogModal.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";
import TextInput from "../Components/TextInput.vue";
import Sortable from "sortablejs/modular/sortable.complete.esm.js";

const {
    boards,
    columns,
    tickets,
    hasnoteams,
    activeBoard,
    ticketOrder,
    columnOrder,
} = defineProps({
    boards: Object,
    columns: Object,
    tickets: Object,
    hasnoteams: Boolean,
    activeBoard: Number,
    ticketOrder: Object,
    columnOrder: Object,
});

const page = usePage();

const currentlyActiveBoard = ref(activeBoard);
const allBoards = ref(boards);
const allTickets = ref(tickets);

const getFilteredTicket = (colId) => {
    return allTickets?.value?.filter((t) => t.ticketcolumns_id == colId);
};
const getTicketOrders = (colId) => {
    return ticketOrder?.filter((t) => t.ticketcolumns_id == colId);
};

const getColumnOrders = (boardId) => {
    //return columnOrder?.filter((t) => t.ticketcolumns_id == colId);
};

const filteredColumns = (boardId) => {
    let boardColumns = columns.filter(
        (obj) => obj["ticketboards_id"] === boardId
    );
    function mapOrder(a, order, key) {
        const map = order.reduce((r, v, i) => ((r[v] = i), r), {});
        return a.sort((a, b) => map[a[key]] - map[b[key]]);
    }
    // if (ticketOrder.value.length > 0) {
    //     const order = ticketOrder?.value[0]["ticketorder"].toString().split("|");
    //     const orderOfTickets = mapOrder(tickets.value, order, `id`);
    //     tickets.value = orderOfTickets;
    // }
    let colOrder = columnOrder?.map((col) => {
        if (col["ticketboards_id"] == boardId) {
            return col;
        }
    });

    console.log(colOrder)

    if (colOrder?.length > 0) {
        console.log(boardId, colOrder["0"]["columnorder"]);
        const order = colOrder["0"]["columnorder"].toString().split("|");
        boardColumns = mapOrder(boardColumns, order, `id`);
    }

    return boardColumns;
};

const allColumns = columns?.map((cols) => {
    let columnname = cols.columnname;
    let id = cols.id;
    return { columnname, id };
});

const newBoardForm = useForm({
    title: "",
    description: "",
    processing: false,
});

const newColumnForm = useForm({
    title: "",
    description: "",
    processing: false,
});

const updateActiveBoard = (boardId) => {
    router.visit(
        route("user.update", {
            user: page.props.auth.user.id,
            activetab: boardId,
        }),
        {
            method: "put",
            replace: false,
            preserveState: false,
            preserveScroll: true,
        }
    );
};

const creatingBoard = ref(false);
const creatingColumn = ref(false);

const startCreatingBoard = () => {
    creatingBoard.value = true;
};
const startCreatingColumn = () => {
    creatingColumn.value = true;
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
    updateActiveBoard(currentlyActiveBoard.value);
};
const createColumn = () => {
    newColumnForm.processing = true;
    newColumnForm.post(
        route("ticketcolumns.store", { boardId: currentlyActiveBoard.value }),
        {
            onSuccess: () => {
                columns.value = columns;
                newColumnForm.processing = false;
                newColumnForm.reset();
                closeModal();
            },
        }
    );
    updateActiveBoard(currentlyActiveBoard.value);
};

const saveColumnsOrder = (order, boardId) => {
    router.visit(
        route("ticketcolumnsorders.store", {
            order: order,
            board: boardId,
        }),
        {
            method: "post",
            preserveScroll: true,
            onSuccess: () =>
                router.visit(route("tickets.index"), {
                    preserveScroll: true,
                }),
        }
    );
};

const closeModal = () => {
    creatingBoard.value = false;
    creatingColumn.value = false;
};

function updateTabs(boardId) {
    currentlyActiveBoard.value = boardId;
    updateActiveBoard(boardId);
}

onMounted(() => {
    let columnElements = document.getElementsByClassName("sortable-columns");
    for (let i = 0; i < columnElements.length; i++) {
        Sortable.create(columnElements[i], {
            group: "columns",
            animation: 250,
            ghostClass: "col-ghost-class",
            handle: ".column-handle",
            onEnd: function (/**Event*/ e) {
                let board = e.to;
                let boardId = activeBoard;
                let items = board.getElementsByClassName("galleon-column");
                let order = [];
                for (let i = 0; i < items.length; i++) {
                    order.push(items[i].getAttribute("data-id"));
                }
                console.log("order:", order);
                saveColumnsOrder(order, boardId);
            },
        });
    }
});
</script>

<template>
    <AppLayout title="Dashboard">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Tickets
            </h2>
        </template>

        <button @click="startCreatingBoard">Create board</button>

        <div v-if="boards || !hasnoteams" class="w-full h-full bg-sky-100">
            aaa
            <div class="tab">
                <button
                    v-for="board in allBoards"
                    :class="board.id == currentlyActiveBoard ? 'active' : ''"
                    class="tablinks"
                    @click="updateTabs(board.id)"
                >
                    {{ board.boardname }}
                </button>
            </div>

            <div
                v-for="board in boards"
                :data-id="board.id"
                :class="
                    board.id == currentlyActiveBoard
                        ? 'block '
                        : 'hidden ' + 'tabcontent h-full'
                "
            >
                <p v-if="board.boarddescription">
                    {{ board.boarddescription }}
                </p>

                <div class="flex flex-row flex-nowrap">
                    <div class="sortable-columns flex flex-row flex-nowrap">
                        <div
                            v-for="column in filteredColumns(board.id)"
                            :data-id="column.id"
                            class="galleon-column m-2 min-h-screen w-[300px] bg-slate-200"
                        >
                            <div
                                class="column-handle bg-black w-full text-white"
                            >
                                <p>{{ column.columnname }}</p>
                                <p>{{ column.columndescription }}</p>
                            </div>

                            <div class="">
                                <div class="bg-white p-2 m-2">
                                    <TicketsKanban
                                        :thisColumn="{
                                            id: column.id,
                                            columnname: column.columnname,
                                        }"
                                        :allColumns="filteredColumns(board.id)"
                                        :tickets="getFilteredTicket(column.id)"
                                        :ticketOrder="
                                            getTicketOrders(column.id)
                                        "
                                    />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="">
                        <div class="m-2 min-h-screen w-[300px] bg-slate-200">
                            <button @click="startCreatingColumn">
                                Add column
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div v-if="hasnoteams" class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    you need to make a team first!
                </div>
            </div>
        </div>
    </AppLayout>

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

    <DialogModal :show="creatingColumn" @close="closeModal">
        <template #title> Create New Column </template>

        <template #content>
            Create a new column to contain your tickets

            <div class="mt-4">
                <TextInput
                    v-model="newColumnForm.title"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="My new column"
                />

                <textarea
                    v-model="newColumnForm.description"
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
                :class="{ 'opacity-25': newColumnForm.processing }"
                :disabled="newColumnForm.processing"
                @click="createColumn"
            >
                Create Board
            </PrimaryButton>
        </template>
    </DialogModal>
</template> -->
