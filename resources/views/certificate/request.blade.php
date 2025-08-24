<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Request a Certificate</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/@phosphor-icons/web"></script>
  <style>
    .fade-in { animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px);} to { opacity: 1; transform: translateY(0);} }
    .hidden { display: none; }
  </style>
</head>
<body class="bg-gray-50">
  <div class="max-w-2xl mx-auto py-10 px-4">
    <div class="bg-white rounded-2xl shadow-lg p-6">
@if(session('success'))
    <div class="mb-4 p-3 bg-green-100 border border-green-400 text-green-700 rounded-lg">
        {{ session('success') }}
    </div>
@endif

@if($errors->any())
    <div class="mb-4 p-3 bg-red-100 border border-red-400 text-red-700 rounded-lg">
        <strong>There were some errors:</strong>
        <ul class="mt-2 list-disc list-inside">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

      <!-- Step 1: Choose Certificate -->
      <div id="step-choose" class="fade-in">
        <h2 class="text-2xl font-bold text-green-600 text-center mb-2 flex items-center justify-center gap-2">
          <i class="ph ph-file-text text-green-500"></i> Request a Certificate
        </h2>
        <p class="text-gray-500 text-center mb-6">Select the type of certificate you need to proceed.</p>

        <div class="mb-4">
          <label class="block font-semibold mb-1 text-gray-700">Certificate Type</label>
          <select id="certificate_select" name="certificate_type" class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500" required>
            <option value="">Choose a certificate...</option>
            <option value="business">Business Permit</option>
            <option value="indigency">Indigency Certificate</option>
            <option value="cedula">Community Tax Certificate (Cedula)</option>
            <option value="birth">Birth Certificate</option>
            <option value="marriage">Marriage Certificate</option>
            <option value="death">Death Certificate</option>
            <option value="marriage_license">Marriage License</option>
            <option value="mayor_permit">Mayor’s Permit</option>
            <option value="tax_declaration">Tax Declaration / Property Clearance</option>
          </select>
        </div>
      </div>

      <!-- Form -->
<form id="form-template" class="hidden fade-in" method="POST" action="{{ route('certificate.submit') }}">
    @csrf

    <!-- ✅ Hidden input for certificate type -->
    <input type="hidden" name="certificate_type" id="hidden_certificate_type">

    <h3 id="certificate-title" class="text-xl font-bold text-green-600 mb-2"></h3>
    <p class="text-gray-500 mb-4">Please fill out the form completely and accurately.</p>

    <!-- Personal Info -->
    <div class="text-blue-600 font-semibold mb-2 flex items-center gap-2">
        <i class="ph ph-user-list"></i> Personal Information
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <label class="block mb-1 font-medium">Full Name <span class="text-red-500">*</span></label>
            <input type="text" name="full_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500" value="{{ Auth::user()->name ?? '' }}" required>
        </div>
        <div>
            <label class="block mb-1 font-medium">Birthdate <span class="text-red-500">*</span></label>
            <input type="date" name="birthdate" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block mb-1 font-medium">Gender <span class="text-red-500">*</span></label>
            <select name="gender" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required>
                <option value="">Select gender</option>
                <option value="Male">Male</option>
                <option value="Female">Female</option>
            </select>
        </div>
        <div>
            <label class="block mb-1 font-medium">Civil Status <span class="text-red-500">*</span></label>
            <select name="civil_status" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required>
                <option value="">Select status</option>
                <option value="Single">Single</option>
                <option value="Married">Married</option>
                <option value="Widowed">Widowed</option>
                <option value="Separated">Separated</option>
            </select>
        </div>
    </div>

    <div class="mt-4">
        <label class="block mb-1 font-medium">Address <span class="text-red-500">*</span></label>
        <input type="text" name="address" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required>
    </div>

    <!-- Location -->
    <div class="mt-4">
        <label class="block mb-1 font-medium">Location <span class="text-red-500">*</span></label>
        <input type="text" name="location" class="w-full rounded-lg border-gray-300 focus:ring-green-500" value="{{ Auth::user()->location ?? '' }}" required>
    </div>

    <!-- Contact & Email -->
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
        <div>
            <label class="block mb-1 font-medium">Contact Number</label>
            <input type="text" name="contact" class="w-full rounded-lg border-gray-300 focus:ring-green-500" value="{{ Auth::user()->contact ?? '' }}">
        </div>
        <div>
            <label class="block mb-1 font-medium">Email</label>
            <input type="email" name="email" class="w-full rounded-lg border-gray-300 focus:ring-green-500" value="{{ Auth::user()->email ?? '' }}">
        </div>
    </div>

        <!-- Certificate-Specific -->
        <div id="specific-section-title" class="text-blue-600 font-semibold mt-6 mb-2"></div>
        <div id="certificate-specific-fields"></div>

        <div class="flex justify-between mt-6">
          <button type="button" onclick="goBack()" class="px-4 py-2 rounded-lg border border-gray-300 hover:bg-gray-100">← Back</button>
          <button type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700">Submit Request</button>
        </div>
      </form>
    </div>
  </div>

  <script>
    const select = document.getElementById('certificate_select');
    const stepChoose = document.getElementById('step-choose');
    const formTemplate = document.getElementById('form-template');
    const title = document.getElementById('certificate-title');
    const specificTitle = document.getElementById('specific-section-title');
    const specificFields = document.getElementById('certificate-specific-fields');

    const certificates = {
      business: {
        name: "Business Permit",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Business Name *</label><input type="text" name="business_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Business Address *</label><input type="text" name="business_address" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Nature of Business *</label><input type="text" name="nature_of_business" class="w-full rounded-lg border-gray-300 focus:ring-green-500" placeholder="e.g., Retail, Food Service" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Business Type *</label>
            <select name="business_type" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required>
              <option disabled selected>Select Type</option>
              <option>Sole Proprietorship</option>
              <option>Partnership</option>
              <option>Corporation</option>
              <option>Cooperative</option>
            </select>
          </div>
          <div class="mt-2"><label class="block mb-1 font-medium">Owner's Full Name *</label><input type="text" name="owner_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Owner's Address *</label><input type="text" name="owner_address" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Owner's Contact Number</label><input type="text" name="owner_contact" class="w-full rounded-lg border-gray-300 focus:ring-green-500"></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Tax Identification Number (TIN) *</label><input type="text" name="tin" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Business Registration No. (DTI/SEC/CDA) *</label><input type="text" name="registration_number" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Date of Business Start *</label><input type="date" name="start_date" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Number of Employees</label><input type="number" name="employees_count" min="0" class="w-full rounded-lg border-gray-300 focus:ring-green-500"></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Capital Investment (₱) *</label><input type="number" name="capital_investment" min="0" step="0.01" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Business Area (sqm)</label><input type="number" name="business_area" min="0" class="w-full rounded-lg border-gray-300 focus:ring-green-500"></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Upload Business Documents</label><input type="file" name="business_docs" class="w-full rounded-lg border-gray-300 focus:ring-green-500"><small class="text-gray-500">Upload DTI/SEC/CDA registration, previous permit, etc.</small></div>
        `
      },

      indigency: {
        name: "Indigency Certificate",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Purpose *</label><textarea name="purpose" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></textarea></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Monthly Income *</label><input type="number" name="monthly_income" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
        `
      },

      cedula: {
        name: "Community Tax Certificate (Cedula)",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Annual Income *</label><input type="number" name="annual_income" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Property Value</label><input type="number" name="property_value" class="w-full rounded-lg border-gray-300 focus:ring-green-500"></div>
        `
      },

      birth: {
        name: "Birth Certificate",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Place of Birth *</label><input type="text" name="place_of_birth" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Father's Full Name</label><input type="text" name="father_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500"></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Mother's Full Name</label><input type="text" name="mother_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500"></div>
        `
      },

      marriage: {
        name: "Marriage Certificate",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Spouse Full Name *</label><input type="text" name="spouse_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Date of Marriage *</label><input type="date" name="marriage_date" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
        `
      },

      death: {
        name: "Death Certificate",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Deceased Full Name *</label><input type="text" name="deceased_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Date of Death *</label><input type="date" name="death_date" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
        `
      },

      marriage_license: {
        name: "Marriage License",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Fiancé/Fiancée Full Name *</label><input type="text" name="fiance_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Proposed Wedding Date</label><input type="date" name="wedding_date" class="w-full rounded-lg border-gray-300 focus:ring-green-500"></div>
        `
      },

      mayor_permit: {
        name: "Mayor’s Permit",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Purpose / Business Name *</label><input type="text" name="mayor_permit_purpose" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
        `
      },

      tax_declaration: {
        name: "Tax Declaration / Property Clearance",
        fields: `
          <div class="mt-2"><label class="block mb-1 font-medium">Property Location *</label><input type="text" name="property_location" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
          <div class="mt-2"><label class="block mb-1 font-medium">Tax Declaration No. *</label><input type="text" name="tax_declaration_no" class="w-full rounded-lg border-gray-300 focus:ring-green-500" required></div>
        `
      }
    };

  select.addEventListener('change', () => {
  const selected = certificates[select.value];
  if (selected) {
    stepChoose.classList.add('hidden');
    formTemplate.classList.remove('hidden');
    title.innerText = selected.name + " Request";
    specificTitle.innerText = selected.name + " Details";
    specificFields.innerHTML = selected.fields;

    // ✅ Save the selected value to hidden input
    document.getElementById('hidden_certificate_type').value = select.value;
  }
});

function goBack() {
  formTemplate.classList.add('hidden');
  stepChoose.classList.remove('hidden');
  select.value = "";

  // ✅ Clear the hidden input as well
  document.getElementById('hidden_certificate_type').value = "";
}


  </script>
</body>
</html>
