<script setup>
import { ref } from "vue";
import { Sortable } from "sortablejs-vue3";
import TicketKanbanTickets from "./TicketKanbanTickets.vue";
import { router, useForm } from "@inertiajs/vue3";
import TextInput from "./TextInput.vue";
import PrimaryButton from "../Components/PrimaryButton.vue";
import DialogModal from "../Components/DialogModal.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";

import { Move } from "lucide-vue-next";
import { Pencil } from "lucide-vue-next";
import { Plus } from "lucide-vue-next";

const { columns, boardId, teamUsers } = defineProps({
    columns: Object,
    boardId: Number,
    teamUsers: Object,
});

const newColumnForm = useForm({
    title: "",
    description: "",
    colour: "stone",
    processing: false,
});


const creatingColumn = ref(false);

const columnColours = [
    { name: "stone", colour: "stone-200" },
    { name: "gray", colour: "gray-200" },
    { name: "amber", colour: "amber-200" },
    { name: "yellow", colour: "yellow-200" },
    { name: "lime", colour: "lime-200" },
    { name: "emerald", colour: "emerald-200" },
    { name: "teal", colour: "teal-200" },
    { name: "cyan", colour: "cyan-200" },
    { name: "sky", colour: "sky-200" },
    { name: "blue", colour: "blue-200" },
    { name: "indigo", colour: "indigo-200" },
    { name: "violet", colour: "violet-200" },
    { name: "purple", colour: "purple-200" },
    { name: "fuchsia", colour: "fuchsia-200" },
    { name: "pink", colour: "pink-200" },
    { name: "rose", colour: "rose-200" },
    { name: "red", colour: "red-200" },
];

const startCreatingColumn = () => {
    creatingColumn.value = true;
};

const createColumn = () => {
    newColumnForm.processing = true;
    newColumnForm.post(route("ticketcolumns.store", { boardId: boardId }), {
        onSuccess: () => {
            columns.value = columns;
            newColumnForm.processing = false;
            newColumnForm.reset();
            closeModal();
        },
    });
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
    creatingColumn.value = false;
};

const options = {
    animation: 200,
    ghostClass: "col-ghost",
    chosenClass: "col-chosen",
    dragClass: "col-drag",
    scroll: true,
    forceFallback: true,
    bubbleScroll: true,
    handle: ".col-handle",
    direction: "horizontal",
    easing: "cubic-bezier(.25,.75,.5,1.20)",
};

const onEnd = (e) => {
    let board = e.to;
    let items = board.getElementsByClassName("galleon-column");
    let order = [];
    for (let i = 0; i < items.length; i++) {
        order.push(items[i].getAttribute("data-id"));
    }
    saveColumnsOrder(order, boardId);
};

</script>

<style scoped>
.col-ghost {
}

.col-chosen {
    opacity: 0.5;
    outline: 1px dotted black;
}

.col-drag {
    opacity: 0.8;
}
</style>

<template>
    <div class="w-full flex flex-row">
        <Sortable
            :list="columns"
            item-key="id"
            tag="div"
            :options="options"
            class="flex flex-row flex-nowrap gap-4"
            @end="onEnd"
        >
            <template #item="{ element, index }" :key="element.id">
                <div
                    class="draggable my-1 inline-block min-h-[200px] w-[340px] border-solid"
                    :key="element.id"
                    :data-id="element.id"
                >
                    <div
                        :data-id="element.id"
                        class="galleon-column rounded-t-lg col-handle cursor-grab p-3 px-4 font-semibold border-b-4 w-full flex items-center justify-between gap-3"
                        :class="'bg-' + element.colour + '-200' + ' ' + 'border-' + element.colour + '-300' + ' ' + 'hover:border-' + element.colour + '-400' + ' ' + 'hover:bg-' + element.colour + '-300'"
                    >
                        <div class="flex items-center gap-2">
                            <!-- <Move class="w-4 h-4" color="#1E293B" /> -->
                            {{ element.columnname }}
                        </div>
                        <div
                            class="flex items-center justify-center hover:bg-stone-300 p-1 hover:cursor-pointer"
                        >
                            <!-- <Pencil class="w-4 h-4 self-center" color="#1E293B" /> -->
                        </div>
                    </div>

                    <TicketKanbanTickets
                        :tickets="element.tickets"
                        :column="element"
                        :allColumns="columns"
                        :ticketOrder="element.ticketOrder"
                        :teamUsers="teamUsers"
                    />
                </div>
            </template>
        </Sortable>
        <div
            @click="startCreatingColumn"
            class="font-semibold rounded-t-lg ml-3 transition-all transition-300 cursor-pointer p-3 bg-zinc-200 hover:bg-zinc-300 hover:border-zinc-500 border-b-4 border-zinc-300 h-[43px] aspect-square my-1 flex items-center justify-center"
        > <span class="text-xl">+</span>
            <!-- <Plus class="w-4 h-4 my-auto mx-auto" color="#1E293B" /> -->
        </div>
    </div>

    <DialogModal :show="creatingColumn" @close="closeModal">
        <template #title> Create New Column </template>

        <template #content>
            Create a new column to contain your tickets

            <div class="mt-4">
                <input
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

            <!-- <select v-model="newColumnForm.colour">
                        <option
                            v-for="colour in columnColours"
                            :key="colour.name"
                            :value="colour.colour"
                            class="column-colour-dropdown"
                        >
                            <span class="text-red-500">A</span>{{ colour.name }}
                        </option>
                    </select> -->

            <div class="flex gap-3 w-3/4 flex-wrap">
                <input
                    v-for="colour in columnColours"
                    class="column-colour-radio w-8 h-8 rounded-none m-0 focus:ring-0"
                    :class="
                        'bg-' +
                        colour.colour +
                        ' focus:!border-black focus:bg-' +
                        colour.colour +
                        '  checked:bg-' +
                        colour.colour +
                        ' !accent-' +
                        colour.colour
                    "
                    :key="colour.name"
                    type="radio"
                    :id="colour.name"
                    name="columnColours"
                    :value="colour.name"
                    v-model="newColumnForm.colour"
                />
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
</template>
