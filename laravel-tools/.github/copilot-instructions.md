# Copilot Instructions for Laravel Tools

## Project Overview
This is a Laravel-based reporting tool focused on sales and summary reports. The architecture leverages Laravel's service container, configuration-driven report types, and interface-based report generation. Key business logic is separated into services and actions, with controllers orchestrating data flow.

## Key Components & Data Flow
- **ReportManager (app/Services/ReportManager.php):** Central service for resolving report generation classes based on type. Uses config/report.php to map report types to service classes.
- **ReportGenerationInterface (app/Reports/ReportGenerationInterface.php):** All report services must implement this interface, ensuring consistent method signatures for generating reports.
- **SalesReportService (app/Services/SalesReportService.php):** Implements report logic for sales, including filtering and aggregation. Uses Eloquent and raw queries.
- **SalesSummary (app/Actions/SalesSummary/SalesSummary.php):** Provides summary calculations, e.g., total sales, using query builder.
- **ReportController (app/Http/Controllers/Report/ReportController.php):** Handles HTTP requests, resolves report instances, and returns JSON responses.
- **Blade Views (resources/views/reports/sales/view-sales.blade.php):** UI for report generation, with custom JS for date filtering and AJAX calls to endpoints.

## Configuration & Extensibility
- **config/report.php:** Maps report types (e.g., 'sales', 'summary') to their respective service classes. To add a new report type, update this config and implement the interface.
- **Service Resolution:** Use `$reportManager->getReportInstance($reportType)` to obtain the correct report service.

## Developer Workflows
- **Run the app:** Use `php artisan serve` (or configure with Laragon).
- **Testing:** Use `phpunit` for running tests in the `tests/` directory.
- **Add a report type:**
  1. Implement `ReportGenerationInterface` in a new service.
  2. Register the service in `config/report.php` under `drivers`.
  3. Update controller logic if needed.
- **AJAX endpoints:**
  - `/sales-report`, `/salesByDate`, `/get-sales-summary` (see `routes/web.php`).

## Patterns & Conventions
- **Dependency Injection:** All services/controllers use constructor injection for dependencies.
- **Config-driven logic:** Report type resolution is always via config, not hardcoded.
- **Interface enforcement:** All report services must implement `ReportGenerationInterface`.
- **Blade/JS integration:** Views use Blade for structure and push custom JS for interactivity.
- **Status/Filter UI:** Date pickers are enabled/disabled based on filter selection (see JS in view-sales.blade.php).

## External Dependencies
- **flatpickr:** Used for date selection in the UI.
- **jQuery:** Used for DOM manipulation and AJAX in Blade views.

## Example: Adding a New Report
- Create `app/Services/NewReportService.php` implementing `ReportGenerationInterface`.
- Add to `config/report.php`:
  ```php
  'drivers' => [
    'newreport' => App\Services\NewReportService::class,
    // ...
  ],
  ```
- Use in controller: `$reportManager->getReportInstance('newreport')`

## References
- `app/Services/ReportManager.php`
- `app/Reports/ReportGenerationInterface.php`
- `config/report.php`
- `app/Http/Controllers/Report/ReportController.php`
- `resources/views/reports/sales/view-sales.blade.php`

---
*Update this file as new report types, workflows, or conventions are introduced.*
