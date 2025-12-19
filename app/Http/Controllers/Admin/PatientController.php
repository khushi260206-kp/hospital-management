<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePatientRequest;
use App\Services\PatientService;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    public function __construct(
        private PatientService $patientService
    ) {
        $this->middleware(['auth', 'role:admin,receptionist']);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'per_page']);
        $patients = $this->patientService->getAllPatients($filters);

        return view('admin.patients.index', compact('patients'));
    }

    public function create()
    {
        return view('admin.patients.create');
    }

    public function store(StorePatientRequest $request)
    {
        try {
            $this->patientService->createPatient($request->validated());
            return redirect()->route('admin.patients.index')
                ->with('success', 'Patient created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id)
    {
        $patient = $this->patientService->getPatientById($id);
        if (!$patient) {
            abort(404);
        }
        return view('admin.patients.show', compact('patient'));
    }

    public function edit(int $id)
    {
        $patient = $this->patientService->getPatientById($id);
        if (!$patient) {
            abort(404);
        }
        return view('admin.patients.edit', compact('patient'));
    }

    public function update(Request $request, int $id)
    {
        $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:users,email,' . \App\Models\Patient::find($id)?->user_id,
            'phone' => 'nullable|string|max:20',
            'blood_group' => 'nullable|string|max:10',
            'height' => 'nullable|numeric|min:0',
            'weight' => 'nullable|numeric|min:0',
            'allergies' => 'nullable|string',
            'medical_history' => 'nullable|string',
        ]);

        try {
            $this->patientService->updatePatient($id, $request->all());
            return redirect()->route('admin.patients.index')
                ->with('success', 'Patient updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->patientService->deletePatient($id);
            return redirect()->route('admin.patients.index')
                ->with('success', 'Patient deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

