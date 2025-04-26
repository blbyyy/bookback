@extends('layouts.navigation')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="/assets/img/bookback.png" rel="icon">
<link href="/assets/img/bookback.png" rel="apple-touch-icon">
<main id="main" class="main">

    @if(session('login_success'))
          <script>
              Swal.fire({
                  icon: 'success',
                  title: 'Success',
                  text: '{{ session('login_success') }}',
                  showConfirmButton: false,
                  timer: 2000
              });
          </script>
    @endif

    <section class="section dashboard">
        <div class="row">
          <div class="col-lg-12">
            <div class="row">
            
            <div class="col-xxl-4 col-md-4">
                <div class="card info-card green-card">
    
                    {{-- <div class="filter">
                        <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                        <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                        <li class="dropdown-header text-start">
                            <h6>Filter</h6>
                        </li>
    
                        <li><a class="dropdown-item" href="#">Today</a></li>
                        <li><a class="dropdown-item" href="#">This Month</a></li>
                        <li><a class="dropdown-item" href="#">This Year</a></li>
                        </ul>
                    </div> --}}
    
                    <div class="card-body">
                        <h5 class="card-title">Books On-Shelf</h5>
                        <div class="d-flex align-items-center">
                            <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                                <i class="bi bi-book"></i>
                            </div>
                            <div class="ps-3">
                                <h6>{{$onshelf}}</h6>
                                <span class="text-muted small pt-2 ps-1">Number of Book On-Shelf</span>
                            </div>
                        </div>
                    </div>
    
                </div>
            </div>
                
            <div class="col-xxl-4 col-md-4">
  
                <div class="card info-card orange-card">
  
                  {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>
  
                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div> --}}
  
                  <div class="card-body">
                    <h5 class="card-title">Books On-Hold</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-book"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{$onhold}}</h6>
                        <span class="text-muted small pt-2 ps-1">Number of Books On-Hold</span>
                      </div>
                    </div>
                  </div>
                </div>
  
            </div>

            <div class="col-xxl-4 col-md-4">
                <div class="card info-card red-card">
  
                  {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>
  
                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div> --}}
  
                  <div class="card-body">
                    <h5 class="card-title">Books Currently Out</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-book"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{$currently}}</h6>
                            <span class="text-muted small pt-2 ps-1">Number of Books Currently Out</span>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-xxl-4 col-md-4">
                <div class="card info-card red-card">

                  <div class="card-body ">
                    <h5 class="card-title">Books Due Today</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-book"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{$dueToday}}</h6>
                            <span class="text-muted small pt-2 ps-1">Number of Books Due Today</span>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-xxl-4 col-md-4">
  
                <div class="card info-card orange-card">
  
                  {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>
  
                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div> --}}
  
                  <div class="card-body">
                    <h5 class="card-title">Books Nearing Due Date</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-book"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{$near}}</h6>
                        <span class="text-muted small pt-2 ps-1">Number of Books Nearing Due Date</span>
                      </div>
                    </div>
                  </div>
                </div>
  
            </div>

            <div class="col-xxl-4 col-md-4">
                <div class="card info-card red-card">
  
                  {{-- <div class="filter">
                    <a class="icon" href="#" data-bs-toggle="dropdown"><i class="bi bi-three-dots"></i></a>
                    <ul class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
                      <li class="dropdown-header text-start">
                        <h6>Filter</h6>
                      </li>
  
                      <li><a class="dropdown-item" href="#">Today</a></li>
                      <li><a class="dropdown-item" href="#">This Month</a></li>
                      <li><a class="dropdown-item" href="#">This Year</a></li>
                    </ul>
                  </div> --}}
  
                  <div class="card-body">
                    <h5 class="card-title">Books Overdue</h5>
                    <div class="d-flex align-items-center">
                      <div class="card-icon rounded-circle d-flex align-items-center justify-content-center">
                        <i class="bi bi-book"></i>
                      </div>
                      <div class="ps-3">
                        <h6>{{$overdue}}</h6>
                            <span class="text-muted small pt-2 ps-1">Number of Books Overdue</span>
                      </div>
                    </div>
                  </div>
                </div>
            </div>

            <div class="col-lg-12">
              <div class="card">
                  <div class="card-body">
                      <div class="d-flex justify-content-between align-items-center">
                          <h5 class="card-title">Book Transactions Per Day</h5>
                      </div>
          
                      <canvas id="transactionsPerDayChart" style="max-height: 400px;"></canvas>
                      <script>
                          document.addEventListener("DOMContentLoaded", () => {
                              const transactionsPerDay = <?php echo json_encode($transactionsPerDay); ?>;
                              const labels = transactionsPerDay.map(data => data.date);
                              const counts = transactionsPerDay.map(data => data.count);
          
                              new Chart(document.querySelector('#transactionsPerDayChart'), {
                                  type: 'line',
                                  data: {
                                      labels: labels,
                                      datasets: [{
                                          label: 'Transactions',
                                          data: counts,
                                          backgroundColor: 'rgba(54, 162, 235, 0.5)',
                                          borderColor: 'rgba(54, 162, 235, 1)',
                                          borderWidth: 1
                                      }]
                                  },
                                  options: {
                                      scales: {
                                          y: {
                                              beginAtZero: true,
                                              title: {
                                                  display: true,
                                                  text: 'Number of Transactions'
                                              }
                                          },
                                          x: {
                                              title: {
                                                  display: true,
                                                  text: 'Date'
                                              }
                                          }
                                      }
                                  }
                              });
                          });
                      </script>
                  </div>
              </div>
            </div>
          
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Book Transactions Per Week</h5>
                        </div>

                        <canvas id="transactionsPerWeekChart" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const transactionsPerWeek = <?php echo json_encode($transactionsPerWeek); ?>;
                                const labels = transactionsPerWeek.map(data => `Week ${data.week}, ${data.year}`);
                                const counts = transactionsPerWeek.map(data => data.count);

                                new Chart(document.querySelector('#transactionsPerWeekChart'), {
                                    type: 'bar',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Transactions',
                                            data: counts,
                                            backgroundColor: 'rgba(255, 99, 132, 0.5)',
                                            borderColor: 'rgba(255, 99, 132, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Number of Transactions'
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Week'
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                            <h5 class="card-title">Book Transactions Per Month</h5>
                        </div>

                        <canvas id="transactionsPerMonthChart" style="max-height: 400px;"></canvas>
                        <script>
                            document.addEventListener("DOMContentLoaded", () => {
                                const transactionsPerMonth = <?php echo json_encode($transactionsPerMonth); ?>;
                                const labels = transactionsPerMonth.map(data => `${data.year}-${String(data.month).padStart(2, '0')}`);
                                const counts = transactionsPerMonth.map(data => data.count);

                                new Chart(document.querySelector('#transactionsPerMonthChart'), {
                                    type: 'doughnut',
                                    data: {
                                        labels: labels,
                                        datasets: [{
                                            label: 'Transactions',
                                            data: counts,
                                            backgroundColor: 'rgba(75, 192, 192, 0.5)',
                                            borderColor: 'rgba(75, 192, 192, 1)',
                                            borderWidth: 1
                                        }]
                                    },
                                    options: {
                                        scales: {
                                            y: {
                                                beginAtZero: true,
                                                title: {
                                                    display: true,
                                                    text: 'Number of Transactions'
                                                }
                                            },
                                            x: {
                                                title: {
                                                    display: true,
                                                    text: 'Month'
                                                }
                                            }
                                        }
                                    }
                                });
                            });
                        </script>
                    </div>
                </div>
            </div>

            </div>
          </div>
  
        </div>
    </section>
      
</main>