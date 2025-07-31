<?php

namespace App\Reports;

interface ReportGenerationInterface{
     public function generateSalesReport(array $filters): array;
}

?>