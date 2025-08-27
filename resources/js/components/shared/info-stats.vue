<script setup lang="ts">
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"

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
            <Label for="totalAnual">Total Anual</Label>
            <Input id="totalAnual" type="text" :model-value="props.totalAnual" readonly />
        </div>
        <div class="grid w-full max-w-sm items-center gap-1.5">
            <Label for="totalMes">Total Mes</Label>
            <Input id="totalMes" type="text" :model-value="props.totalMes" readonly />
        </div>
        <div class="grid w-full max-w-sm items-center gap-1.5">
            <Label for="diferencia">Comprado con Mes Anterior</Label>
            <Input id="diferencia" type="text" :model-value="props.diferencia" readonly />
        </div>
        <div class="grid w-full max-w-sm items-center gap-1.5">
            <Label for="promedioSemanal">Promedio Semanal</Label>
            <Input id="promedioSemanal" type="text" :model-value="props.promedioSemanal" readonly />
        </div>
    </div>
</template>
