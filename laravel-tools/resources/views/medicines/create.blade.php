@extends('welcome')
@section('title', 'Dashboard')

@section('content')
    <div class="separator-breadcrumb border-top"></div>
    <div class="topic mb-5">
        <h2 style="text-align:center;"> Create Medicine</h2>
    </div>
    <div class="card" style="box-shadow: 0.5px 0.5px ">
        <div class="card-body">
            <form action="{{ route('medicines.store') }}" method="POST">
                @csrf
                <div class="row">

                    <!-- Medicine Name -->
                    <div class="col-md-6 mb-3">
                        <label for="name" class="form-label">Medicine Name</label>
                        <input type="text" name="name" id="name" class="form-control"
                            placeholder="e.g., Napa 500 mg" required>
                    </div>

                    <!-- Generic Name -->
                    <div class="col-md-6 mb-3">
                        <label for="generic_name" class="form-label">Generic Name</label>
                        <input type="text" name="generic_name" id="generic_name" class="form-control"
                            placeholder="e.g., Paracetamol">
                    </div>

                    <!-- Manufacturer -->
                    <div class="col-md-6 mb-3">
                        <label for="manufacturer" class="form-label">Manufacturer</label>
                        <input type="text" name="manufacturer" id="manufacturer" class="form-control"
                            placeholder="e.g., Beximco Pharma">
                    </div>

                    <!-- Pack Type -->
                    <div class="col-md-6 mb-3">
                        <label for="pack_type" class="form-label">Pack Type</label>
                        <select name="pack_type" id="pack_type" class="form-control" required>
                            <option value="">Select Pack Type</option>
                            <option value="Strip">Strip</option>
                            <option value="Bottle">Bottle</option>
                            <option value="Box">Box</option>
                            <option value="Tube">Tube</option>
                            <option value="Vial">Vial</option>
                            <option value="Ampoule">Ampoule</option>
                            <option value="Sachet">Sachet</option>
                        </select>
                    </div>

                    <!-- Pack Size -->
                    <div class="col-md-6 mb-3">
                        <label for="pack_size" class="form-label">Pack Size</label>
                        <input type="number" name="pack_size" id="pack_size" class="form-control" placeholder="e.g., 10">
                    </div>

                    <!-- Unit -->
                    <div class="col-md-6 mb-3">
                        <label for="unit" class="form-label">Unit</label>
                        <select name="unit" id="unit" class="form-control">
                            <option value="Tablet">Tablet</option>
                            <option value="Capsule">Capsule</option>
                            <option value="ml">ml</option>
                            <option value="gm">gm</option>
                            <option value="Piece">Piece</option>
                        </select>
                    </div>

                    <!-- Unit Price -->
                    <div class="col-md-6 mb-3">
                        <label for="unit_price" class="form-label">Unit Price (৳)</label>
                        <input type="number" step="0.01" name="unit_price" id="unit_price" class="form-control"
                            placeholder="e.g., 2.5" required>
                    </div>

                    <!-- Pack Price -->
                    <div class="col-md-6 mb-3">
                        <label for="pack_price" class="form-label">Pack Price (৳)</label>
                        <input type="number" step="0.01" name="pack_price" id="pack_price" class="form-control"
                            placeholder="Auto Calculated" readonly>
                    </div>

                    <!-- Expiry Date -->
                    <div class="col-md-6 mb-3">
                        <label for="expiry_date" class="form-label">Expiry Date</label>
                        <input type="date" name="expiry_date" id="expiry_date" class="form-control">
                    </div>

                    <!-- Stock Quantity -->
                    <div class="col-md-6 mb-3">
                        <label for="stock_quantity" class="form-label">Stock Quantity</label>
                        <input type="number" name="stock_quantity" id="stock_quantity" class="form-control"
                            placeholder="e.g., 100">
                    </div>

                    <!-- Description -->
                    <div class="col-md-12 mb-3">
                        <label for="description" class="form-label">Description / Notes</label>
                        <textarea name="description" id="description" class="form-control" rows="2"
                            placeholder="e.g., 1 strip = 10 tablets"></textarea>
                    </div>

                    <!-- Submit Button -->
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary">Save Medicine</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
