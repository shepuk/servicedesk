<script setup>
import { ref } from "vue";
import { router, useForm } from "@inertiajs/vue3";
import { Sortable } from "sortablejs-vue3";
import DialogModal from "../Components/DialogModal.vue";
import TextInput from "./TextInput.vue";
import InputText from "primevue/inputtext";
import PrimaryButton from "../Components/PrimaryButton.vue";
import SecondaryButton from "../Components/SecondaryButton.vue";
import DangerButton from "../Components/DangerButton.vue";

import { PlusSquare } from "lucide-vue-next";
import { all } from "axios";

const { tickets, column, allColumns, ticketOrder, teamUsers } = defineProps({
    tickets: Object,
    column: Number,
    allColumns: Object,
    ticketOrder: String,
    teamUsers: Object,
});

const newTicketForm = useForm({
    title: "My new ticket",
    description: "",
    column: column.id,
    assignee: "",
    severity: "",
    processing: false,
});

const editTicketForm = useForm({
    title: "",
    description: "",
    column: column.id,
    assignee: "",
    severity: "",
    processing: false,
});

const titleInput = ref(null);
const descriptionInput = ref(null);
const creatingTicket = ref(false);
const viewingTicket = ref(false);

const ticketSeverityColour = {
    low: "bg-sky-500",
    normal: "bg-green-500",
    high: "bg-yellow-500",
    critical: "bg-red-500",
};

let currentlyEditingTicket = null;

const startCreatingTicket = () => {
    creatingTicket.value = true;
};
const startViewingTicket = (ticket) => {
    currentlyEditingTicket = ticket;
    viewingTicket.value = true;
};

const createTicket = () => {
    newTicketForm.processing = true;
    newTicketForm.post(route("tickets.store"), {
        onSuccess: () => {
            closeModal();
            newTicketForm.reset();
            tickets.value = props.tickets;
            newTicketForm.processing = false;
            newTicketForm.reset();
            router.visit(route("tickets.index"), {
                preserveScroll: true,
            });
        },
    });
};

const saveTicket = () => {
    editTicketForm.processing = true;
    editTicketForm.post(route("tickets.update"), {
        onSuccess: () => {
            closeModal();
            newTicketForm.reset();
            tickets.value = props.tickets;
            newTicketForm.processing = false;
            newTicketForm.reset();
            router.visit(route("tickets.index"), {
                preserveScroll: true,
            });
        },
    });
};

const deleteTicket = () => {
    closeModal();
    router.delete(route("tickets.destroy", currentlyEditingTicket), {
        onSuccess: () => {},
    });
};

const closeModal = () => {
    creatingTicket.value = false;
    viewingTicket.value = false;
};

const saveTiketsOrder = (order, colId) => {
    router.visit(
        route("ticketorders.store", {
            order: order,
            column: colId,
        }),
        {
            method: "post",
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
            preserveScroll: true,
        }
    );
};

const options = {
    group: "sharedtickets",
    animation: 200,
    ghostClass: "ticket-ghost",
    chosenClass: "tcket-chosen",
    dragClass: "ticket-drag",
    scroll: true,
    forceFallback: true,
    bubbleScroll: true,
    direction: "vertical",
    easing: "cubic-bezier(.25,.75,.5,1.20)",
};

const onEnd = (e) => {
    let colId = e.to.getAttribute("data-id");
    let items = e.to.getElementsByClassName("galleon-ticket");
    let order = [];
    for (let i = 0; i < items.length; i++) {
        order.push(items[i].getAttribute("data-id"));
    }
    saveTiketsOrder(order, colId);
    updateTicketLocation(e.item.getAttribute("data-id"), colId);
};
</script>

<style scoped>
.ticket-ghost {
    background-color: #fff;
}

.ticket-chosen {
    outline: 5px dotted black;
}

.ticket-drag {
    opacity: 1;
    box-shadow: rgba(0, 0, 0, 0.16) 0px 10px 36px 0px,
        rgba(0, 0, 0, 0.06) 0px 0px 0px 1px;
    transform: rotate(4deg);
}
</style>

<template>
    <div class="group pb-20 hover:pb-10">
    <Sortable
        :list="tickets"
        item-key="id"
        tag="div"
        :options="options"
        class="h-full my-2 pb-20"
        @end="onEnd"
        :data-id="column.id"
    >
        <template #item="{ element, index }" :key="element.id">
            <div
                @click="startViewingTicket(element)"
                class="galleon-ticket cursor-pointer p-3 mt-4 w-full bg-white shadow-[0_3px_10px_rgb(0,0,0,0.08)] border border-zinc-200"
                :key="element.id"
                :data-id="element.id"
            >
                <!-- {{ element.id }}
                <br/>
                {{ element.tickettitle }}
                {{ element.ticketdescription }} -->
                <div class="h-full flex flex-col gap-3 justify-between">
                    <div>
                        <div
                            :class="
                                ticketSeverityColour[element.ticketpriority] ||
                                'bg-emerald-500'
                            "
                            class="float-right h-3 w-3 rounded-full"
                        ></div>
                        <p class="text-sm text-slate-500">Paul Shepherd</p>
                        <p class="font-semibold text-md">
                            {{ element.tickettitle }}
                        </p>
                        <p>Client Name • Company</p>
                    </div>
                    <div>
                        <div class="flex gap-2">
                            <div
                                class="bg-sky-200 rounded-full flex items-center px-2 py-[1px] text-sm"
                            >
                                Maintainance
                            </div>
                            <div
                                class="bg-rose-200 rounded-full flex items-center px-2 py-[1px] text-sm"
                            >
                                Bug Fix
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </template>
    </Sortable>
    <button
        class="hidden group-hover:flex w-full items-center justify-center gap-1 px-3 py-2 border border-zinc-200 shadow-md bg-white hover:bg-zinc-100"
        @click="startCreatingTicket()"
    >
        Create ticket
    </button>
</div>

    <DialogModal :show="creatingTicket" @close="closeModal">
        <template #header>
            <div
                class="w-full bg-emerald-500 text-white font-bold text-sm py-1 px-6"
            >
               {{ $page.props.auth.user.name }} -> new ticket
            </div>
        </template>
        <!-- <template #title> New Ticket <br /> </template> -->

        <template #content>
            <div class="flex flex-col gap-8">
                <div class="flex flex-col gap-2">
                    <!-- <label class="">Title</label> -->
                    <input
                        required
                        ref="titleInput"
                        v-model="newTicketForm.title"
                        type="text"
                        class="border p-2 text-3xl w-full rounded-none"
                        placeholder=""
                        value=""
                        name="tickettitle"
                    />
                </div>

                <div class="flex flex-col">
                    <!-- <p class="">Description</p> -->
                    <p class="text-zinc-500 font-semibold mb-2">Description</p>
                    <textarea
                        ref="descriptionInput"
                        v-model="newTicketForm.description"
                        type="text"
                        rows="3"
                        class="border p-2 w-full rounded-none text-lg"
                        placeholder="Enter a description for your ticket here"
                    >
                    </textarea>
                </div>

                <div>
                    <p class="text-zinc-500 font-semibold mb-2">Severity</p>
                    <ul class="grid grid-cols-4 gap-4 w-full">
                        <li class="relative">
                            <input
                                class="sr-only peer"
                                type="radio"
                                id="low"
                                name="severity"
                                value="low"
                                ref="severityInput"
                                v-model="newTicketForm.severity"
                            />
                            <label
                                class="text-zinc-700 flex justify-center font-semibold px-4 py-2 bg-white border border-gray-300 cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:bg-[#0ea5e9] peer-checked:text-white peer-checked:border-transparent"
                                for="low"
                                >Low</label
                            >
                        </li>

                        <li class="relative">
                            <input
                                class="sr-only peer"
                                checked
                                type="radio"
                                id="normal"
                                name="severity"
                                value="normal"
                                ref="severityInput"
                                v-model="newTicketForm.severity"
                            />
                            <label
                                class="text-zinc-700 flex justify-center font-semibold px-4 py-2 bg-white border border-gray-300 cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:bg-[#10b981] peer-checked:text-white peer-checked:border-transparent"
                                for="normal"
                                >Normal</label
                            >
                        </li>
                        <li class="relative">
                            <input
                                class="sr-only peer"
                                type="radio"
                                id="high"
                                name="severity"
                                value="high"
                                ref="severityInput"
                                v-model="newTicketForm.severity"
                            />
                            <label
                                class="text-zinc-700 flex justify-center font-semibold px-4 py-2 bg-white border border-gray-300 cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:bg-[#eab308] peer-checked:text-white peer-checked:border-transparent"
                                for="high"
                                >High</label
                            >
                        </li>
                        <li class="relative">
                            <input
                                class="sr-only peer"
                                type="radio"
                                id="critical"
                                name="severity"
                                value="critical"
                                ref="severityInput"
                                v-model="newTicketForm.severity"
                            />
                            <label
                                class="text-zinc-700 flex justify-center font-semibold px-4 py-2 bg-white border border-gray-300 cursor-pointer focus:outline-none hover:bg-gray-50 peer-checked:bg-[#ef4444] peer-checked:text-white peer-checked:border-transparent"
                                for="critical"
                                >Critical</label
                            >
                        </li>
                    </ul>
                </div>

                <!-- <p class="font-medium mb-4 mt-8">Severity</p>
                <div class="flex gap-8 w-3/4 mb-4">
                    <div class="flex gap-2">
                        <input
                            class="new-ticket-radio"
                            type="radio"
                            id="low"
                           
                            value="low"
                            ref="severityInput"
                            v-model="newTicketForm.severity"
                        />
                        <label for="low" class="pt-[2px]">Low</label>
                    </div>
                    <div class="flex gap-2">
                        <input
                            checked
                            class="new-ticket-radio normal-radio"
                            type="radio"
                            id="normal"
                           
                            value="normal"
                            ref="severityInput"
                            v-model="newTicketForm.severity"
                        />
                        <label for="normal" class="pt-[2px]">Normal</label>
                    </div>
                    <div class="flex gap-2">
                        <input
                            class="new-ticket-radio"
                            type="radio"
                            id="high"
                            
                            value="high"
                            ref="severityInput"
                            v-model="newTicketForm.severity"
                        />
                        <label for="high" class="pt-[2px]">High</label>
                    </div>
                    <div class="flex gap-2">
                        <input
                            class="new-ticket-radio"
                            type="radio"
                            id="critical"
                            
                            value="critical"
                            ref="severityInput"
                            v-model="newTicketForm.severity"
                        />
                        <label for="critical" class="pt-[2px]">Critical</label>
                    </div>
                </div> -->

                <div class="">
                    <p class="text-zinc-500 font-semibold mb-2">Status</p>
                    <select
                        ref="columnInput"
                        v-model="newTicketForm.column"
                        class="w-full border py-3 px-2 focus-visible:outline-none"
                    >
                        <option
                            v-for="column in allColumns"
                            :key="column.id"
                            :value="column.id"
                            :selected="allColumns.id == column.id"
                        >
                            {{ column.columnname }}
                        </option>
                    </select>
                </div>

                <div class="">
                    <p class="text-zinc-500 font-semibold mb-2">Assignee</p>
                    <select
                        class="w-full border py-3 px-2 focus-visible:outline-none"
                        ref="assigneeInput"
                        v-model="newTicketForm.assignee"
                    >
                        <option
                            v-for="user in teamUsers"
                            :key="user.id"
                            :value="user.id"
                        >
                            {{ user.name }}
                        </option>
                    </select>
                </div>

                <!-- <InputError :message="form.error" class="mt-2" /> -->
            </div>
        </template>

        <template #footer>
            <div class="w-full flex flex-row justify-between">
                <SecondaryButton @click="closeModal"> Close </SecondaryButton>

                <PrimaryButton
                    class=""
                    :class="{ 'opacity-25': newTicketForm.processing }"
                    :disabled="newTicketForm.processing"
                    @click="createTicket"
                >
                    Create Ticket
                </PrimaryButton>
            </div>
        </template>
    </DialogModal>

    <DialogModal maxWidth="5xl" :show="viewingTicket" @close="closeModal">
        <template #title>
            {{ currentlyEditingTicket.tickettitle }} <br />
            <span class="text-sm text-gray-600">
                Use the form below to enter new ticket information.
            </span>
        </template>

        <template #content>
            <div class="mt-4">
                viewing ticket!

                <!-- <InputError :message="form.error" class="mt-2" /> -->
            </div>
        </template>

        <template #footer>
            <div class="w-full flex flex-row justify-between">
                <div>
                    <DangerButton @click="deleteTicket(currentlyEditingTicket)">
                        Delete Ticket
                    </DangerButton>
                </div>
                <div>
                    <SecondaryButton @click="closeModal">
                        Close
                    </SecondaryButton>

                    <PrimaryButton
                        class="ms-3"
                        :class="{ 'opacity-25': newTicketForm.processing }"
                        :disabled="newTicketForm.processing"
                        @click="createTicket"
                    >
                        Save Ticket
                    </PrimaryButton>
                </div>
            </div>
        </template>
    </DialogModal>
</template>
