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
       lineColor: dark ? '#f59e0b' : '#1e40af',            // dark: amber-500, light: blue-900
        backgroundColor: dark ? 'rgba(245,158,11,0.08)' : 'rgba(30,64,175,0.06)', // ligero fill
        borderColor: dark ? '#fbbf24' : '#3b82f6',          // borde de la línea
        pointBackground: dark ? '#ffedd5' : '#bfdbfe',     // puntos interior
        pointBorder: dark ? '#f59e0b' : '#1e40af',         // borde de puntos
        gridColor: dark ? 'rgba(255,255,255,0.06)' : 'rgba(15,23,42,0.06)', // grid sutil
        textColor: dark ? '#e5e7eb' : '#0f172a'            // etiquetas/leyenda
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
        type: 'line',
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
