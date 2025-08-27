<script setup lang="ts">
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';

const props = defineProps({
    dataIngresos: { type: Object, required: true },
    dataEgresos: { type: Object, required: true },
    meses: { type: Object, required: true },
    year: { type: String, required: true },
});

// Función para detectar el modo dark
const isDarkMode = () => {
    return document.documentElement.classList.contains('dark') || 
           document.documentElement.getAttribute('data-theme') === 'dark';
}

// Función para obtener los colores según el tema
const getThemeColors = () => {
    const dark = isDarkMode();
    return {
        ingresosColor: dark ? '#22c55e' : '#00f21c', // verde para ingresos
        egresosColor: dark ? '#ef4444' : '#f20800',  // rojo para egresos
        gridColor: dark ? 'rgba(148, 163, 184, 0.2)' : 'rgba(0, 0, 0, 0.1)',
        textColor: dark ? '#e2e8f0' : '#374151'
    };
}

onMounted(() => {
    const ingresosTotal: string[] = [];
    const egresosTotal: string[] = [];
    const meslabel: string[] = [];

    for (let index = 0; index < props.meses.length; index++) {
        meslabel.push(props.meses[index]);
    }

    for (let x = 0; x < props.dataIngresos.length; x++) {
        ingresosTotal.push(props.dataIngresos[x].total);
    }
    for (let x = 0; x < props.dataEgresos.length; x++) {
        egresosTotal.push(props.dataEgresos[x].total);
    }

    const colors = getThemeColors();
    
    // Gráfica de barras
    const ctx = <HTMLCanvasElement>document.getElementById('barChart');
    new Chart(ctx, {
        type: 'bar',
        data: {
            labels: meslabel,
            datasets: [
                {
                    label: 'Ingresos',
                    data: ingresosTotal,
                    backgroundColor: colors.ingresosColor,
                    borderColor: colors.ingresosColor,
                    borderWidth: 1
                },
                {
                    label: 'Egresos',
                    data: egresosTotal,
                    backgroundColor: colors.egresosColor,
                    borderColor: colors.egresosColor,
                    borderWidth: 1
                }
            ]
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
});
</script>

<template>
    <div class="rounded-xl border p-4 bg-card text-card-foreground shadow">
        <h3 class="text-lg font-semibold mb-4">Gráfica mensual 20{{ year }}</h3>
        <div class="chart-container" style="position: relative; height:60vh; width:100%">
            <canvas id="barChart"></canvas>
        </div>
    </div>
</template>

<style scoped>

</style>