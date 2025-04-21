<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Chart from 'chart.js/auto';
import { ref, onMounted } from 'vue'
import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import GraficaMes from '@/components/shared/grafica-pie.vue'


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


onMounted(() => {
    var ingresosTotal: string[] = [];
    var egresosTotal: string[] = [];
    var chartLabel: string = props.chartLabel
    var meslabel: string[] = [];

    for (let index = 0; index < props.meses.length; index++) {
        meslabel.push(props.meses[index]);
    }

    for (let x = 0; x < props.dataIngresos.length; x++) {
        ingresosTotal.push(props.dataIngresos[x].total);
    }
    for (let x = 0; x < props.dataEgresos.length; x++) {
        egresosTotal.push(props.dataEgresos[x].total);
    }

    const ctx = <HTMLCanvasElement>document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: meslabel,
            datasets: [
                {
                    label: 'Ingresos',
                    data: ingresosTotal,
                    backgroundColor: ["#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c", "#00f21c"],
                },
                {
                    label: 'Egresos',
                    data: egresosTotal,
                    backgroundColor: ["#f20800", "#f20800", "#f20800", "#f20800", "#f20800", "#f20800", "#f20800", "#f20800", "#f20800", "#f20800", "#f20800", "#f20800"],
                    borderWidth: 1
                }
            ]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
})

</script>

<template>

    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl p-4" style="border-width: 1px;">
                <b><span> Balance Anual </span></b>
                <div class="grid gap-6 mb-6 md:grid-cols-4">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Ingresos </Label>
                        <Input id="email" type="text" v-model="props.ingresosAnual" readonly />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Compras</Label>
                        <Input id="email" type="text" v-model="props.totalComprasAnual" readonly />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Gastos </Label>
                        <Input id="email" type="text" v-model="props.totalComprasAnual" readonly />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Balance del Año</Label>
                        <Input id="email" type="text" v-model="props.balanceAnual" readonly />
                    </div>
                </div>
            </div>
            <div class="rounded-xl p-4" style="border-width: 1px;">
                <b><span> Balance del Mes </span></b>
                <div class="grid gap-6 mb-6 md:grid-cols-4">
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Ingresos </Label>
                        <Input id="email" type="text" v-model="props.ingresosMensual" readonly />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Compras </Label>
                        <Input id="email" type="text" v-model="props.compras" readonly />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Gastos </Label>
                        <Input id="email" type="text" v-model="props.gastos" readonly />
                    </div>
                    <div class="grid w-full max-w-sm items-center gap-1.5">
                        <Label for="email">Balance del Mes</Label>
                        <Input id="email" type="text" v-model="props.balance" readonly />
                    </div>

                </div>
            </div>
            <div class="rounded-xl p-4" style="border-width: 1px;">
                <b><span> Grafica mensual 20{{ year }}: </span></b>
                <div class="chart-container" style="position: relative; height:80vh; width:75vw">
                    <canvas id="myChart"></canvas>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
