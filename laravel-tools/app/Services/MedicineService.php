<?php

namespace App\Services;

use App\Repositories\MedicineRepository;

class MedicineService
{
    protected $medicineRepository;

    public function __construct(MedicineRepository $medicineRepository)
    {
        $this->medicineRepository = $medicineRepository;
    }

    public function listAll()
    {
        return $this->medicineRepository->getAll();
    }

    public function create(array $data)
    {
        $data['pack_price'] = $data['pack_price'] ?? $data['unit_price'] * ($data['pack_size'] ?? 1);
        return $this->medicineRepository->create($data);
    }

    public function update($medicine, array $data)
    {
        $data['pack_price'] = $data['pack_price'] ?? $data['unit_price'] * ($data['pack_size'] ?? 1);
        return $this->medicineRepository->update($medicine, $data);
    }

    public function delete($medicine)
    {
        return $this->medicineRepository->delete($medicine);
    }
}
