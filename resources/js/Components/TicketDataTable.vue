<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";
import { FilterMatchMode } from "primevue/api";
import MultiSelect from 'primevue/multiselect';

const page = usePage();
const props = defineProps({
    sortedTickets: Object,
    uncategorisedTickets: Object,
});

const filters = ref({
    global: { value: null, matchMode: FilterMatchMode.CONTAINS },
    tickettitle: { value: null, matchMode: FilterMatchMode.CONTAINS },
    // 'country.name': { value: null, matchMode: FilterMatchMode.STARTS_WITH },
    // representative: { value: null, matchMode: FilterMatchMode.IN },
    // status: { value: null, matchMode: FilterMatchMode.EQUALS },
    // verified: { value: null, matchMode: FilterMatchMode.EQUALS }
});

const sortedTickets = props.sortedTickets;
const uncategorisedTickets = props.uncategorisedTickets;

//console.log(sortedTickets);

let justTickets = {};

// create linear list of tickets for the datatable
let boardName = "";
let columnName = "";
let columncolour = "";
sortedTickets.boards.forEach((b) => {
    boardName = b.boardname;
    b.columns.forEach((c) => {
        columnName = c.columnname;
        columncolour = c.colour;
        c.tickets.forEach((t) => {
            t.id = +t.id;
            t.columnname = columnName;
            t.columncolour = columncolour;
            t.boardname = boardName;
            justTickets[t.id] = t;
        });
    });
});
justTickets = Object.values(justTickets);

//console.log(justTickets);
</script>

<template>
    <DataTable
        v-model:filters="filters"
        :value="justTickets"
        dataKey="id"
        filterDisplay="row"
        :loading="loading"
        :globalFilterFields="['tickettitle']"
        selection-mode="single"
        @rowSelect="console.log('open menu here')"
        groupRowsBy="boardname"
        resizableColumns
        columnResizeMode="fit"
        showGridlines
    >
        <template #empty> No tickets found. </template>
        <template #loading> Loading ticket data. Please wait. </template>

        <template #header>
            <div class="flex flex-row gap-4 justify-start items-center border-b pb-6">
                <MultiSelect placeholder="Columns" class="rounded-none shadow-none border border-1 border-solid border-zinc-300 p-1">
                    
                </MultiSelect>
                <input
                    v-model="filters['global'].value"
                    placeholder="Keyword Search"
                    class="border border-1 border-solid border-zinc-300 p-3 focus-visible:border-emerald-500"
                />
            </div>
        </template>

        <Column sortable field="id" header="id"></Column>
        <Column sortable field="tickettitle" header="title">
            <template #filter="{ filterModel, filterCallback }">
                <input
                    v-model="filterModel.value"
                    type="text"
                    @input="filterCallback()"
                    placeholder="Search by title"
                    class="p-2 px-4 rounded-full bg-zinc-100 border"
                />
            </template>
        </Column>
        <Column sortable field="boardname" header="boardname"></Column>
        <Column sortable field="columnname" header="status">
            <template #body="{ data }">
                <span
                    :class="
                        'bg-' +
                        data.columncolour +
                        '-200' +
                        ' rounded-full px-3 py-1'
                    "
                    >{{ data.columnname }}</span
                >
            </template>
        </Column>
    </DataTable>
</template>
