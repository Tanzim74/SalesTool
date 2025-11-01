<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Repositories\Admin\AdminRepositoryInterface;

class AdminController extends Controller
{
    protected $adminRepo;

    public function __construct(AdminRepositoryInterface $adminRepo)
    {
        $this->adminRepo = $adminRepo;
        $this->middleware('auth');
    }

    // Show all admins
    public function index()
    {
        $admins = $this->adminRepo->all();
        return view('dashboards.admin.index', compact('admins'));
    }

    // Show single admin
    public function show($id)
    {
        $admin = $this->adminRepo->find($id);
        return view('dashboards.admin.show', compact('admin'));
    }

    // Create admin
    public function create()
    {
        return view('dashboards.admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $data['password'] = bcrypt($data['password']);

        $this->adminRepo->create($data);

        return redirect()->route('dashboards.admin')->with('success', 'Admin created successfully.');
    }

    // Edit admin
    public function edit($id)
    {
        $admin = $this->adminRepo->find($id);
        return view('dashboards.admin.edit', compact('admin'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:admins,email,' . $id,
        ]);

        $this->adminRepo->update($id, $data);

        return redirect()->route('dashboards.admin')->with('success', 'Admin updated successfully.');
    }

    // Delete admin
    public function destroy($id)
    {
        $this->adminRepo->delete($id);
        return redirect()->route('dashboards.admin')->with('success', 'Admin deleted successfully.');
    }
}
