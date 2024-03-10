<script setup>
import { ref, onMounted } from "vue";
import { usePage } from "@inertiajs/vue3";
import DataTable from "primevue/datatable";
import Column from "primevue/column";
import ColumnGroup from "primevue/columngroup";
import Row from "primevue/row";

const page = usePage();
const props = defineProps({
    sortedTickets: Object,
    uncategorisedTickets: Object,
});

const sortedTickets = props.sortedTickets;
const uncategorisedTickets = props.uncategorisedTickets;

console.log(sortedTickets);

let justTickets = {};
// console.log(sortedTickets);

// create linear list of tickets for the datatable
let boardName = "";
let columnName = "";
let colArray = [];
// sortedTickets.boards.forEach((b) => {
//     boardName = b.boardname;
//     b.columns.forEach((c) => {
//         columnName = c.columnname;
//         c.tickets.forEach((t) => {
//             t.columnname = columnName;
//             t.boardname = boardName;
//             justTickets[t.id] = t;
//         });
//     });
// });

console.log(justTickets);
</script>

<template>
    <DataTable
        :value="justTickets"
        @rowSelect="console.log('open menu here')"
        removableSort
        showGridlines
        selectionMode="single"
        groupRowsBy="boardname"
    >
        <Column sortable field="id" header="id"></Column>
        <Column sortable field="tickettitle" header="title"></Column>
        <Column sortable field="boardname" header="boardname"></Column>
        <Column sortable field="columnname" header="status"></Column>
    </DataTable>
</template>
