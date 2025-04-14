<script setup>

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'


const props = defineProps({
    totalAnual: { type: String, required: true },
    totalMes: { type: String, required: true },
    diferencia: { type: String, required: true },
    promedioSemanal: { type: String, required: true },
})

</script>

<template>
    <div class="grid gap-6 mb-6 md:grid-cols-4">
        <div class="grid w-full max-w-sm items-center gap-1.5">
            <Label for="email">Total Anual</Label>
            <Input id="email" type="text" v-model="props.totalAnual" readonly />
        </div>
        <div class="grid w-full max-w-sm items-center gap-1.5">
            <Label for="email">Total Mes</Label>
            <Input id="email" type="text" v-model="props.totalMes" readonly />
        </div>
        <div class="grid w-full max-w-sm items-center gap-1.5">
            <Label for="email">Comprado con Mes Anterior</Label>
            <Input id="email" type="text" v-model="props.diferencia" readonly />
        </div>
        <div class="grid w-full max-w-sm items-center gap-1.5">
            <Label for="email">Promedio Semanal</Label>
            <Input id="email" type="text" v-model="props.promedioSemanal" readonly />
        </div>
    </div>

</template>
