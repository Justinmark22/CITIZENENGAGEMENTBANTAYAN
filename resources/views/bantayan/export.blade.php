<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>Bantayan - Report #{{ $report->id }}</title>
  <style>
    @page {
      size: A4;
      margin: 25mm;
    }

    body {
      font-family: DejaVu Sans, sans-serif;
      margin: 0;
      padding: 0;
      color: #222;
      line-height: 1.4;
      font-size: 13px;
      position: relative;
    }

    .header {
      text-align: center;
      margin-bottom: 20px;
      border-bottom: 2px solid #2563eb;
      padding-bottom: 10px;
    }

    .header img {
      height: 70px;
      margin-bottom: 8px;
    }

    .title h2 {
      margin: 0;
      font-size: 22px;
      color: #2563eb;
    }

    .title small {
      font-size: 12px;
      color: #666;
    }

    .description {
      font-size: 12px;
      margin: 15px 0;
      color: #444;
      text-align: center;
      padding: 0 10px;
    }

    .section {
      margin-bottom: 20px;
    }

    .section h3 {
      color: #2563eb;
      font-size: 15px;
      border-bottom: 1px solid #ddd;
      padding-bottom: 4px;
      margin-bottom: 8px;
    }

    .label {
      font-weight: bold;
      color: #333;
      font-size: 12px;
      margin-bottom: 2px;
    }

    .value {
      margin-bottom: 6px;
      font-size: 12px;
    }

    .badge {
      display: inline-block;
      padding: 3px 8px;
      font-size: 11px;
      color: #fff;
      border-radius: 3px;
      text-transform: uppercase;
    }

    .badge-pending { background-color: #facc15; color: #000; }
    .badge-ongoing { background-color: #0ea5e9; }
    .badge-resolved { background-color: #22c55e; }
    .badge-rejected { background-color: #ef4444; }

    hr {
      border: none;
      border-top: 1px solid #ccc;
      margin: 20px 0;
    }

    /* Signature Section */
    .signature {
      margin-top: 40px;
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .stamp {
      width: 90px;
      opacity: 0.5;
    }

    .signature-text {
      flex: 1;
      font-size: 12px;
    }

    .signature-line {
      margin-top: 25px;
      border-top: 1px solid #333;
      width: 180px;
    }

    .footer {
      position: absolute;
      bottom: 15px;
      width: 100%;
      text-align: center;
      font-size: 10px;
      color: #888;
    }
  </style>
</head>
<body>

  <!-- Header -->
  <div class="header">
    <img src="{{ public_path('images/bantayanlogo.png') }}" alt="Bantayan Logo">
    <div class="title">
      <h2>Municipality of Bantayan</h2>
      <small>Incident Report Management System</small>
    </div>
  </div>

   <!-- Description -->
  <div class="description">
    <strong>Official record of a citizen-submitted report.</strong><br>
    Information below is verified and stored in the municipal system.
  </div>

  <!-- Report Details -->
  <div class="section">
    <h3>Report Details</h3>
    <div class="label">Title:</div>
    <div class="value">{{ $report->title }}</div>

    <div class="label">Description:</div>
    <div class="value">{{ $report->description }}</div>

    <div class="label">Location:</div>
    <div class="value">{{ $report->location }}</div>

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

    <div class="label">Submitted At:</div>
    <div class="value">{{ $report->created_at->format('F d, Y h:i A') }}</div>
  </div>

  <!-- Reporter Info -->
  <div class="section">
    <h3>Reporter Information</h3>
    <div class="label">Name:</div>
    <div class="value">{{ $report->user->name ?? 'Anonymous' }}</div>

    <div class="label">Email:</div>
    <div class="value">{{ $report->user->email ?? 'N/A' }}</div>
  </div>

  <hr>

  <!-- Signature with aligned stamp -->
  <div class="signature">
    <img src="{{ public_path('images/bantayanlogo.png') }}" alt="Official Stamp" class="stamp">
    <div class="signature-text">
      Verified by:
      <div class="signature-line"></div>
      <div>Municipal Officer / Admin</div>
    </div>
  </div>
      </div>
  <!-- Footer -->
  <div class="footer">
    © {{ now()->year }} Bantayan Municipality • Generated on {{ now()->format('F d, Y h:i A') }}
  </div>

</body>
</html>
