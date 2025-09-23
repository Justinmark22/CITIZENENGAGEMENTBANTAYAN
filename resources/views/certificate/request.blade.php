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
  </style>
</head>
<body class="bg-gray-50">

  <div class="max-w-3xl mx-auto py-10 px-4">
    <div class="bg-white rounded-2xl shadow-xl p-8">

      <!-- ✅ Alerts -->
      @if(session('success'))
        <div class="mb-6 p-4 bg-green-50 border border-green-400 text-green-700 rounded-lg flex items-center gap-2">
          <i class="ph ph-check-circle text-green-500 text-xl"></i>
          <span>{{ session('success') }}</span>
        </div>
      @endif

      @if($errors->any())
        <div class="mb-6 p-4 bg-red-50 border border-red-400 text-red-700 rounded-lg">
          <div class="font-semibold flex items-center gap-2 mb-2">
            <i class="ph ph-warning text-red-500 text-xl"></i> There were some errors:
          </div>
          <ul class="list-disc list-inside text-sm">
            @foreach($errors->all() as $error)
              <li>{{ $error }}</li>
            @endforeach
          </ul>
        </div>
      @endif

      <!-- ✅ Step 1: Choose Certificate -->
      <div id="step-choose" class="fade-in">
        <h2 class="text-3xl font-extrabold text-green-700 text-center mb-2 flex items-center justify-center gap-2">
          <i class="ph ph-file-text text-green-600"></i> Request a Certificate
        </h2>
        <p class="text-gray-500 text-center mb-8">Select the type of certificate you need to proceed.</p>

        <div>
          <label class="block font-semibold mb-2 text-gray-700">Certificate Type</label>
          <select id="certificate_select" name="certificate_type" 
                  class="w-full rounded-lg border-gray-300 focus:ring-2 focus:ring-green-500 px-3 py-2 shadow-sm" required>
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

      <!-- ✅ Main Form -->
      <form id="form-template" class="hidden fade-in mt-6" method="POST" action="{{ route('certificate.submit') }}" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="certificate_type" id="hidden_certificate_type">

        <!-- Header -->
        <div class="mb-6">
          <h3 id="certificate-title" class="text-2xl font-bold text-green-700"></h3>
          <p class="text-gray-500 text-sm">Please fill out the form completely and accurately.</p>
        </div>

        <!-- Personal Info -->
        <div class="bg-gray-50 p-4 rounded-xl border mb-6">
          <div class="text-green-700 font-semibold mb-3 flex items-center gap-2">
            <i class="ph ph-user-list"></i> Personal Information
          </div>
          <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
              <label class="block mb-1 font-medium">Full Name <span class="text-red-500">*</span></label>
              <input type="text" name="full_name" 
                     class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm"
                     value="{{ Auth::user()->name ?? '' }}" required>
            </div>
            <div>
              <label class="block mb-1 font-medium">Birthdate <span class="text-red-500">*</span></label>
              <input type="date" name="birthdate" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required>
            </div>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
              <label class="block mb-1 font-medium">Gender <span class="text-red-500">*</span></label>
              <select name="gender" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required>
                <option value="">Select gender</option>
                <option>Male</option>
                <option>Female</option>
              </select>
            </div>
            <div>
              <label class="block mb-1 font-medium">Civil Status <span class="text-red-500">*</span></label>
              <select name="civil_status" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required>
                <option value="">Select status</option>
                <option>Single</option>
                <option>Married</option>
                <option>Widowed</option>
                <option>Separated</option>
              </select>
            </div>
          </div>

          <div class="mt-4">
            <label class="block mb-1 font-medium">Address <span class="text-red-500">*</span></label>
            <input type="text" name="address" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required>
          </div>

          <div class="mt-4">
            <label class="block mb-1 font-medium">Location <span class="text-red-500">*</span></label>
            <input type="text" name="location" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm"
                   value="{{ Auth::user()->location ?? '' }}" required>
          </div>

          <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-4">
            <div>
              <label class="block mb-1 font-medium">Contact Number</label>
              <input type="text" name="contact" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" value="{{ Auth::user()->contact ?? '' }}">
            </div>
            <div>
              <label class="block mb-1 font-medium">Email</label>
              <input type="email" name="email" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" value="{{ Auth::user()->email ?? '' }}">
            </div>
          </div>
        </div>

        <!-- Certificate Specific Fields -->
        <div class="bg-gray-50 p-4 rounded-xl border mb-6">
          <div id="specific-section-title" class="text-green-700 font-semibold mb-3"></div>
          <div id="certificate-specific-fields"></div>
        </div>

        <!-- Buttons -->
        <div class="flex justify-between mt-6">
          <button type="button" onclick="goBack()" class="px-5 py-2.5 rounded-lg border border-gray-300 hover:bg-gray-100 font-medium transition">
            ← Back
          </button>
          <button type="submit" class="px-6 py-2.5 bg-green-600 text-white rounded-lg shadow hover:bg-green-700 font-medium transition">
            Submit Request
          </button>
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
      business: { name: "Business Permit", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Business Name *</label><input type="text" name="business_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` },
      indigency: { name: "Indigency Certificate", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Purpose *</label><textarea name="purpose" rows="3" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></textarea></div>` },
      cedula: { name: "Community Tax Certificate (Cedula)", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Annual Income *</label><input type="number" name="annual_income" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` },
      birth: { name: "Birth Certificate", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Place of Birth *</label><input type="text" name="place_of_birth" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` },
      marriage: { name: "Marriage Certificate", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Spouse Full Name *</label><input type="text" name="spouse_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` },
      death: { name: "Death Certificate", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Deceased Full Name *</label><input type="text" name="deceased_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` },
      marriage_license: { name: "Marriage License", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Fiancé/Fiancée Full Name *</label><input type="text" name="fiance_name" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` },
      mayor_permit: { name: "Mayor’s Permit", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Purpose *</label><input type="text" name="mayor_permit_purpose" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` },
      tax_declaration: { name: "Tax Declaration / Property Clearance", fields: `<div class="mt-2"><label class="block mb-1 font-medium">Property Location *</label><input type="text" name="property_location" class="w-full rounded-lg border-gray-300 focus:ring-green-500 px-3 py-2 shadow-sm" required></div>` }
    };

    select.addEventListener('change', () => {
      const selected = certificates[select.value];
      if (selected) {
        stepChoose.classList.add('hidden');
        formTemplate.classList.remove('hidden');
        title.innerText = selected.name + " Request";
        specificTitle.innerText = selected.name + " Details";
        specificFields.innerHTML = selected.fields;
        document.getElementById('hidden_certificate_type').value = select.value;
      }
    });

    function goBack() {
      formTemplate.classList.add('hidden');
      stepChoose.classList.remove('hidden');
      select.value = "";
      document.getElementById('hidden_certificate_type').value = "";
    }
  </script>
</body>
</html>
