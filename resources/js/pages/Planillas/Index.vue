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
        title: 'Planillas',
        href: route('planilla.index'),
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
    dataCategorias: { type: Object, required: true },
    dataSemanal: { type: Object, required: true },
    titleCategorias: { type: String, required: true },
    titlePeriodos: { type: String, required: true },
    titleGrafica: { type: String, required: true },
    headers: { type: Object, required: true },
})


</script>

<template>

    <Head title="Planillas" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl p-4" style="border-width: 1px;">
                <InfoStats :promedioSemanal="promedioSemanal" :totalAnual="totalAnual" :totalMes="totalMes"
                    :diferencia="diferencia" />
            </div>
            <div class="grid gap-4 md:grid-cols-2 w-full">
                <div class="rounded-xl p-4 min-w-0" style="border-width: 1px;">
                    <PieChartMonth :chartLabel="'Planillas por Empleado'" :titleGrafica="titleCategorias"
                        :data="props.dataCategorias" />
                </div>
                <div class="rounded-xl p-4 min-w-0" style="border-width: 1px;">
                    <BarChartMonth :chartLabel="'Planillas por mes'" :titleGrafica="'Planillas por mes'"
                        :data="dataMes" />
                </div>
            </div>

            <div class="rounded-xl p-4" style="border-width: 1px;">
                <CategoryTableComponent :title="titleCategorias" :headers="headers" :data="dataCategorias" />
            </div>

            <div class="rounded-xl p-4" style="border-width: 1px;">
                <CategoryTableComponent :title="titlePeriodos" :headers="headers" :data="dataSemanal" />
            </div>
        </div>


    </AppLayout>
</template>
