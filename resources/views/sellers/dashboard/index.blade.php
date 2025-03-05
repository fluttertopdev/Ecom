@extends('sellers.layouts.app')
@section('content')


  <style>
        

        #chartContainer {
        max-width: 900px;
        margin: 0 auto;
        padding-bottom: 30px; /* Space below the chart */
    }

    select {
        padding: 10px;
        margin-top: 10px; /* Adjusted margin-top for select */
        font-size: 16px;
    }

    h3 {
        margin-bottom: 0; /* Remove bottom margin */
    }
         .chart-wrapper {
            max-width: 900px;
            margin: 0 auto;
            padding-bottom: 30px;
        }
       
    </style>
 <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="script.js"></script>
        <!-- Content wrapper -->
          <div class="content-wrapper">
            <!-- Content -->

       <div class="container-xxl flex-grow-1 container-p-y">
              <div class="row g-6">
               

                <!-- Statistics -->
                <div class="col-xl-12 col-md-12  mt-4">
                  <div class="card h-100" >
                    <div class="card-header d-flex justify-content-between">
                      <h5 class="card-title mb-0">Statistics</h5>
                     
                    </div>
                    <div class="card-body d-flex align-items-end">
                      <div class="w-100">
                        <div class="row gy-3">
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded bg-label-primary me-4 p-2">
                                <i class="ti ti-chart-pie-2 ti-lg"></i>
                              </div>
                              <div class="card-info">
                                <h5 class="mb-0">{{$todayOrdersQty}}</h5>
                                <small>Today Orders</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded bg-label-info me-4 p-2"><i class="ti ti-users ti-lg"></i></div>
                              <div class="card-info">
                                <h5 class="mb-0">{{$todaySale}}</h5>
                                <small>Today Sale</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded bg-label-danger me-4 p-2">
                                <i class="ti ti-shopping-cart ti-lg"></i>
                              </div>
                              <div class="card-info">
                                <h5 class="mb-0">{{$totalOrdersQty}}</h5>
                                <small>Total Order</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded bg-label-success me-4 p-2">
                                <i class="ti ti-currency-dollar ti-lg"></i>
                              </div>
                              <div class="card-info">
                                <h5 class="mb-0">{{$totalSale}}</h5>
                                <small>Total Sale</small>
                              </div>
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <!--/ Statistics -->
                
                
                <!-- Statistics -->
                <div class="col-xl-12 col-md-12  mt-4">
                  <div class="card h-100" >
                    <div class="card-header d-flex justify-content-between">
                      <h5 class="card-title mb-0">Statistics</h5>
                     
                    </div>
                    <div class="card-body d-flex align-items-end">
                      <div class="w-100">
                        <div class="row gy-3">
                             <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded bg-label-danger me-4 p-2">
                                <i class="ti ti-shopping-cart ti-lg"></i>
                              </div>
                              <div class="card-info">
                                <h5 class="mb-0">{{$totalProduct}}</h5>
                                <small>Products</small>
                              </div>
                            </div>
                          </div>
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded bg-label-primary me-4 p-2">
                                <i class="ti ti-chart-pie-2 ti-lg"></i>
                              </div>
                              <div class="card-info">
                                <h5 class="mb-0">{{$totalWithdraw}}</h5>
                                <small>Total Withdrawn

                         </small>
                              </div>
                            </div>
                          </div>
                           
                          <div class="col-md-3 col-6">
                            <div class="d-flex align-items-center">
                              <div class="badge rounded bg-label-info me-4 p-2"><i class="ti ti-users ti-lg"></i></div>
                              <div class="card-info">
                                <h5 class="mb-0">{{$totalearning}}</h5>
                                <small>Total Earning</small>
                              </div>
                            </div>
                          </div>
                        
                          
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
               

        
  




<div class="col-xxl-12 mt-4">
    <div class="card h-100">
        <div class="card-body p-0 text-center">
            <h3 class="mt-2 mb-0">Seller Orders</h3>
            
            <select id="timeRangeSelect" class="mb-4" style="font-size: 16px; padding: 10px; margin-top: 10px;">
                <option value="7">Last 7 Days</option>
                <option value="30">Last 30 Days</option>
                <option value="365">Last 12 Months</option>
            </select>

            <div id="chartContainer">
                <canvas id="mountainChart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>
<div class="col-xxl-12 mt-4">
    <div class="card h-100">
        <div class="card-body p-0 text-center">
            <h3 id="chartTitle" class="mb-4">Revenue for Last 7 Days</h3>
            <select id="timePeriodSelect" class="mb-4" style="font-size: 16px; padding: 10px;">
                <option value="7">Last 7 Days</option>
                <option value="30">Last 30 Days</option>
                <option value="365">Last 12 Months</option>
            </select>
            <div id="chartContainer">
                <canvas class="chart" style="height: 300px;"></canvas>
            </div>
        </div>
    </div>
</div>
                
                
             

               
                <!-- /Invoice table -->
              </div>
            </div>
            <!-- / Content -->

            <!-- Footer -->
            <footer class="content-footer footer bg-footer-theme">
              <div class="container-xxl">
                <div
                  class="footer-container d-flex align-items-center justify-content-between py-2 flex-md-row flex-column">
                  <div>
                    ©
                    <script>
                      document.write(new Date().getFullYear());
                    </script>
                    , made with ❤️ by
                    <a href="https://pixinvent.com" target="_blank" class="footer-link text-primary fw-medium"
                      >Pixinvent</a
                    >
                  </div>
                  <div class="d-none d-lg-inline-block">
                    <a href="https://themeforest.net/licenses/standard" class="footer-link me-4" target="_blank"
                      >License</a
                    >
                    <a href="https://1.envato.market/pixinvent_portfolio" target="_blank" class="footer-link me-4"
                      >More Themes</a
                    >

                    <a
                      href="https://demos.pixinvent.com/vuexy-html-admin-template/documentation/"
                      target="_blank"
                      class="footer-link me-4"
                      >Documentation</a
                    >

                    <a href="https://pixinvent.ticksy.com/" target="_blank" class="footer-link d-none d-sm-inline-block"
                      >Support</a
                    >
                  </div>
                </div>
              </div>
            </footer>
            <!-- / Footer -->

            <div class="content-backdrop fade"></div>
          </div>
        <!-- Content wrapper -->


<script type="text/javascript">
    // Get the canvas element
    const ctx = document.getElementById('mountainChart').getContext('2d');

    // Initial chart configuration (empty, will be updated later)
    const mountainChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: [], // Will be updated dynamically
            datasets: [
                {
                    label: 'Seller Orders',
                    data: [], // order_total data
                    borderColor: 'rgba(255, 159, 67, 1)',
                    backgroundColor: 'rgba(255, 159, 67, 0.5)',
                    fill: true,
                    tension: 0,
                    borderWidth: 2,
                    orderQuantity: [], // This holds order_quantity data for tooltip
                    orderTotal: [], // This holds order_total data
                },
            ],
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true,
                    position: 'top',
                },
                tooltip: {
                    enabled: true,
                    mode: 'index',  // This allows tooltips to show data for all datasets at the same X value
                    intersect: false, // Tooltip should appear when hovering anywhere along the line
                    callbacks: {
                        title: (tooltipItems) => tooltipItems[0].label,
                        label: (tooltipItem) => {
                            // Display both order amount and order quantity in tooltip
                            const orderQuantity = tooltipItem.dataset.orderQuantity[tooltipItem.dataIndex];
                            const orderTotal = tooltipItem.dataset.orderTotal[tooltipItem.dataIndex];
                            return `Order Amount: ${orderTotal} | Orders: ${orderQuantity}`;
                        },
                    },
                },
            },
            scales: {
                x: {
                    grid: {
                        display: false,
                    },
                },
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(200, 200, 200, 0.3)',
                    },
                    title: {
                        display: true,
                        text: 'Order Amount', // Left-side axis shows order amount
                    },
                },
            },
        },
    });

    // Function to fetch chart data from the server
    function updateChartData(timeRange) {
        fetch('/seller-orders-data?time_range=' + timeRange) // Update with your web route
            .then(response => response.json())
            .then(data => {
                // Update chart with the fetched data
                mountainChart.data.labels = data.labels;
                mountainChart.data.datasets[0].data = data.sellerTotal; // Use order_total for the data
                mountainChart.data.datasets[0].orderQuantity = data.sellerOrders; // Store order_quantity for tooltip
                mountainChart.data.datasets[0].orderTotal = data.sellerTotal; // order_total for Seller orders
                mountainChart.update();
            })
            .catch(error => console.error('Error fetching data:', error));
    }

    // Event listener to change chart data when the time range is selected
    document.getElementById('timeRangeSelect').addEventListener('change', function (e) {
        updateChartData(e.target.value);
    });

    // Load initial data for the chart
    updateChartData('7'); // Default to 'Last 7 Days' on page load
</script>


            
 

<script type="text/javascript">
   const canvas = document.querySelector('.chart').getContext('2d');
const chartTitle = document.getElementById('chartTitle');

// Initialize empty chart
const revenueChart = new Chart(canvas, {
    type: 'line',
    data: {
        labels: [],
        datasets: [
            {
                label: 'Revenue',
                data: [],
                borderColor: '#7367f0',
                backgroundColor: 'rgba(115, 103, 240, 0.5)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
            },
        ],
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false,
            },
            tooltip: {
                mode: 'index', // Display tooltips for the entire index
                intersect: false, // Show tooltips even if not hovering directly on a data point
                callbacks: {
                    title: (tooltipItems) => {
                        return tooltipItems[0].label; // Show label (e.g., date or day name)
                    },
                    label: (tooltipItem) => {
                        return `Revenue: ${tooltipItem.raw}`; // Show revenue value
                    },
                },
            },
        },
        scales: {
            x: { grid: { display: false } },
            y: { 
                beginAtZero: true, 
                grid: { color: 'rgba(200, 200, 200, 0.3)' } 
            },
        },
        hover: {
            mode: 'index', // Highlight the closest index line
            intersect: false, // Highlight even if not on a point
        },
    },
});

// Fetch data and update chart
function fetchRevenueData(period) {
    fetch(`/seller-revenue-data?period=${period}`)
        .then((response) => response.json())
        .then((data) => {
            revenueChart.data.labels = data.labels;
            revenueChart.data.datasets[0].data = data.data;
            revenueChart.update();
        });
}

// Default to last 7 days
fetchRevenueData(7);

// Handle time period change
document.getElementById('timePeriodSelect').addEventListener('change', function () {
    const selectedPeriod = parseInt(this.value);

    if (selectedPeriod === 7) {
        chartTitle.textContent = 'Revenue for Last 7 Days';
    } else if (selectedPeriod === 30) {
        chartTitle.textContent = 'Revenue for Last 30 Days';
    } else if (selectedPeriod === 365) {
        chartTitle.textContent = 'Revenue for Last 12 Months';
    }

    fetchRevenueData(selectedPeriod);
});
</script>

@endsection

























       