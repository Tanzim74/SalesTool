@extends('welcome')
@section('title', 'Dashboard')

@section('content')
    
    <div class="separator-breadcrumb border-top"></div>
    <div class="topic mb-5">
        <h2 style="text-align:center;"> Sales Demo </h2>
    </div>

    <div class="alert-box alert alert-warning alert-dismissible fade hide" role="alert">
        <strong class="date-error" > </strong> 
        
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
        </button>
    </div>



    <div class="card" style="box-shadow: 0.5px 0.5px ">
        <div class="card-body">
            <div class="row ml-3 ">


                <!-- Your dashboard content here -->
                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">Start Date</label>
                    <input class="form-control start_date" name="start_date" placeholder="yyyy-mm-dd" name="dp">
                    <div class="text-danger small" id="error-start_date"></div>
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">End Date</label>
                    <input class="form-control end_date" name="end_date" placeholder="yyyy-mm-dd" name="dp">
                    <div class="text-danger small" id="error-end_date"></div>
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">Filter</label>
                    <select class="form-control form-control-rounded filter">
                        <option selected value="All">Daily</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="quarterly">Quarterly</option>
                        
                    </select>
                </div>

                <div class="col-md-3 form-group mb-3">
                    <label for="picker2">Status</label>
                    <select class="form-control form-control-rounded status">
                        <option value="0">Processing</option>
                        <option value="1">Pending</option>
                        <option value="2">Completed</option>
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

    <div class="row remove_sales_table d-none">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive" id="attachment-table">

                    </div>
                </div>
            </div>



        </div>
    </div>






@endsection

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>

    <script>
        flatpickr(".start_date", {
            dateFormat: "Y-m-d",

        });
        flatpickr(".end_date", {
            dateFormat: "Y-m-d"
        });
    </script>


    <script>
        $(document).ready(function () {

            if ($.fn.DataTable.isDataTable('.salesTable')) {
                $('.salesTable').DataTable().clear().destroy();
            }

            $('#loadReportBtn').click(function () {
                const csrfToken = "{{ csrf_token() }}";
                const startDate = document.querySelector('.start_date').value;
                const endDate = document.querySelector('.end_date').value;
                const filterType = document.querySelector('.filter').value;
                const status = document.querySelector('.status').value;
                document.getElementById('error-start_date').innerText = '';
                document.getElementById('error-end_date').innerText = '';
                $('.remove_sales_table').addClass('d-none');
                document.querySelectorAll('.form-control').forEach(input => input.classList.remove('is-invalid'));

                if ($.fn.DataTable.isDataTable('.table-responsive')) {
                    $('.salesTable').DataTable().destroy();
                }


                fetch('/getColumns', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': "{{ csrf_token() }}",
                    },
                    body: JSON.stringify({
                        reportType: 0,
                        start_date: startDate,
                        end_date: endDate,
                        filter: filterType,
                        class: status
                    })
                })
                    .then(async response => {
                        const data = await response.json();

                        if (!response.ok) {
                            if (response.status === 422 && data.type === 'date_validation') {
                                // Show validation errors

                                if (data.errors.start_date) {
                                    document.getElementById('error-start_date').innerText = data.errors.start_date[0];
                                    document.querySelector('.start_date').classList.add('is-invalid');
                                }
                                if (data.errors.end_date) {
                                    document.getElementById('error-end_date').innerText = data.errors.end_date[0];
                                    document.querySelector('.end_date').classList.add('is-invalid');
                                }



                            }
                            elseif(response.status === 422 && data.type === 'week_validation') {
                                document.getElementById('error-start_date').innerText = data.data;
                                document.querySelector('.start_date').classList.add('is-invalid');
                                document.getElementById('error-end_date').innerText = data.data;
                                document.querySelector('.end_date').classList.add('is-invalid');


                            }
                                    else if (response.status === 422 && data.type === 'month_validation') {
                                document.getElementById('error-start_date').innerText = data.data;
                                document.querySelector('.start_date').classList.add('is-invalid');
                                document.getElementById('error-end_date').innerText = data.data;
                                document.querySelector('.end_date').classList.add('is-invalid');
                                
                            }

                            throw new Error('Validation failed');

                        }

                        return data;
                    })
                    .then(data => {
                        console.log('Report data:', data);
                        document.getElementById('attachment-table').innerHTML = data.html;
                        $('.remove_sales_table').removeClass('d-none');
                        // Destroy existing DataTable if it exists
                        // if ($.fn.DataTable.isDataTable('.salesTable')) {
                        //     $('.salesTable').DataTable().destroy();
                        // }


                        setTimeout(() => {
                            const columnDefs = data.columnKeys.map(key => ({
                                data: key,

                            }));
                            console.log("loaded");
                            $('.salesTable').DataTable({
                                processing: true,
                                serverSide: true,
                                ajax: { // Fix: Changed from 'ajax' to 'ajax'
                                    url: '{{ route('sales.report.index') }}',
                                    type: 'POST',
                                    data: {
                                        reportType: 0,
                                        start_date: startDate,
                                        end_date: endDate,
                                        filter: filterType,
                                        class: status,
                                        _token: "{{ csrf_token() }}"
                                    }
                                },
                                columns: columnDefs,
                                searchable: false,
                                orderable: false,

                            });
                        }, 10);
                    })
                    .catch(err => {
                        console.error('Fetch error:', err);
                        document.getElementById('reportResult').innerText = 'Error loading report.';
                    });
            });

        });
    </script>
@endpush