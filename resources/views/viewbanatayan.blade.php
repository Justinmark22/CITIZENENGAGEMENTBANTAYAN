<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Bantayan</title>

  <!-- Chart.js & Bootstrap -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" />
  <script src="https://unpkg.com/lucide@latest"></script>

  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #f1f5f9;
      padding: 2rem;
    }

    .card-box {
      background-color: #fff;
      border-radius: 0.75rem;
      padding: 1.5rem;
      box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
      border: 1px solid #e2e8f0;
      margin-bottom: 2rem;
    }

    .stat-title {
      font-size: 0.95rem;
      color: #64748b;
    }

    .stat-value {
      font-size: 2rem;
      font-weight: 700;
      color: #1d4ed8;
    }

    .section-title {
      font-weight: 600;
      margin-bottom: 1rem;
      font-size: 1.25rem;
      color: #1e293b;
    }

    footer {
      font-size: 0.85rem;
      color: #64748b;
      text-align: center;
      margin-top: 3rem;
    }
  </style>
</head>
<body>

  <!-- Welcome Panel -->
  <div class="mb-4">
    <h2>Welcome, Admin</h2>
    <p class="text-muted">Municipality of Bantayan - LGU Monitoring and Feedback Dashboard</p>
  </div>

  <!-- Stats Grid -->
  <div class="row g-4 mb-4">
    <div class="col-md-4">
      <div class="card-box text-center">
        <div class="stat-title"><i data-lucide="users" class="me-1"></i> Total Users</div>
        <div class="stat-value">{{ $totalUsers }}</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-box text-center">
        <div class="stat-title"><i data-lucide="file-text" class="me-1"></i> Total Reports</div>
        <div class="stat-value">{{ $totalReports }}</div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card-box text-center">
        <div class="stat-title"><i data-lucide="clock" class="me-1"></i> Pending Reports</div>
        <div class="stat-value">{{ $pendingReports }}</div>
      </div>
    </div>
  </div>

  <!-- Reports Overview -->
  <div class="card-box">
    <div class="section-title">Reports Overview</div>
    <p>Total reports : <strong>{{ $totalReports }}</strong></p>
    <p>Pending reports: <strong>{{ $pendingReports }}</strong></p>
  </div>

  <!-- Feedback Section -->
  <div class="card-box">
    <div class="section-title">Latest Feedback</div>
    @forelse ($feedbacks as $feedback)
      <div class="mb-3 border-bottom pb-2">
        <p><strong>Feedback:</strong> {{ $feedback->feedback }}</p>
        <p><strong>Rating:</strong> {{ $feedback->rating }} / 5</p>
        <p class="text-muted">Submitted on {{ $feedback->created_at->format('F j, Y') }}</p>
      </div>
    @empty
      <p class="text-muted">No feedback available yet.</p>
    @endforelse
  </div>

  

  <footer>
    &copy; {{ date('Y') }} Municipality of Bantayan. All rights reserved.
  </footer>

  <script>
    lucide.createIcons();

    document.addEventListener("DOMContentLoaded", function () {
      fetch('/reports/chart-data')
        .then(response => response.json())
        .then(data => {
          const ctx = document.getElementById('reportsChart').getContext('2d');
          new Chart(ctx, {
            type: 'bar',
            data: {
              labels: data.labels,
              datasets: [{
                label: 'Total Reports',
                data: data.counts,
                backgroundColor: '#3b82f6',
                borderRadius: 6
              }]
            },
            options: {
              responsive: true,
              scales: {
                y: {
                  beginAtZero: true
                }
              }
            }
          });
        });
    });
  </script>
</body>
</html>
