<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Bantayan Admin Dashboard</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Bootstrap + Chart.js + Lucide + Animate -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet"/>

  <style>
    body {
        background-color: rgb(181, 202, 199);
      font-family: 'Segoe UI', sans-serif;
      transition: all 0.3s ease;
    }

    .sidebar {
      height: 100vh;
      width: 240px;
      background: linear-gradient(180deg,rgba(228, 194, 130, 1), #101011ff);
      color: #fff;
      position: fixed;
      top: 0;
      left: 0;
      padding: 2rem 1rem;
      transition: all 0.3s ease;
    }

    .sidebar h5 {
      color: #fff;
      font-weight: 600;
    }

    .sidebar a {
      display: flex;
      align-items: center;
      padding: 0.75rem 1rem;
      color: #cbd5e1;
      text-decoration: none;
      font-weight: 500;
      border-radius: 8px;
      margin-bottom: 1rem;
      transition: all 0.3s ease;
    }

    .sidebar a:hover {
      background-color: rgba(255, 255, 255, 0.1);
      color: #fff;
      transform: scale(1.05);
    }

    .main {
      margin-left: 240px;
      padding: 2rem;
      transition: margin-left 0.3s ease;
    }

    .navbar {
      padding: 1rem 2rem;
      background-color: #ffffff;
      border-bottom: 1px solid #e2e8f0;
      margin-left: 240px;
      position: sticky;
      top: 0;
      z-index: 1000;
      transition: margin-left 0.3s ease;
    }

    .card-box {
  background-color:rgb(211, 214, 220); /* <-- dirty white */
  border-radius: 16px;
  padding: 1.5rem;
  margin-bottom: 1.5rem;
  box-shadow: 0 10px 15px rgba(0,0,0,0.05);
  transition: transform 0.3s;
}


    .card-box:hover {
      transform: translateY(-5px);
    }

    .stat-title {
      color: #6b7280;
      font-size: 0.9rem;
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: #2563eb;
    }

    .section-title {
      font-size: 1.25rem;
      font-weight: 600;
      margin-bottom: 1rem;
      color: #1f2937;
    }

    footer {
      margin-top: 3rem;
      text-align: center;
      font-size: 0.85rem;
      color: #94a3b8;
    }

    /* Dark mode */
    body.dark-mode {
      background-color: #0f172a;
      color: #e2e8f0;
    }

    body.dark-mode .navbar,
    body.dark-mode .card-box,
    body.dark-mode .sidebar {
      background-color: #1e293b;
      color: #e2e8f0;
      border-color: #334155;
    }

    body.dark-mode .sidebar a {
      color: #cbd5e1;
    }

    body.dark-mode .sidebar a:hover {
      background-color: #334155;
      color: #fff;
    }

    /* Sidebar collapsed */
    body.sidebar-collapsed .sidebar {
      width: 60px;
      padding: 1rem 0.5rem;
    }

    body.sidebar-collapsed .sidebar a {
      justify-content: center;
      font-size: 0;
    }

    body.sidebar-collapsed .sidebar a i {
      margin-right: 0;
    }

    body.sidebar-collapsed .navbar,
    body.sidebar-collapsed .main {
      margin-left: 60px;
    }
   
  </style>
</head>
<body>

  <!-- Sidebar -->
<div class="sidebar p-3 bg-light" style="min-height: 100vh;">
  

  
<!-- Logo Section -->
 <div class="text-center mb-4">
  <img src="<?php echo e(asset('images/bantayanlogo.png')); ?>" alt="Santa Fe Logo" class="img-fluid rounded-circle" style="max-height: 80px; width: 80px; object-fit: cover;">
</div>

  <!-- Menu Links -->
  <a href="#"><i data-lucide="home" class="me-2"></i> Dashboard</a>
  <a href="<?php echo e(route('bantayan.users.index')); ?>">
    <i data-lucide="users" class="me-2"></i> Users
  </a>
  <a href="<?php echo e(route('bantayan.reports')); ?>">
    <i data-lucide="file-text" class="me-2"></i> Reports
  </a>
  <a href="<?php echo e(route('bantayan.feedback')); ?>">
    <i data-lucide="message-square" class="me-2"></i> Feedback
  </a>
  <a href="<?php echo e(route('bantayan.announcements')); ?>">
    <i data-lucide="megaphone" class="me-2"></i> Announcements
  </a>
  <a href="<?php echo e(route('bantayan.events')); ?>">
    <i data-lucide="calendar-days" class="me-2"></i> Events
  </a>
<a href="<?php echo e(route('bantayan.updates.index')); ?>">
  <i data-lucide="message-square" class="me-2"></i> Updates
</a>

 
</div>

  <!-- Navbar -->
  <div class="navbar d-flex justify-content-between align-items-center">
    <div class="d-flex align-items-center">
      <button class="btn btn-outline-primary me-3" id="toggleSidebar"><i data-lucide="menu"></i></button>
      <h5 class="mb-0">Municipality of Bantayan</h5>
    </div>
   <div class="dropdown">
  <button class="btn btn-light dropdown-toggle d-flex align-items-center gap-2 px-3 py-2 border rounded-pill shadow-sm"
          type="button" id="adminDropdown" data-bs-toggle="dropdown" aria-expanded="false">
    <i data-lucide="user-cog" class="text-primary"></i>
    <span class="text-muted small">
      Admin • <?php echo e(Auth::user()->email ?? 'admin@santafe.gov'); ?>

    </span>
  </button>

  <ul class="dropdown-menu dropdown-menu-end shadow-lg p-4 rounded-4" style="width: 280px;" aria-labelledby="adminDropdown">
    
    <!-- Dark Mode Toggle -->
    <li class="mb-3 d-flex justify-content-between align-items-center">
      <div class="d-flex align-items-center gap-2">
        <i data-lucide="moon" class="text-secondary"></i>
        <span class="text-muted">Dark Mode</span>
      </div>
      <div class="form-check form-switch m-0">
        <input class="form-check-input" type="checkbox" id="darkModeToggle"
               title="Toggle dark theme">
      </div>
    </li>

    <li><hr class="dropdown-divider"></li>

    <!-- Logout -->
    <li>
      <a class="dropdown-item text-danger d-flex align-items-center gap-2" href="#"
         onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
        <i data-lucide="log-out"></i> Logout
      </a>
    </li>
  </ul>

  <form id="logout-form" action="<?php echo e(route('logout')); ?>" method="POST" style="display: none;">
    <?php echo csrf_field(); ?>
  </form>
</div>
  </div>
  </div>
  <!-- Main Content -->
  <div class="main">
  <!-- Stats -->
  <div class="row g-4 mb-4">
    <div class="col-md-3 animate__animated animate__fadeInUp">
      <div class="card-box text-center border-start border-primary border-4">
        <div class="stat-title"><i data-lucide="users" class="me-1"></i> Total Users</div>
        <div class="stat-value"><?php echo e($totalUsers); ?></div>
      </div>
    </div>
    
    <div class="col-md-3 animate__animated animate__fadeInUp animate__delay-1s">
      <div class="card-box text-center border-start border-success border-4">
        <div class="stat-title"><i data-lucide="file-text" class="me-1"></i> Total Reports</div>
        <div class="stat-value"><?php echo e($totalReports); ?></div>
      </div>
    </div>

    <div class="col-md-3 animate__animated animate__fadeInUp animate__delay-2s">
      <div class="card-box text-center border-start border-warning border-4">
        <div class="stat-title"><i data-lucide="clock" class="me-1"></i> Pending Reports</div>
        <div class="stat-value"><?php echo e($pendingReports); ?></div>
      </div>
    </div>

    <div class="col-md-3 animate__animated animate__fadeInUp animate__delay-3s">
      <div class="card-box text-center border-start border-info border-4">
        <div class="stat-title"><i data-lucide="check-circle" class="me-1"></i> Resolved Reports</div>
        <div class="stat-value"><?php echo e($resolvedReports); ?></div>
      </div>
    </div>
  

    <!-- Charts Section -->
<div class="row g-4">
  <!-- Reports Chart -->
  <div class="col-md-6 animate__animated animate__fadeInUp">
    <div class="card-box">
      <div class="section-title">Reports Chart</div>
      <canvas id="reportsChart" height="100"></canvas>
    </div>
  </div>

  <!-- Users Chart -->
  <div class="col-md-6 animate__animated animate__fadeInUp">
    <div class="card-box">
      <div class="d-flex justify-content-between align-items-center mb-2">
        <div class="section-title mb-0">User Registrations (Bantayan)</div>
        <select id="chartTypeSwitcher" class="form-select w-auto shadow-sm">
          <option value="daily">Daily</option>
          <option value="monthly"> Monthly</option>
        </select>
      </div>
      <canvas id="userChart" height="100"></canvas>
    </div>
  </div>
</div>


    

    <footer>
      &copy; <?php echo e(date('Y')); ?> Municipality of Bantayan. All rights reserved.
    </footer>
  </div>

 <!-- Futuristic Toast -->
<div id="futuristicToast" class="toast-box">
  <strong>Welcome back, Admin!</strong>
</div>


<!-- Toast CSS -->
<style>
.toast-box {
  position: fixed;
  top: 80px;
  left: 50%;
  transform: translateX(-50%);
  padding: 1.8rem 2.8rem;
  background: linear-gradient(135deg, #0ea5e9, #6366f1, #8b5cf6);
  color: #fff;
  font-size: 1.25rem;
  font-weight: 600;
  text-align: center;
  border-radius: 18px;
  box-shadow: 0 0 25px rgba(99, 102, 241, 0.4), 0 0 50px rgba(14, 165, 233, 0.3);
  opacity: 0;
  z-index: 9999;
  animation: fadeSlideIn 1.2s ease forwards;
}
/* Entry Animation */
@keyframes fadeSlideIn {
  0% {
    transform: translateY(-50px);
    opacity: 0;
    filter: blur(5px);
  }
  50% {
    opacity: 0.8;
    transform: translateY(-20px);
    filter: blur(2px);
  }
  100% {
    transform: translateY(0);
    opacity: 1;
    filter: blur(0);
  }
}

/* Exit Animation */
@keyframes fadeSlideOut {
  0% {
    transform: translateY(0);
    opacity: 1;
    filter: blur(0);
  }
  50% {
    opacity: 0.5;
    transform: translateY(-20px);
    filter: blur(2px);
  }
  100% {
    transform: translateY(-50px);
    opacity: 0;
    filter: blur(5px);
  }
}
</style>

<!-- Toast JavaScript -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  const toast = document.getElementById('futuristicToast');

  // Delay before triggering fade-out
  setTimeout(() => {
    toast.style.animation = 'fadeSlideOut 1s ease forwards';
  }, 3000); // Disappear after 3 seconds
});
</script>





  <!-- Scripts -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
  <script>
    lucide.createIcons();

   fetch('/reports/chart-data')
  .then(response => response.json())
  .then(data => {
    const ctx = document.getElementById('reportsChart').getContext('2d');
    new Chart(ctx, {
      type: 'bar',
      data: {
        labels: data.labels,
        datasets: [{
          label: 'Reports',
          data: data.counts,
          fill: true,
          backgroundColor: 'rgba(37, 99, 235, 0.3)',
          borderColor: '#2563eb',
          tension: 0.4,
          pointRadius: 3,
          pointBackgroundColor: '#2563eb'
        }]
      },
      options: {
        responsive: true,
        animation: {
          duration: 1500,
          easing: 'easeOutQuart'
        },
        plugins: {
          legend: {
            labels: {
              color: getComputedStyle(document.body).color
            }
          },
          annotation: {
            annotations: {
              thresholdLine: {
                type: 'line',
                yMin: 50, // Change this to the value you want the line at
                yMax: 50,
                borderColor: 'red',
                borderWidth: 2,
                label: {
                  content: 'Threshold',
                  enabled: true,
                  position: 'end',
                  backgroundColor: 'rgba(0,0,0,0.6)',
                  color: '#fff'
                }
              }
            }
          }
        },
        scales: {
          x: {
            ticks: {
              color: getComputedStyle(document.body).color
            }
          },
          y: {
            beginAtZero: true,
            ticks: {
              color: getComputedStyle(document.body).color
            }
          }
        }
      }
    });
  });


    // Sidebar toggle
    document.getElementById('toggleSidebar').addEventListener('click', () => {
      document.body.classList.toggle('sidebar-collapsed');
    });

    // Dark mode
    document.getElementById('darkModeToggle').addEventListener('change', function () {
      document.body.classList.toggle('dark-mode', this.checked);
    });

  
  
 
  






    // Live search
    document.getElementById('searchInput').addEventListener('input', function () {
      const term = this.value.toLowerCase();
      document.querySelectorAll('.feedback-entry').forEach(entry => {
        entry.style.display = entry.innerText.toLowerCase().includes(term) ? '' : 'none';
      });
    });
  </script>
 <script>
  const userChartCtx = document.getElementById('userChart').getContext('2d');

  const chartData = {
    daily: {
      labels: <?php echo json_encode($dailyLabels, 15, 512) ?>,
      data: <?php echo json_encode($dailyCounts, 15, 512) ?>
    },
    monthly: {
      labels: <?php echo json_encode($monthlyLabels, 15, 512) ?>,
      data: <?php echo json_encode($monthlyCounts, 15, 512) ?>
    }
  };

  const barColors = [
    '#6366f1', '#34d399', '#f59e0b', '#ef4444', '#0ea5e9',
    '#a855f7', '#10b981', '#f43f5e', '#f97316', '#22c55e'
  ];

  let currentChart;

  function renderUserChart(type = 'daily') {
    if (currentChart) currentChart.destroy();

    const labels = chartData[type].labels;
    const data = chartData[type].data;

    currentChart = new Chart(userChartCtx, {
      type: 'bar', // base type
      data: {
        labels: labels,
        datasets: [
          {
            type: 'bar',
            label: 'User Registrations (Bar)',
            data: data,
            backgroundColor: labels.map((_, i) => barColors[i % barColors.length]),
            borderWidth: 0,
            barThickness: 'flex',
            categoryPercentage: 1.0,
            barPercentage: 1.0,
            yAxisID: 'y' // horizontal bars
          },
         {
  type: 'line',
  label: 'User Trend (Line)',
  data: data,
  borderColor: '#2563eb',
  backgroundColor: 'rgba(37, 99, 235, 0.2)',
  tension: 0,              // 👈 No smoothing — makes it zigzag
  pointRadius: 4,
  fill: false,
  xAxisID: 'x2',
  yAxisID: 'y2'
}

        ]
      },
      options: {
        indexAxis: 'y', // bar chart is horizontal
        responsive: true,
        plugins: {
          legend: { display: true },
          tooltip: {
            mode: 'index',
            intersect: false,
            callbacks: {
              label: ctx => `Users: ${ctx.raw}`
            }
          }
        },
        scales: {
          y: {
            position: 'left',
            beginAtZero: true,
            grid: { display: false },
            title: {
              display: true,
              text: 'User Count (Bar)'
            }
          },
          x: {
            position: 'bottom',
            beginAtZero: true,
            title: {
              display: true,
              text: 'Count'
            }
          },
          y2: {
            position: 'right',
            beginAtZero: true,
            grid: { drawOnChartArea: false }, // don't overlap y grid
            title: {
              display: true,
              text: 'User Trend (Line)'
            }
          },
          x2: {
            display: false // the line uses the same labels but doesn't render axis
          }
        }
      }
    });
  }

  // Initial render
  renderUserChart('daily');

  // Chart switch
  document.getElementById('chartTypeSwitcher').addEventListener('change', (e) => {
    renderUserChart(e.target.value);
  });
</script>


</body>
</html>
<?php /**PATH C:\Users\ADMIN\my-app\CITIZENENGAGEMENTBANTAYAN\resources\views/dashboard/bantayanadmin.blade.php ENDPATH**/ ?>