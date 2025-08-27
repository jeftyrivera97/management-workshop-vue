<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PieChartComponent from '@/components/dashboard/PieChartComponent.vue';
import BarGraphComponent from '@/components/dashboard/BarGraphComponent.vue';
import InfoInputLabel from '@/components/shared/InfoInputLabel.vue';




const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Panel Principal',
        href: '/dashboard',
    },
];

const props = defineProps({
    chartLabel: { type: String, required: true },
    dataIngresos: { type: Object, required: true },
    dataEgresos: { type: Object, required: true },
    ingresosMensual: { type: String, required: true },
    egresosAnual: { type: String, required: true },
    totalComprasAnual: { type: String, required: true },
    totalGastosAnual: { type: String, required: true },
    ingresosAnual: { type: String, required: true },
    balanceAnual: { type: String, required: true },
    porcentajeAnual: { type: String, required: true },
    porcentajeMensual: { type: String, required: true },
    balance: { type: String, required: true },
    fecha: { type: String, required: true },
    mes: { type: String, required: true },
    gastos: { type: String, required: true },
    compras: { type: String, required: true },
    planillas: { type: String, required: true },
    egresos: { type: String, required: true },
    year: { type: String, required: true },
    meses: { type: Object, required: true },
})

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl border p-4 bg-card text-card-foreground shadow">
                <h3 class="text-lg font-semibold mb-4">Balance Anual</h3>
                <div class="grid gap-6 mb-6 md:grid-cols-4">

                    <InfoInputLabel label="Ingresos" :value="props.ingresosAnual" />
                    <InfoInputLabel label="Compras" :value="props.totalComprasAnual" />
                    <InfoInputLabel label="Gastos" :value="props.totalGastosAnual" />
                    <InfoInputLabel label="Balance del Año" :value="props.balanceAnual" />

                </div>
            </div>
            <div class="rounded-xl border p-4 bg-card text-card-foreground shadow">
                <h3 class="text-lg font-semibold mb-4">Balance del Mes</h3>
                <div class="grid gap-6 mb-6 md:grid-cols-4">
                    <InfoInputLabel label="Ingresos" :value="props.ingresosMensual" />
                    <InfoInputLabel label="Compras" :value="props.compras" />
                    <InfoInputLabel label="Gastos" :value="props.gastos" />
                    <InfoInputLabel label="Balance del Año" :value="props.balance" />

                </div>
            </div>

            <div class="grid gap-4 md:grid-cols-2">
                <BarGraphComponent :data-ingresos="props.dataIngresos" :data-egresos="props.dataEgresos"
                    :meses="props.meses" :year="props.year" />
                <PieChartComponent :ingresos-anual="props.ingresosAnual" :total-compras-anual="props.totalComprasAnual"
                    :total-gastos-anual="props.totalGastosAnual" />
            </div>
        </div>
    </AppLayout>
</template>
