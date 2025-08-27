<script setup lang="ts">

import { onMounted } from 'vue'
import Chart from 'chart.js/auto';

const props = defineProps({
    data: { type: Object, required: true },
    titleGrafica: { type: String, required: true },
    chartLabel: { type: String, required: true },
})

// Función para detectar el modo dark
const isDarkMode = () => {
    return document.documentElement.classList.contains('dark') ||
        document.documentElement.getAttribute('data-theme') === 'dark';
}

// Función para obtener los colores según el tema
const getThemeColors = () => {
    const dark = isDarkMode();
    return {
        lineColor: dark ? '#60a5fa' : '#425988', // azul claro en dark, azul oscuro en light
        backgroundColor: dark ? 'rgba(96, 165, 250, 0.1)' : 'rgba(66, 89, 136, 0.1)',
        borderColor: dark ? '#60a5fa' : '#425988',
        gridColor: dark ? 'rgba(148, 163, 184, 0.2)' : 'rgba(0, 0, 0, 0.1)',
        textColor: dark ? '#e2e8f0' : '#374151'
    };
}

onMounted(() => {
    const mes: string[] = [];
    const total: string[] = [];
    const chartLabel: string = props.chartLabel

    for (let x = 0; x < props.data?.length; x++) {
        mes.push(props.data[x].descripcion);
        total.push(props.data[x].total);
    }

    const colors = getThemeColors();
    const ctx = <HTMLCanvasElement>document.getElementById('myChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: mes,
            datasets: [{
                label: chartLabel,
                data: total,
                backgroundColor: colors.backgroundColor,
                borderColor: colors.borderColor,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    labels: {
                        color: colors.textColor
                    }
                }
            },
            scales: {
                x: {
                    beginAtZero: true,
                    grid: {
                        color: colors.gridColor
                    },
                    ticks: {
                        color: colors.textColor
                    }
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: colors.gridColor
                    },
                    ticks: {
                        color: colors.textColor
                    }
                }
            }
        }
    });
})

</script>

<template>
    <b><span> {{ titleGrafica }} </span></b>
    <div class="chart-container" style="position: relative; height:60vh; width:100%; max-width: 100%;">
        <canvas id="myChart"></canvas>
    </div>
</template>
