<script setup lang="ts">
import Chart from 'chart.js/auto';
import { onMounted } from 'vue';

const props = defineProps({
    ingresosAnual: { type: String, required: true },
    totalComprasAnual: { type: String, required: true },
    totalGastosAnual: { type: String, required: true },
});

// Función para detectar el modo dark
const isDarkMode = () => {
    return document.documentElement.classList.contains('dark') ||
        document.documentElement.getAttribute('data-theme') === 'dark';
};

// Función para obtener los colores según el tema
const getThemeColors = () => {
    const dark = isDarkMode();
    return {
        textColor: dark ? '#e2e8f0' : '#374151'
    };
}

// Función para obtener colores específicos para la gráfica pie
const getPieColors = () => {
    const dark = isDarkMode();
    return {
        // Ingresos - Verde
        ingresosColor: dark ? '#22c55e' : '#10b981',
        ingresosBorder: dark ? '#16a34a' : '#059669',
        // Compras - Amarillo
        comprasColor: dark ? '#fbbf24' : '#f59e0b',
        comprasBorder: dark ? '#f59e0b' : '#d97706',
        // Gastos - Rojo
        gastosColor: dark ? '#ef4444' : '#dc2626',
        gastosBorder: dark ? '#dc2626' : '#b91c1c',
    };
}

// Función helper para limpiar y convertir valores monetarios
const parseMoneyValue = (value: string): number => {
    if (!value) return 0;
    return parseFloat(value.replace(/[^\d.-]/g, '')) || 0;
};

onMounted(() => {
    // Nueva gráfica pie de comparación anual
    const pieCtx = <HTMLCanvasElement>document.getElementById('pieChart');
    const pieColors = getPieColors();
    const colors = getThemeColors();

    new Chart(pieCtx, {
        type: 'doughnut',
        data: {
            labels: ['Ingresos', 'Compras', 'Gastos'],
            datasets: [{
                label: 'Comparación Anual',
                data: [
                    parseMoneyValue(props.ingresosAnual),
                    parseMoneyValue(props.totalComprasAnual),
                    parseMoneyValue(props.totalGastosAnual)
                ],
                backgroundColor: [
                    pieColors.ingresosColor,
                    pieColors.comprasColor,
                    pieColors.gastosColor
                ],
                borderColor: [
                    pieColors.ingresosBorder,
                    pieColors.comprasBorder,
                    pieColors.gastosBorder
                ],
                borderWidth: 2,
                hoverOffset: 4
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        color: colors.textColor,
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 14
                        }
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a: number, b: number) => a + b, 0);
                            const percentage = total > 0 ? ((value / total) * 100).toFixed(1) : '0.0';
                            return `${label}: L. ${value.toLocaleString()} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });
});
</script>

<template>
    <div class="rounded-xl border p-4 bg-card text-card-foreground shadow">
        <h3 class="text-lg font-semibold mb-4">Comparación Anual - Ingresos vs Gastos vs Compras</h3>
        <div class="chart-container" style="position: relative; height:60vh; width:100%">
            <canvas id="pieChart"></canvas>
        </div>
    </div>
</template>

<style scoped></style>