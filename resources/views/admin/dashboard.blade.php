@extends('layout.admin')

@section('content')
<div class="container mt-4">
        <h1 class="mb-4 text-center">Admin Dashboard</h1>
        <div class="row">
            <div class="col-md-4 mb-4">
                <div class="stat-card bg-primary text-white">
                    <h3>Total Orders</h3>
                    <p>{{ array_sum($orderCounts) }}</p>
                    <div class="chart-container">
                        <canvas id="orderGraph"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card bg-danger text-white">
                    <h3>Total Products</h3>
                    <p>35</p>
                    <p><strong>Trending:</strong> Chocolate Cake</p>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="stat-card bg-success text-white">
                    <h3>Total Sales</h3>
                    <p>$2500</p>
                    <div class="chart-container">
                        <canvas id="salesGraph"></canvas>
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
    document.addEventListener("DOMContentLoaded", function() {
        var orderData = @json($orderCounts);
        var orderLabels = @json($months);

        var ctx = document.getElementById("orderGraph").getContext("2d");

        var orderChart = new Chart(ctx, {
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
                            label: function(context) {
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
    });
</script>
@endsection
