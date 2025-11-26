<?php

namespace App\Repositories\Admin;

use App\Models\Admin;

interface AdminRepositoryInterface
{   
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
}
