<script setup>

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { Table, TableBody, TableCaption, TableCell, TableHead, TableHeader, TableRow, } from '@/components/ui/table'

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
                    <TableCell> {{ item.total }} Vehiculos</TableCell>
                </TableRow>
            </TableBody>
    </Table>

</template>
