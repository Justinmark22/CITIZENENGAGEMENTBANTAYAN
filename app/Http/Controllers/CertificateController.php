<?php

namespace App\Http\Controllers;

use App\Models\CertificateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CertificateController extends Controller
{
    /**
     * Show all certificate requests (for admin or user)
     */
    public function index()
    {
        $requests = CertificateRequest::latest()->get();
        return view('certificates.index', compact('requests'));
    }

    /**
     * Show the request form (your HTML Blade)
     */
    public function create()
    {
        return view('certificates.create');
    }

    /**
     * Store a new certificate request
     */
public function store(Request $request)
{
    // 🔍 Debug incoming request data
    \Log::info('📥 Incoming Certificate Request:', $request->all());

    // Merge location into address if address is not present
    if (!$request->has('address')) {
        \Log::warning('⚠️ Address not provided, using location as address.');
        $request->merge(['address' => $request->location]);
    }

    try {
        // 🔍 Debug before validation
        \Log::info('✅ Data before validation:', $request->all());

        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'birthdate' => 'required|date',
            'gender' => 'required',
            'civil_status' => 'required',
            'address' => 'required|string|max:255',
            'location' => 'required|string|max:255',
            'certificate_type' => 'required|string'
        ]);

        \Log::info('✅ Validation Passed:', $validated);

        $extraFields = $request->except([
            '_token', 'full_name', 'birthdate', 'gender', 'civil_status',
            'address', 'location', 'contact', 'email', 'certificate_type'
        ]);

        \Log::info('📦 Extra Fields Captured:', $extraFields);

        $certificate = CertificateRequest::create([
            'user_id' => Auth::id(),
            'full_name' => $request->full_name,
            'birthdate' => $request->birthdate,
            'gender' => $request->gender,
            'civil_status' => $request->civil_status,
            'address' => $request->address,
            'location' => $request->location,
            'contact' => $request->contact,
            'email' => $request->email,
            'certificate_type' => $request->certificate_type,
            'certificate_data' => $extraFields,
            'status' => 'pending'
        ]);

        \Log::info('✅ Certificate Created Successfully:', $certificate->toArray());

        return redirect()->back()->with('success', 'Certificate request submitted successfully!');

    } catch (\Illuminate\Validation\ValidationException $e) {
        // 🔍 Debug validation errors
        \Log::error('❌ Validation Failed:', $e->errors());
        dd('Validation Error:', $e->errors());
    } catch (\Exception $e) {
        // 🔍 Debug general errors
        \Log::error('❌ Error Saving Certificate:', [$e->getMessage()]);
        dd('Error Saving Certificate:', $e->getMessage());
    }
}

    /**
     * Show a single request
     */
    public function showRequestForm()
{
    return view('certificate.request'); // your form Blade
}


    /**
     * Approve a certificate request (admin)
     */
    public function approve($id)
    {
        $req = CertificateRequest::findOrFail($id);
        $req->update(['status' => 'approved']);

        return back()->with('success', 'Certificate request approved!');
    }

    /**
     * Reject a certificate request (admin)
     */
    public function reject($id)
    {
        $req = CertificateRequest::findOrFail($id);
        $req->update(['status' => 'rejected']);

        return back()->with('error', 'Certificate request rejected.');
    }

    /**
     * Delete a certificate request
     */
    public function destroy($id)
    {
        $req = CertificateRequest::findOrFail($id);
        $req->delete();

        return back()->with('success', 'Certificate request deleted successfully.');
    }
}
