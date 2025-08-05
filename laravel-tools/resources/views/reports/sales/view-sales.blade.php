@extends('welcome')
@section('title', 'Dashboard')

@section('content')


    <div class="separator-breadcrumb border-top"></div>
    <div class="topic mb-5">
        <h2 style="text-align:center;"> Sales Demo </h2>
    </div>


    <div class="card" style="box-shadow: 0.5px 0.5px ">
        <div class="card-body">
            <div class="row ml-3 ">
                <!-- Your dashboard content here -->
                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">Start Date</label>
                    <input class="form-control start_date" name="start_date" placeholder="yyyy-mm-dd" name="dp">
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">End Date</label>
                    <input class="form-control end_date" name="end_date" placeholder="yyyy-mm-dd" name="dp">
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">Filter</label>
                    <select class="form-control form-control-rounded">
                        <option selected>Custom Date</option>
                        <option>Weekly</option>
                        <option>Monthly</option>
                        <option>Yearly</option>
                    </select>
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">Status</label>
                    <select class="form-control form-control-rounded">
                        <option>Processing</option>
                        <option>Pending</option>
                        <option>Completed</option>
                    </select>
                </div>






            </div>

            <div class="row">
                <div class="col-md-12 form-group mb-4 mt-2 p-3 d-flex justify-content-center">
                    <button id="loadReportBtn" class="btn btn-primary ripple m-1 generate" type="button"> Generate
                    </button>
                </div>
            </div>
        </div>
    </div>



@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        flatpickr(".start_date", {
            dateFormat: "Y-m-d"
        });
        flatpickr(".end_date", {
            dateFormat: "Y-m-d"
        });
    </script>
    <script>
        // Custom JavaScript for this page
        $(document).ready(function() {

        });
    </script>

    <script>
        document.getElementById('loadReportBtn').addEventListener('click', function() {
            const csrfToken = {{ csrf_token() }}
            const startDate = document.querySelector('.start_date').value;
            const endDate = document.querySelector('.end_date').value;


            fetch('/sales', {
                    method: 'get',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        date: '2025-08-01',
                        type: 'daily',
                        reportType : 0
                    })
                })
                .then(res => res.json())
                .then(data => {
                    document.getElementById('reportResult').innerText = JSON.stringify(data, null, 2);
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    document.getElementById('reportResult').innerText = 'Error loading report.';
                });
        });
    </script>
@endpush
