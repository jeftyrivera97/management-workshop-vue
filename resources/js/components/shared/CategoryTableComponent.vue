<script setup lang="ts">

import { Table, TableBody, TableCaption, TableCell, TableHead, TableRow, } from "@/components/ui/table"

const props = defineProps({
    title: { type: String, required: true },
    headers: { type: Object, required: true },
    data: { type: Object, required: true },
})

console.log(props.headers);
console.log(props.title);
console.log(props.data);

</script>

<template>
    <b><span> {{ title }} </span></b>
    <Table>
        <TableCaption>Todos los Registros.</TableCaption>
        <TableHead v-for="header in headers" :key="header.index">{{ header }}</TableHead>
        <TableBody>
            <TableRow v-for="item in data" :key="item.id">
                <TableCell class="font-medium">
                    {{ item.descripcion }}
                </TableCell>
                <TableCell>{{ item.porcentaje }}%</TableCell>
                <TableCell>L. {{ item.total }}</TableCell>
            </TableRow>
        </TableBody>
    </Table>

</template>
