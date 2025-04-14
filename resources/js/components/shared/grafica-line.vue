<script setup lang="ts">

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto';

const props = defineProps({
    data: { type: Object, required: true },
    titleGrafica: { type: String, required: true },
    chartLabel: { type: String, required: true },
})


onMounted(() => {
    var mes: string[] = [];
    var total: string[] = [];
    var chartLabel: string = props.chartLabel

    for (let x = 0; x < props.data?.length; x++) {
        mes.push(props.data[x].descripcion);
        total.push(props.data[x].total);
    }
    const ctx = <HTMLCanvasElement>document.getElementById('myChart');
    new Chart(ctx, {
        type: 'line',
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
    <b><span> {{titleGrafica}} </span></b>
    <div class="chart-container" style="position: relative; height:80vh; width:75vw">
        <canvas id="myChart"></canvas>
    </div>

</template>
