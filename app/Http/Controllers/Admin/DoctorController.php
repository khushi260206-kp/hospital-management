<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDoctorRequest;
use App\Http\Requests\UpdateDoctorRequest;
use App\Services\DoctorService;
use App\Services\DepartmentService;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    public function __construct(
        private DoctorService $doctorService,
        private DepartmentService $departmentService
    ) {
        $this->middleware(['auth', 'role:admin']);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['search', 'department_id', 'availability', 'per_page']);
        $doctors = $this->doctorService->getAllDoctors($filters);
        $departments = $this->departmentService->getActiveDepartments();

        return view('admin.doctors.index', compact('doctors', 'departments'));
    }

    public function create()
    {
        $departments = $this->departmentService->getActiveDepartments();
        return view('admin.doctors.create', compact('departments'));
    }

    public function store(StoreDoctorRequest $request)
    {
        try {
            $this->doctorService->createDoctor($request->validated());
            return redirect()->route('admin.doctors.index')
                ->with('success', 'Doctor created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id)
    {
        $doctor = $this->doctorService->getDoctorById($id);
        if (!$doctor) {
            abort(404);
        }
        return view('admin.doctors.show', compact('doctor'));
    }

    public function edit(int $id)
    {
        $doctor = $this->doctorService->getDoctorById($id);
        if (!$doctor) {
            abort(404);
        }
        $departments = $this->departmentService->getActiveDepartments();
        return view('admin.doctors.edit', compact('doctor', 'departments'));
    }

    public function update(UpdateDoctorRequest $request, int $id)
    {
        try {
            $this->doctorService->updateDoctor($id, $request->validated());
            return redirect()->route('admin.doctors.index')
                ->with('success', 'Doctor updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->doctorService->deleteDoctor($id);
            return redirect()->route('admin.doctors.index')
                ->with('success', 'Doctor deleted successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

