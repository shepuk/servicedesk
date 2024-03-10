<script setup>
import { ref, onMounted, reactive, nextTick } from "vue";
import Modal from "./Modal.vue";
import DialogModal from "./DialogModal.vue";
import InputError from "./InputError.vue";
import PrimaryButton from "./PrimaryButton.vue";
import SecondaryButton from "./SecondaryButton.vue";
import TextInput from "./TextInput.vue";
import { router, useForm } from "@inertiajs/vue3";
import Sortable from "sortablejs/modular/sortable.complete.esm.js";

const props = defineProps({
    tickets: {
        type: Object,
    },
    thisColumn: {
        type: Object,
    },
    allColumns: {
        type: Object,
    },
    ticketOrder: {
        type: Object,
    },
});

// the team's current stuff
const boards = ref(props.boards);
const columns = ref(props.columns);
const tickets = ref(props.tickets);
const thisColumn = ref(props.thisColumn);
const allColumns = ref(props.allColumns);
const ticketOrder = ref(props.ticketOrder);

const newTicketForm = useForm({
    title: "",
    description: "",
    column: thisColumn.value.id,
    processing: false,
});

const titleInput = ref(null);
const descriptionInput = ref(null);
const columnInput = ref(null);
const creatingColumn = ref(false);
const creatingTicket = ref(false);

// put the tickets in the correct order
function mapOrder(a, order, key) {
    const map = order.reduce((r, v, i) => ((r[v] = i), r), {});
    return a.sort((a, b) => map[a[key]] - map[b[key]]);
}
if (ticketOrder.value.length > 0) {
    const order = ticketOrder?.value[0]["ticketorder"].toString().split("|");
    const orderOfTickets = mapOrder(tickets.value, order, `id`);
    tickets.value = orderOfTickets;
}

const startCreatingTicket = () => {
    creatingTicket.value = true;
};

const createTicket = () => {
    newTicketForm.processing = true;
    newTicketForm.post(route("tickets.store"), {
        onSuccess: () => {
            tickets.value = props.tickets;
            newTicketForm.processing = false;
            newTicketForm.reset();
            closeModal();
            router.visit(route("tickets.index"), {
                preserveScroll: true,
            });
        },
    });
};

const closeModal = () => {
    creatingTicket.value = false;
};

const saveTiketsOrder = (order, colId) => {
    router.visit(
        route("ticketorders.store", {
            order: order,
            column: colId,
        }),
        {
            method: "post",
            replace: false,
            preserveState: false,
            preserveScroll: true,
        }
    );
};

const updateTicketLocation = (ticketId, colId) => {
    router.visit(
        route("tickets.update", {
            ticket: ticketId,
            column: colId,
        }),
        {
            method: "put",
            replace: false,
            preserveState: false,
            preserveScroll: true,
        }
    );
};

onMounted(() => {
    let ticketElements = document.getElementsByClassName("sortable-tickets");
    for (let i = 0; i < ticketElements.length; i++) {
        Sortable.create(ticketElements[i], {
            group: "tickets",
            animation: 120,
            ghostClass: "card-ghost-class",
            onEnd: function (/**Event*/ e) {
                let col = e.to;
                let colId = col.getAttribute("data-id");
                let items = col.getElementsByTagName("li");
                let order = [];
                for (let i = 0; i < items.length; i++) {
                    order.push(items[i].getAttribute("data-id"));
                }
                saveTiketsOrder(order, colId);
                updateTicketLocation(e.item.getAttribute("data-id"), colId);
            },
        });
    }
});
</script>

<style></style>

<template>
    <h1>Tickets</h1>

    <div class="flex flex-col flex-nowrap justify-between min-h-[250px]">
        <ul
            v-if="tickets"
            :data-id="+thisColumn.id"
            class="sortable-tickets pb-20"
        >
            <li
                :data-id="ticket.id"
                class="galleon-ticket flex flex-col m-2 p-2 bg-slate-200"
                v-for="ticket in tickets"
                :key="ticket.id"
            >
                <p>{{ ticket.id }}</p>
                <p>{{ ticket.tickettitle }}</p>
                <p>{{ ticket.ticketdescription }}</p>
                <p>{{ ticket.created_at }}</p>
            </li>
        </ul>
        <button @click="startCreatingTicket()">Create ticket</button>
    </div>

    <DialogModal :show="creatingTicket" @close="closeModal">
        <template #title> Create New Ticket </template>

        <template #content>
            Enter details of a new ticket

            <div class="mt-4">
                <TextInput
                    ref="titleInput"
                    v-model="newTicketForm.title"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="My new ticket"
                />

                <textarea
                    ref="descriptionInput"
                    v-model="newTicketForm.description"
                    type="text"
                    class="mt-1 block w-3/4"
                    placeholder="Description"
                >
                </textarea>

                <select ref="columnInput" v-model="newTicketForm.column">
                    <option
                        v-for="column in allColumns"
                        :key="column.id"
                        :value="column.id"
                        :selected="column.id == thisColumn.id"
                    >
                        {{ column.columnname }}
                    </option>
                </select>

                <!-- <InputError :message="form.error" class="mt-2" /> -->
            </div>
        </template>

        <template #footer>
            <SecondaryButton @click="closeModal"> Cancel </SecondaryButton>

            <PrimaryButton
                class="ms-3"
                :class="{ 'opacity-25': newTicketForm.processing }"
                :disabled="newTicketForm.processing"
                @click="createTicket"
            >
                Create Ticket
            </PrimaryButton>
        </template>
    </DialogModal>
</template>
