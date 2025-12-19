<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBillRequest;
use App\Services\BillService;
use App\Services\PatientService;
use App\Services\AppointmentService;
use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function __construct(
        private BillService $billService,
        private PatientService $patientService,
        private AppointmentService $appointmentService
    ) {
        $this->middleware(['auth', 'role:admin,receptionist']);
    }

    public function index(Request $request)
    {
        $filters = $request->only(['patient_id', 'payment_status', 'bill_type', 'date_from', 'date_to', 'per_page']);
        $bills = $this->billService->getAllBills($filters);
        $patients = $this->patientService->getAllPatients(['per_page' => 100])->items();

        return view('billing.index', compact('bills', 'patients'));
    }

    public function create(Request $request)
    {
        $patients = $this->patientService->getAllPatients(['per_page' => 100])->items();
        $appointmentId = $request->get('appointment_id');
        $appointment = $appointmentId ? $this->appointmentService->getAppointmentById($appointmentId) : null;

        return view('billing.create', compact('patients', 'appointment'));
    }

    public function store(StoreBillRequest $request)
    {
        try {
            $bill = $this->billService->createBill($request->validated());
            return redirect()->route('billing.show', $bill->id)
                ->with('success', 'Bill created successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()])->withInput();
        }
    }

    public function show(int $id)
    {
        $bill = $this->billService->getBillById($id);
        if (!$bill) {
            abort(404);
        }
        return view('billing.show', compact('bill'));
    }

    public function updatePaymentStatus(Request $request, int $id)
    {
        $request->validate([
            'payment_status' => 'required|in:pending,partial,paid',
            'payment_method' => 'nullable|in:cash,card,online,insurance',
        ]);

        try {
            $this->billService->updatePaymentStatus(
                $id,
                $request->payment_status,
                $request->payment_method
            );
            return redirect()->route('billing.show', $id)
                ->with('success', 'Payment status updated successfully.');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}

