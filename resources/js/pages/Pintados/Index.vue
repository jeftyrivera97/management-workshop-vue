<script setup lang="ts">
import { type BreadcrumbItem } from '../../types';
import AppLayout from '../../layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import Chart from 'chart.js/auto';
import { ref, onMounted } from 'vue'
import { LogOut } from 'lucide-vue-next';

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Servicios Autromotrices',
        href: route('pintado.index'),
    },


];
const props = defineProps({
    modulo: {type:String, required:true},
    chartLabel: {type:String, required:true},
    totalAnual: {type:String, required:true},
    totalMes:{type:String, required:true},
    diferencia:{type:String, required:true},
    promedioSemanal:{type:String, required:true},
    year:{type:String, required:true},
    dataMes:{type:Object, required:true},
    dataSemanal:{type:Object, required:true},
    dataMarcas: {type:Object, required:true},
})

onMounted(() => {
    var mes:string[]=[];
    var total:string[]=[];
    var chartLabel: string = props.chartLabel

    for (let x = 0; x < props.dataMes?.length; x++) {
        mes.push(props.dataMes[x].descripcion);
        total.push(props.dataMes[x].total);
    }
    const ctx = <HTMLCanvasElement>document.getElementById('myChart');
        new Chart(ctx, {
        type: 'bar',
        data: {
                labels: mes,
                datasets: [{
                    label: chartLabel,
                    data: total,
                    backgroundColor: ["#425988"],
                }]
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
    <Head title="Servicios Automotrices" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl p-4" style="background-color: #1e1b1a;">
            <div class="grid gap-6 mb-6 md:grid-cols-4">
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">{{modulo}} del Año </label>
                    <input type="text" :value="totalAnual" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Mes</label>
                    <input type="text" :value="totalMes" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Promedio Semanal</label>
                    <input type="text" :value="promedioSemanal" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"  />
                </div>
                <div>
                    <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Comparado con Mes Anterior</label>
                    <input type="text" :value="diferencia" disabled class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" />
                </div>
            </div>
        </div>

        <div class="rounded-xl p-4" style="background-color: #1e1b1a; margin-top: 5px;">
            <b><span> {{modulo}} por Periodos: </span></b>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Periodo
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in dataSemanal" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{data.descripcion}}
                            </th>
                            <td class="px-6 py-4">
                                {{data.total}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class="rounded-xl p-4" style="background-color: #1e1b1a; margin-top: 5px;">
            <b><span> {{modulo}} por Marca: </span></b>
            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                        <tr>
                            <th scope="col" class="px-6 py-3">
                               Categoria
                            </th>
                            <th scope="col" class="px-6 py-3">
                                Total
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="data in dataMarcas" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700 border-gray-200">
                            <th scope="row" class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                {{data.descripcion}}
                            </th>
                            <td class="px-6 py-4">
                                {{data.total}}
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        </div>


        <div class="rounded-xl p-4" style="background-color: #1e1b1a; margin-top: 5px;">
            <b><span> Grafica de {{modulo}} mensual 20{{ year }}: </span></b>
            <div class="chart-container" style="position: relative; height:80vh; width:75vw">
                <canvas id="myChart"></canvas>
            </div>
        </div>




    </AppLayout>
</template>


