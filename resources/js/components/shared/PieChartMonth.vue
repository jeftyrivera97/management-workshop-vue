<script setup lang="ts">

import { onMounted, onBeforeUnmount, ref } from 'vue'
import Chart from 'chart.js/auto';

const props = defineProps({
    data: { type: Object, required: true },
    titleGrafica: { type: String, required: true },
    chartLabel: { type: String, required: true },
})

// Referencia para almacenar la instancia del gráfico
const chartInstance = ref<Chart | null>(null);
// Generar ID único para el canvas
const chartId = ref(`pieChart_${Math.random().toString(36).substr(2, 9)}`);

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
    const total: number[] = [];
    const chartLabel: string = props.chartLabel

    for (let x = 0; x < props.data?.length; x++) {
        mes.push(props.data[x].descripcion);
        total.push(props.data[x].total);
    }

    // Generar colores únicos para cada categoría
    const generateColors = (count: number) => {
        const colors = [
            '#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', 
            '#9966FF', '#FF9F40', '#FF6384', '#C9CBCF',
            '#4BC0C0', '#FF6384', '#36A2EB', '#FFCE56'
        ];
        
        // Si hay más categorías que colores predefinidos, generar colores adicionales
        while (colors.length < count) {
            const hue = (colors.length * 360 / count) % 360;
            colors.push(`hsl(${hue}, 70%, 60%)`);
        }
        
        return colors.slice(0, count);
    };

    const backgroundColors = generateColors(props.data?.length || 0);
    const borderColors = backgroundColors.map(color => color.replace('0.8', '1'));

    const colors = getThemeColors();
    const ctx = <HTMLCanvasElement>document.getElementById(chartId.value);
    
    
    chartInstance.value = new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: mes,
            datasets: [{
                label: chartLabel,
                data: total,
                backgroundColor: backgroundColors,
                borderColor: borderColors,
                borderWidth: 2,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'right',
                    labels: {
                        color: colors.textColor,
                        usePointStyle: true,
                        padding: 20
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a: number, b: number) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${context.label}: L. ${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
})

// Limpiar el gráfico cuando el componente se desmonte
onBeforeUnmount(() => {
    if (chartInstance.value) {
        chartInstance.value.destroy();
        chartInstance.value = null;
    }
})

</script>

<template>
    <b><span> {{ titleGrafica }} </span></b>
    <div class="chart-container" style="position: relative; height:50vh; width:100%">
        <canvas :id="chartId"></canvas>
    </div>
</template>
