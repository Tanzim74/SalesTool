<?php

namespace App\Http\Controllers\Category;

use App\Http\Controllers\Controller;
use App\Services\CategoryService;
use Illuminate\Http\Request;
use App\Models\Category;

class CategoryController extends Controller
{
    protected $service;
    
    public function __construct(CategoryService $service)
    {
        $this->service = $service;
    }
    public function index()
    {
        $all_categories = $this->service->getAllCategories();
        dd($all_categories);
    }


}
