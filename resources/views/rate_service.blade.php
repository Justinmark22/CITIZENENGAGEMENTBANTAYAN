<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Rate Our Service</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
  <div class="container py-5">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card">
          <div class="card-header text-center">
            <h4>Rate Our Service</h4>
          </div>
          <div class="card-body">
            <form action="{{ route('service.rate.submit') }}" method="POST">
              @csrf
              <!-- Location Field -->
              <div class="mb-3">
                <label for="location" class="form-label">Location</label>
                <input type="text" id="location" name="location" class="form-control" value="{{ Auth::user()->location ?? 'No Location' }}" readonly>
              </div>

              <div class="mb-3">
                <label for="service_rating" class="form-label">How would you rate our service?</label>
                <select name="service_rating" id="service_rating" class="form-select" required>
                  <option value="" disabled selected>Select rating</option>
                  <option value="1">1 - Poor</option>
                  <option value="2">2 - Fair</option>
                  <option value="3">3 - Good</option>
                  <option value="4">4 - Very Good</option>
                  <option value="5">5 - Excellent</option>
                </select>
              </div>

              <div class="mb-3">
                <label for="feedback" class="form-label">Additional Comments</label>
                <textarea name="feedback" id="feedback" class="form-control" rows="4" placeholder="Optional..." ></textarea>
              </div>

              <div class="mb-3">
                <button type="submit" class="btn btn-primary w-100">Submit Rating</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Bootstrap Bundle with Popper -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
