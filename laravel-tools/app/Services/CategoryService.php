<?php
namespace App\Services;
use app\Models\Category;
class CategoryService
{

    public function getAllCategories()
    {
         $getCategories  = Category::all(); 
           
         return $getCategories;
        
    }

    public function createCategory()
    {
        
    }

    public function updateCategory()
    {
        
    }

    public function deleteCategory()
    {
        
    }
}


?>