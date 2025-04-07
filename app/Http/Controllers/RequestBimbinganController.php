<?php

namespace App\Http\Controllers;

use App\Models\RequestBimbingan;
use App\Models\User; // Import User model
use Illuminate\Http\Request; // Use default Request for now
use Illuminate\Support\Facades\Auth; // To get logged-in user

// For validation, you can create Form Request classes later
// use App\Http\Requests\StoreRequestBimbinganRequest;
// use App\Http\Requests\UpdateRequestBimbinganRequest;

class RequestBimbinganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get requests only for the logged-in student, or all if admin?
        // Let's assume students see their own, admins see all (needs role check)
        $user = Auth::user();

        // Basic example: Student sees own, others (maybe admin) see all
        // Implement proper role checking (e.g., using Spatie Permissions or a 'role' column)
        if ($user->role === 'mahasiswa') { // Assuming a 'role' attribute exists on User model
             $requestBimbingans = RequestBimbingan::where('mahasiswa_id', $user->id)
                                               ->latest() // Order by newest first
                                               ->paginate(10); // Paginate results
        } else {
             // Assuming non-students (like admin/dosen) can see all
             $requestBimbingans = RequestBimbingan::with('mahasiswa') // Eager load student info
                                               ->latest()
                                               ->paginate(10);
        }


        return view('request_bimbingan.index', compact('requestBimbingans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Pass any necessary data (e.g., list of available timeslots if applicable)
        return view('request_bimbingan.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) // Replace Request with StoreRequestBimbinganRequest later
    {
        // --- Validation ---
        // It's highly recommended to use Form Request Validation
        // php artisan make:request StoreRequestBimbinganRequest
        // Then type-hint: store(StoreRequestBimbinganRequest $request)
        $validatedData = $request->validate([
            'no_kelompok' => 'nullable|string|max:20',
            'tanggal_bimbingan' => 'required|date|after_or_equal:today',
            'bimbingan_ke' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'jam_bimbingan' => 'required|date_format:H:i', // Validate time format HH:MM
            'tujuan_bimbingan' => 'required|string',
        ]);

        // --- Get Logged-in User Info ---
        $user = Auth::user();

        // Check if user is actually a student (add your own logic/role check)
        if (!$user || $user->role !== 'mahasiswa') {
             return redirect()->back()->with('error', 'Only students can create requests.');
        }

        // --- Prepare Data ---
        $dataToSave = $validatedData;
        $dataToSave['mahasiswa_id'] = $user->id;
        // Assuming these details are on the User model
        $dataToSave['nim'] = $user->nim;
        $dataToSave['nama'] = $user->name; // Adjust if name column is different
        $dataToSave['prodi'] = $user->prodi;
        $dataToSave['tahun_angkatan'] = $user->tahun_angkatan;


        // --- Create Record ---
        RequestBimbingan::create($dataToSave);

        // --- Redirect ---
        return redirect()->route('request-bimbingan.index')
                         ->with('success', 'Request Bimbingan created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(RequestBimbingan $requestBimbingan)
    {
        // Optional: Authorization - ensure the user can view this specific request
        // $this->authorize('view', $requestBimbingan); // Requires a Policy

        $requestBimbingan->load('mahasiswa'); // Load related student data if needed
        return view('request_bimbingan.show', compact('requestBimbingan'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(RequestBimbingan $requestBimbingan)
    {
         // Optional: Authorization - ensure the user can edit this request
         // $this->authorize('update', $requestBimbingan); // Requires a Policy

         // Example: Only allow editing by the student who created it
         if (Auth::id() !== $requestBimbingan->mahasiswa_id) {
            // Or if user is not admin... add that check too
            abort(403, 'Unauthorized action.');
         }

        return view('request_bimbingan.edit', compact('requestBimbingan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, RequestBimbingan $requestBimbingan) // Use UpdateRequestBimbinganRequest later
    {
        // Optional: Authorization
        // $this->authorize('update', $requestBimbingan);

        // Example: Only allow editing by the student who created it
        if (Auth::id() !== $requestBimbingan->mahasiswa_id) {
             // Or if user is not admin... add that check too
             abort(403, 'Unauthorized action.');
        }

        // --- Validation ---
        // php artisan make:request UpdateRequestBimbinganRequest
        $validatedData = $request->validate([
            'no_kelompok' => 'nullable|string|max:20',
            'tanggal_bimbingan' => 'required|date|after_or_equal:today',
            'bimbingan_ke' => 'required|integer|min:1',
            'lokasi' => 'required|string|max:255',
            'jam_bimbingan' => 'required|date_format:H:i',
            'tujuan_bimbingan' => 'required|string',
        ]);

        // --- Update Record ---
        // Don't update student details (nim, nama etc.) during an edit of the request itself
        $requestBimbingan->update($validatedData);

        // --- Redirect ---
        return redirect()->route('request-bimbingan.index')
                         ->with('success', 'Request Bimbingan updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(RequestBimbingan $requestBimbingan)
    {
        // Optional: Authorization
        // $this->authorize('delete', $requestBimbingan);

         // Example: Only allow deleting by the student who created it
         if (Auth::id() !== $requestBimbingan->mahasiswa_id) {
             // Or if user is not admin... add that check too
             abort(403, 'Unauthorized action.');
         }

        // --- Delete Record ---
        $requestBimbingan->delete();

        // --- Redirect ---
        return redirect()->route('request-bimbingan.index')
                         ->with('success', 'Request Bimbingan deleted successfully.');
    }
}
