@extends('layout.admin')

@section('content')
<div class="container mt-4">
        <h1 class="text-center">Dashboard</h1>
        <div class="row">
            <div class="row g-4 mb-4">
                <!-- Total Orders -->
                <div class="col-md-6">
                    <div class="p-3 bg-white shadow-sm rounded border-start border-4 border-primary h-100">
                        <h5 class="text-secondary mb-2">Total Orders</h5>
                        <h2 class="text-primary">{{ array_sum($orderCounts) }}</h2>
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="orderGraph"></canvas>
                        </div>
                    </div>
                </div>

                <!-- Total Sales -->
                <div class="col-md-6">
                    <div class="p-3 bg-white shadow-sm rounded border-start border-4 border-danger h-100">
                        <h5 class="text-secondary mb-2">Total Sales</h5>
                        <h2 class="text-danger">₹ {{ number_format(array_sum($totalAmounts), 2) }}</h2>
                        <h6 class="text-muted">Monthly Order Count & Sales Amount</h6>
                        <div class="chart-container" style="height: 250px;">
                            <canvas id="totalsales"></canvas>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-12 mb-4">
                <div class="stat-card bg-dark text-white">
                    <h3>Top Selling Product Per Month</h3>
                    <button id="viewPie">View Overall Sales</button>
                    <button id="viewMonthly">View by Month</button>
                    <div class="chart-container" style="height: 300px;">
                    <canvas id="productSalesGraph" height="200"></canvas>
                    </div>
                </div>
            </div>

          
        </div>
    </div>

<style>
    .chart-container {
        width: 100%;
        height: 250px; /* Fixed height to prevent infinite growth */
        position: relative;
    }
    canvas {
        max-width: 100% !important;
        max-height: 100% !important;
    }
</style>

<script>
document.addEventListener("DOMContentLoaded", function () {
    // ---- 📦 ORDER GRAPH ---- //
    var orderData = @json($orderCounts);
    var orderLabels = @json($months);

    var orderCtx = document.getElementById("orderGraph").getContext("2d");

    var orderChart = new Chart(orderCtx, {
        type: "bar",
        data: {
            labels: orderLabels,
            datasets: [{
                label: "Orders per Month",
                data: orderData,
                backgroundColor: [
                    "rgba(255, 99, 132, 0.6)",
                    "rgba(54, 162, 235, 0.6)",
                    "rgba(255, 206, 86, 0.6)",
                    "rgba(75, 192, 192, 0.6)",
                    "rgba(153, 102, 255, 0.6)",
                    "rgba(255, 159, 64, 0.6)"
                ],
                borderColor: "rgba(54, 162, 235, 1)",
                borderWidth: 2,
                borderRadius: 8
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false },
                tooltip: {
                    callbacks: {
                        label: function (context) {
                            return "Orders: " + context.raw;
                        }
                    }
                }
            },
            scales: {
                x: {
                    ticks: { color: "#333", font: { size: 14 } },
                    grid: { color: "rgba(200, 200, 200, 0.2)" }
                },
                y: {
                    beginAtZero: true,
                    ticks: { stepSize: 1, color: "#333", font: { size: 14 } },
                    grid: { color: "rgba(200, 200, 200, 0.2)" }
                }
            }
        }
    });

    const totalSalesCtx = document.getElementById("totalsales").getContext("2d");
    const orderSalesMonths = @json($orderSalesMonths);
    const orderCounts = @json($orderCounts);
    const totalAmounts = @json($totalAmounts);

    const orderAndAmountChart = new Chart(totalSalesCtx, {
        type: "bar",
        data: {
            labels: orderSalesMonths,
            datasets: [
                {
                    label: "Total Sales Amount (₹)",
                    data: totalAmounts,
                    backgroundColor: "rgba(255, 99, 132, 0.6)",
                    borderColor: "rgba(255, 99, 132, 1)",
                    borderWidth: 2,
                    borderRadius: 8,
                    yAxisID: 'y1'
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            return context.dataset.label + ": " + (context.dataset.label.includes("₹") ? "₹" : "") + context.raw;
                        }
                    }
                },
                legend: { position: 'top' },
                title: {
                    display: true,
                    text: 'Monthly Order Count & Sales Amount',
                    font: { size: 18 }
                }
            },
            scales: {
                x: {
                    ticks: { color: "#333", font: { size: 14 } },
                    grid: { color: "rgba(200, 200, 200, 0.2)" }
                },
                y: {
                    beginAtZero: true,
                    ticks: { color: "#333", font: { size: 14 } },
                    grid: { color: "rgba(200, 200, 200, 0.2)" },
                    title: {
                        display: true,
                        text: 'Number of Orders'
                    }
                },
                y1: {
                    beginAtZero: true,
                    position: 'right',
                    ticks: { color: "#333", font: { size: 14 } },
                    grid: { drawOnChartArea: false },
                    title: {
                        display: true,
                        text: 'Total Sales Amount (₹)'
                    }
                }
            }
        }
    });

    // ---- 🍰 PRODUCT SALES PIE & LINE CHARTS ---- //
    const productCanvas = document.getElementById("productSalesGraph");
    if (!productCanvas) return;

    const salesLabels = @json($salesLabels ?? []);        // fallback if not set
    const productSales = @json($allProductData ?? []);    // fallback if not set

    let currentChart = null;

    function renderPieChart() {
        const pieDataRaw = @json($pieChartData);
        const pieLabels = pieDataRaw.map(item => item.label);
        const pieValues = pieDataRaw.map(item => item.value);

        if (currentChart) currentChart.destroy();

        currentChart = new Chart(productCanvas.getContext("2d"), {
            type: 'pie',
            data: {
                labels: pieLabels,
                datasets: [{
                    data: pieValues,
                    backgroundColor: pieLabels.map((_, i) => getColor(i)),
                    borderColor: "#fff",
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Product Sales Distribution',
                        font: { size: 20 }
                    },
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 20, padding: 15 }
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.label}: ${context.raw} sold`
                        }
                    }
                }
            }
        });
    }


    function renderLineChart() {
        if (currentChart) currentChart.destroy();

        currentChart = new Chart(productCanvas.getContext("2d"), {
            type: 'line',
            data: {
                labels: salesLabels,
                datasets: productSales.map((item, index) => ({
                    label: item.label,
                    data: item.data,
                    borderWidth: 2,
                    borderColor: getColor(index),
                    backgroundColor: getColor(index, 0.1),
                    fill: true,
                    tension: 0.4,
                    pointRadius: 4,
                    pointHoverRadius: 6
                }))
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    title: {
                        display: true,
                        text: 'Monthly Product Sales Overview',
                        font: { size: 20 }
                    },
                    legend: {
                        position: 'bottom',
                        labels: { boxWidth: 20, padding: 15 }
                    },
                    tooltip: {
                        callbacks: {
                            label: context => `${context.dataset.label}: ${context.raw} sold`
                        }
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month',
                            font: { size: 14 }
                        }
                    },
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Quantity Sold',
                            font: { size: 14 }
                        },
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }

    // 🎨 Color Helper
    function getColor(index, alpha = 0.6) {
        const colors = [
            `rgba(75,192,192,${alpha})`,   // teal
            `rgba(255,99,132,${alpha})`,   // red
            `rgba(255,206,86,${alpha})`,   // yellow
            `rgba(54,162,235,${alpha})`,   // blue
            `rgba(153,102,255,${alpha})`,  // purple
            `rgba(255,159,64,${alpha})`    // orange
        ];
        return colors[index % colors.length];
    }

    // 🔘 Default chart = Pie
    renderPieChart();

    // 🔘 Toggle buttons
    document.getElementById("viewPie").addEventListener("click", renderPieChart);
    document.getElementById("viewMonthly").addEventListener("click", renderLineChart);
});
</script>
@endsection
