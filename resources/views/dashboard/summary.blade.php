@extends('dashboard')

@section('content')
    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md mb-10">
        <h1 class="text-2xl font-bold mb-4 dark:text-white">Welcome to Your Dashboard</h1>
        <p class="mb-4 dark:text-gray-300">You are logged in!</p>
        <div class="bg-gray-50 dark:bg-gray-700 rounded-lg overflow-hidden shadow">
            <div class="px-4 py-3 bg-gray-100 dark:bg-gray-600">
                <h3 class="text-lg font-semibold text-gray-700 dark:text-white">User Information</h3>
            </div>
            <div class="p-4">
                <p class="text-gray-700 dark:text-gray-300"><span class="font-semibold">Email:</span> {{ auth()->user()->email }}</p>
                <p class="text-gray-700 dark:text-gray-300 mt-2"><span class="font-semibold">Name:</span> {{ auth()->user()->name }}</p>
            </div>
        </div>
        <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
            @csrf
        </form>
    </div>

    <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4 dark:text-white">Data Leak Dashboard</h1>
        <p class="mb-4 dark:text-gray-300">Overview of KTP and KK data leaks</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-blue-100 dark:bg-blue-900 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2 text-blue-800 dark:text-blue-200">Total Leaked Records</h3>
                <p class="text-3xl font-bold text-blue-600 dark:text-blue-300">1,234,567</p>
            </div>
            
            <div class="bg-green-100 dark:bg-green-900 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2 text-green-800 dark:text-green-200">Leak Trend (Last 30 Days)</h3>
                <p class="text-3xl font-bold text-green-600 dark:text-green-300">+15.7%</p>
            </div>
            
            <div class="bg-red-100 dark:bg-red-900 p-4 rounded-lg">
                <h3 class="text-lg font-semibold mb-2 text-red-800 dark:text-red-200">High-Risk Records</h3>
                <p class="text-3xl font-bold text-red-600 dark:text-red-300">1,234,567</p>
            </div>
            <div class="col-span-1 md:col-span-2 h-[300px]">
                <canvas id="ktpVsKkChart"></canvas>
            </div>

            <div class="col-span-1 md:col-span-2 h-[300px]">
                <canvas id="monthlyLeakTrendChart"></canvas>
            </div>

            <div>
                <h3 class="text-lg font-semibold mb-2 dark:text-white">Top 5 Affected Provinces</h3>
                <ul class="space-y-2">
                    <li class="flex justify-between items-center">
                        <span class="dark:text-gray-300">DKI Jakarta</span>
                        <span class="font-semibold dark:text-gray-200">245,678</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="dark:text-gray-300">West Java</span>
                        <span class="font-semibold dark:text-gray-200">198,543</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="dark:text-gray-300">East Java</span>
                        <span class="font-semibold dark:text-gray-200">176,321</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="dark:text-gray-300">Central Java</span>
                        <span class="font-semibold dark:text-gray-200">154,987</span>
                    </li>
                    <li class="flex justify-between items-center">
                        <span class="dark:text-gray-300">North Sumatra</span>
                        <span class="font-semibold dark:text-gray-200">132,654</span>
                    </li>
                </ul>
            </div>
            <div class="h-[300px]">
                <h3 class="text-lg font-semibold mb-2 dark:text-white">Data Leak Sources</h3>
                <canvas id="dataLeakSourcesChart"></canvas>
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const ktpVsKkCtx = document.getElementById('ktpVsKkChart').getContext('2d');
    new Chart(ktpVsKkCtx, {
        type: 'pie',
        data: {
            labels: ['KTP', 'KK'],
            datasets: [{
                data: [65, 35],
                backgroundColor: [
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 99, 132, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Distribution of Leaked Documents'
                }
            }
        }
    });

    const monthlyLeakTrendCtx = document.getElementById('monthlyLeakTrendChart').getContext('2d');
    new Chart(monthlyLeakTrendCtx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            datasets: [{
                label: 'Number of Leaks',
                data: [65, 59, 80, 81, 56, 55, 40, 45, 60, 75, 85, 90],
                fill: false,
                borderColor: 'rgb(75, 192, 192)',
                tension: 0.1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Monthly Leak Trend'
                }
            }
        }
    });

    const dataLeakSourcesCtx = document.getElementById('dataLeakSourcesChart').getContext('2d');
    new Chart(dataLeakSourcesCtx, {
        type: 'doughnut',
        data: {
            labels: ['Hacking', 'Inside Job', 'System Vulnerability', 'Human Error', 'Unknown'],
            datasets: [{
                data: [30, 20, 25, 15, 10],
                backgroundColor: [
                    'rgba(255, 99, 132, 0.8)',
                    'rgba(54, 162, 235, 0.8)',
                    'rgba(255, 206, 86, 0.8)',
                    'rgba(75, 192, 192, 0.8)',
                    'rgba(153, 102, 255, 0.8)'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'top',
                },
                title: {
                    display: true,
                    text: 'Data Leak Sources Distribution'
                }
            }
        }
    });
});
</script>
@endsection