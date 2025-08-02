<?php
namespace App\Services;
use App\Reports\ReportGenerationInterface;
use App\Models\Product;
class SalesReportService implements ReportGenerationInterface
{
    public function generateSalesReport(array $filters): array
    {
        // Logic to generate sales report based on filters
        return Product::all()->toArray(); // Example logic, replace with actual filtering logic
        
    }

    public function getMonthlySalesReport(array $filters): array
    {
        // Logic to generate monthly sales report based on filters
        return Product::whereMonth('created_at', now()->month)->get()->toArray(); // Example logic, replace with actual filtering logic
    }
    
}