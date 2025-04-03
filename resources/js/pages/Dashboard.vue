<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import Chart from 'chart.js/auto';
import { ref, onMounted } from 'vue'

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Panel Principal',
        href: '/dashboard',
    },


];


const props = defineProps({
    chartLabel: {type:String, required:true},
    dataIngresos: {type:Object, required:true},
    dataEgresos: {type:Object, required:true},
    ingresosMensual: {type:String, required:true},
    egresosAnual: {type:String, required:true},
    totalComprasAnual:{type:String, required:true},
    totalGastosAnual:{type:String, required:true},
    ingresosAnual:{type:String, required:true},
    balanceAnual:{type:String, required:true},
    porcentajeAnual:{type:String, required:true},
    porcentajeMensual:{type:String, required:true},
    balance:{type:String, required:true},
    fecha:{type:String, required:true},
    mes:{type:String, required:true},
    gastos:{type:String, required:true},
    compras:{type:String, required:true},
    planillas:{type:String, required:true},
    egresos:{type:String, required:true},
    year:{type:String, required:true},
    meses:{type:Object, required:true},

})


onMounted(() => {
    var ingresosTotal:string[]=[];
    var egresosTotal:string[]=[];
    var chartLabel: string = props.chartLabel
    var meslabel: string[]=[];

    for (let index = 0; index < props.meses.length; index++) {
        meslabel.push(props.meses[index]);
    }

    for(let x=0;x<props.dataIngresos.length; x++)
        {
          ingresosTotal.push(props.dataIngresos[x].total);
        }
          for(let x=0;x<props.dataEgresos.length; x++)
        {
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
                        backgroundColor: ["#00f21c", "#00f21c","#00f21c","#00f21c","#00f21c","#00f21c","#00f21c","#00f21c","#00f21c","#00f21c","#00f21c","#00f21c"],
                    },
                    {
                        label: 'Egresos',
                        data: egresosTotal,
                        backgroundColor: ["#f20800", "#f20800","#f20800","#f20800","#f20800","#f20800","#f20800","#f20800","#f20800","#f20800","#f20800","#f20800"],
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
            <div class="rounded-xl p-4" style="background-color: #1e1b1a;">
                <b><span> Balance Anual: </span></b>
                <div class="grid gap-6 mb-6 md:grid-cols-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingresos del Año </label>
                        <input type="text" :value="ingresosAnual" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Compras del Año</label>
                        <input type="text" :value="totalComprasAnual" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gastos del Año</label>
                        <input type="text" :value="totalGastosAnual" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Balance del Año </label>
                        <input type="text" :value="balanceAnual" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                </div>
            </div>
            <div class="rounded-xl p-4" style="background-color: #1e1b1a;">
                <b><span> Balance del Mes: </span></b>
                <div class="grid gap-6 mb-6 md:grid-cols-4">
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Ingresos del Mes </label>
                        <input type="text" :value="ingresosMensual" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Compras del Mes</label>
                        <input type="text" :value="compras" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Gastos del Mes</label>
                        <input type="text" :value="gastos" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                    </div>
                    <div>
                        <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Balance del Mes</label>
                        <input type="text" :value="balance" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                    </div>
                </div>
            </div>
            <div class="rounded-xl p-4" style="background-color: #1e1b1a;">
                <b><span> Grafica mensual 20{{ year }}: </span></b>
                 <div class="chart-container" style="position: relative; height:80vh; width:75vw">
                <canvas id="myChart"></canvas>
            </div>
            </div>
        </div>
    </AppLayout>
</template>
