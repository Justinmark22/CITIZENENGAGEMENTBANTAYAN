<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Report #{{ $report->id }}</title>
  <style>
    body {
      font-family: DejaVu Sans, sans-serif;
      margin: 50px;
      color: #222;
      line-height: 1.5;
      position: relative;
    }

    .header {
      text-align: center;
      margin-bottom: 30px;
      border-bottom: 2px solid #2563eb;
      padding-bottom: 10px;
    }

    .header img {
      height: 80px;
      margin-bottom: 10px;
    }

    .title {
      margin-top: 10px;
    }

    .title h2 {
      margin: 0;
      font-size: 26px;
      color: #2563eb;
    }

    .title small {
      font-size: 13px;
      color: #666;
    }

    .description {
      font-size: 15px;
      margin: 30px 0;
      color: #444;
      text-align: center;
      line-height: 1.6;
      padding: 0 20px;
    }

    .section {
      margin-bottom: 25px;
    }

    .section h3 {
      color: #2563eb;
      font-size: 16px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 5px;
      margin-bottom: 15px;
    }

    .label {
      font-weight: bold;
      color: #444;
    }

    .value {
      margin-bottom: 10px;
    }

    .badge {
      display: inline-block;
      padding: 6px 12px;
      font-size: 12px;
      color: #fff;
      border-radius: 4px;
      text-transform: uppercase;
    }

    .badge-pending { background-color: #facc15; color: #000; }
    .badge-ongoing { background-color: #0ea5e9; }
    .badge-resolved { background-color: #22c55e; }
    .badge-rejected { background-color: #ef4444; }

    .footer {
      position: absolute;
      bottom: 30px;
      width: 100%;
      text-align: center;
      font-size: 11px;
      color: #888;
    }

    hr {
      border: none;
      border-top: 1px solid #ccc;
      margin: 30px 0;
    }

    .signature {
      margin-top: 80px;
      text-align: left;
      font-size: 13px;
      position: relative;
    }

    .stamp {
      position: absolute;
      top: -100px;
      left: 0;
      width: 120px;
      opacity: 0.3;
    }

    .signature-line {
      margin-top: 40px;
      border-top: 1px solid #333;
      width: 200px;
    }
  </style>
</head>
<body>

  <!-- Header with logo and centered title -->
  <div class="header">
    <img src="{{ public_path('images/santafe.png') }}" alt="Municipal Logo">
    <div class="title">
      <h2>Municipality of Santa Fe</h2>
      <small>Report Management System</small>
    </div>
  </div>

  <!-- Description -->
  <div class="description">
    <strong>Official record of a citizen-submitted report.</strong><br>
    Information below is verified and stored in the municipal system.
  </div>

  <!-- Reporter Info -->
  <div class="section">
    <h3>Reporter Information</h3>
    <div class="label">Name:</div>
    <div class="value">{{ $report->user->name ?? 'Anonymous' }}</div>

    <div class="label">Email:</div>
    <div class="value">{{ $report->user->email ?? 'N/A' }}</div>
  </div>

  <!-- Report Details -->
  <div class="section">
    <h3>Report Details</h3>
    <div class="label">Report ID:</div>
    <div class="value">{{ $report->id }}</div>

    <div class="label">Description:</div>
    <div class="value">{{ $report->description }}</div>

    <div class="label">Status:</div>
    <div class="value">
      <span class="badge 
        @if($report->status == 'Pending') badge-pending 
        @elseif($report->status == 'Ongoing') badge-ongoing 
        @elseif($report->status == 'Resolved') badge-resolved 
        @elseif($report->status == 'Rejected') badge-rejected 
        @endif">
        {{ $report->status }}
      </span>
    </div>

    <div class="label">Created At:</div>
    <div class="value">{{ $report->created_at->format('F d, Y h:i A') }}</div>
  </div>


  <hr>

  <!-- Signature with aligned stamp -->
  <div class="signature">
    <img src="{{ public_path('images/madri.png') }}" alt="Official Stamp" class="stamp">
    <div class="signature-text">
      Verified by:
      <div class="signature-line"></div>
      <div>Municipal Officer / Admin</div>
    </div>
  </div>

  <!-- Footer -->
  <div class="footer">
    © {{ now()->year }} Municipality • Generated on {{ now()->format('F d, Y h:i A') }}
  </div>

</body>
</html>
