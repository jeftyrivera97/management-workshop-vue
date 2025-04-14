<script setup lang="ts">
import { type BreadcrumbItem } from '../../types';
import AppLayout from '../../layouts/AppLayout.vue';
import { Head } from '@inertiajs/vue3';
import PlaceholderPattern from '../../components/PlaceholderPattern.vue';
import { LogOut } from 'lucide-vue-next';
import IndexTable from '@/components/shared/autos-table.vue'
import InfoStats from '@/components/shared/info-stats.vue'
import GraficaMes from '@/components/shared/grafica-line.vue'

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
    titleCategorias: { type: String, required: true },
    titlePeriodos: { type: String, required: true },
    titleGrafica: { type: String, required: true },
    headers: { type: Object, required: true },
})


</script>

<template>
    <Head title="Servicios Automotrices" />

    <AppLayout :breadcrumbs="breadcrumbs">

        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4">
            <div class="rounded-xl p-4" style="background-color: #1e1b1a;">
                <InfoStats :promedioSemanal="promedioSemanal" :totalAnual="totalAnual" :totalMes="totalMes"
                    :diferencia="diferencia" />
            </div>
            <div class="rounded-xl p-4" style="background-color: #1e1b1a; margin-top: 5px;">
                <GraficaMes :title="titleGrafica" :data="dataMes" :chartLabel="chartLabel" />
            </div>

            <div class="rounded-xl p-4" style="background-color: #1e1b1a; margin-top: 5px;">
                <IndexTable :title="titleCategorias" :headers="headers" :data="dataMarcas" />
            </div>

            <div class="rounded-xl p-4" style="background-color: #1e1b1a; margin-top: 5px;">
                <IndexTable :title="titlePeriodos" :headers="headers" :data="dataSemanal" />
            </div>
        </div>




    </AppLayout>
</template>


