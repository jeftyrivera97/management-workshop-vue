<script setup lang="ts">
import { type BreadcrumbItem } from '../../types';
import AppLayout from '../../layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import InfoStats from '@/components/shared/info-stats.vue'
import CategoryTableComponent from '@/components/shared/CategoryTableComponent.vue';
import PieChartMonth from '@/components/shared/PieChartMonth.vue';
import BarChartMonth from '@/components/shared/BarChartMonth.vue';


const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Ingresos',
        href: 'ingreso.index',
    },


];
const props = defineProps({
    modulo: { type: String, required: true },
    chartLabel: { type: String, required: true },
    totalAnual: { type: String, required: true },
    totalMes: { type: String, required: true },
    diferencia: { type: String, required: true },
    promedioSemanal: { type: String, required: true },
    year: { type: String, required: true },
    dataMes: { type: Object, required: true },
    dataSemanal: { type: Object, required: true },
    dataCategorias: { type: Object, required: true },
    titleCategorias: { type: String, required: true },
    titlePeriodos: { type: String, required: true },
    titleGrafica: { type: String, required: true },
    headers: { type: Object, required: true },
})


</script>

<template>

    <Head title="Ingresos" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 max-w-full overflow-hidden">
            <div class="rounded-xl p-4" style="border-width: 1px;">
                <InfoStats :promedioSemanal="promedioSemanal" :totalAnual="totalAnual" :totalMes="totalMes"
                    :diferencia="diferencia" />
            </div>

            <div class="grid gap-4 md:grid-cols-2 w-full">
                <div class="rounded-xl p-4 min-w-0" style="border-width: 1px;">
                    <PieChartMonth :chartLabel="'Ingresos por Categoría'" :titleGrafica="titleCategorias"
                        :data="props.dataCategorias" />
                </div>
                <div class="rounded-xl p-4 min-w-0" style="border-width: 1px;">
                    <BarChartMonth :chartLabel="props.chartLabel" :titleGrafica="props.titleGrafica"
                        :data="props.dataMes" />
                </div>
            </div>

            <div class="rounded-xl p-4" style="border-width: 1px;">
                <CategoryTableComponent :title="props.titleCategorias" :headers="props.headers"
                    :data="props.dataCategorias" />
            </div>

            <div class="rounded-xl p-4" style="border-width: 1px;">
                <CategoryTableComponent :title="props.titlePeriodos" :headers="props.headers"
                    :data="props.dataSemanal" />
            </div>
        </div>


    </AppLayout>
</template>
