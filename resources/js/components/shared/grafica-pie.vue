<script setup lang="ts">

import { Input } from '@/components/ui/input'
import { Label } from '@/components/ui/label'
import { ref, onMounted } from 'vue'
import Chart from 'chart.js/auto';


const props = defineProps({

})


onMounted(() => {

    const ctx = <HTMLCanvasElement>document.getElementById('cc');
    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: 'Datos',
            datasets: [{
                label: 'My First Dataset',
                data: [300, 50, 100],
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
    <b><span> </span></b>
    <div class="chart-container" style="position: relative; height:80vh; width:75vw">
        <canvas id="cc"></canvas>
    </div>

</template>
