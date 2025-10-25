<?php

namespace App\Http\Controllers;

use App\Models\Medicine;
use App\Services\MedicineService;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    protected $medicineService;

    public function __construct(MedicineService $medicineService)
    {
        $this->medicineService = $medicineService;
    }

    public function index()
    {
        $medicines = $this->medicineService->listAll();
        return view('medicines.index', compact('medicines'));
    }

    public function create()
    {
        return view('medicines.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'pack_type' => 'required|string|max:50',
            'pack_size' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'unit_price' => 'required|numeric',
            'pack_price' => 'nullable|numeric',
            'expiry_date' => 'nullable|date',
            'stock_quantity' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $this->medicineService->create($data);

        return redirect()->route('medicines.index')->with('success', 'Medicine added successfully!');
    }

    public function edit(Medicine $medicine)
    {
        return view('medicines.edit', compact('medicine'));
    }

    public function update(Request $request, Medicine $medicine)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'generic_name' => 'nullable|string|max:255',
            'manufacturer' => 'nullable|string|max:255',
            'pack_type' => 'required|string|max:50',
            'pack_size' => 'nullable|integer',
            'unit' => 'nullable|string|max:50',
            'unit_price' => 'required|numeric',
            'pack_price' => 'nullable|numeric',
            'expiry_date' => 'nullable|date',
            'stock_quantity' => 'nullable|integer',
            'description' => 'nullable|string',
        ]);

        $this->medicineService->update($medicine, $data);

        return redirect()->route('medicines.index')->with('success', 'Medicine updated successfully!');
    }

    public function destroy(Medicine $medicine)
    {
        $this->medicineService->delete($medicine);
        return redirect()->route('medicines.index')->with('success', 'Medicine deleted successfully!');
    }
}
