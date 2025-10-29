<?php

namespace App\Repositories;

use App\Models\Medicine;
use App\Models\Company;
class MedicineRepository
{
    public function getAll()
    {
        return Medicine::latest()->paginate(20);
    }

    public function create(array $data)
    {
        return Medicine::create($data);
    }

    public function find($id)
    {
        return Medicine::findOrFail($id);
    }

    public function update(Medicine $medicine, array $data)
    {
        $medicine->update($data);
        return $medicine;
    }

    public function delete(Medicine $medicine)
    {
        return $medicine->delete();
    }
    public function getCompanies(){
        return Company::get();
    }
}
