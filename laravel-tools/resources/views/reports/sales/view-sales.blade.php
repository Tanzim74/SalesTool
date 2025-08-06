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
                    <select class="form-control form-control-rounded filter">
                        <option selected value="custom">Custom Date</option>
                        <option value="weekly">Weekly</option>
                        <option value="monthly">Monthly</option>
                        <option value="yearly">Yearly</option>
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

    <div class="row">
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
            dateFormat: "Y-m-d"
        });
        flatpickr(".end_date", {
            dateFormat: "Y-m-d"
        });
    </script>
    <script>
        // Custom JavaScript for this page
        $(document).ready(function() {
            $('.filter').on('change', function() {
                const selectedFilter = $(this).val();
                if (selectedFilter === 'custom') {
                    //    $('.start_date, .end_date').attr( 'placeholder','yyyy-mm-dd');
                    $('.start_date, .end_date').prop('disabled', false);
                } else {
                    $('.start_date, .end_date').prop('disabled', true);
                    $('.start_date, .end_date').val('yyyy-mm-dd');
                    $('.start_date, .end_date').attr('placeholder', 'yyyy-mm-dd');

                }
            });
        });
    </script>

    <script>
        document.getElementById('loadReportBtn').addEventListener('click', function() {
            const csrfToken = "{{ csrf_token() }}";
            const startDate = document.querySelector('.start_date').value;
            const endDate = document.querySelector('.end_date').value;
            const filterType = document.querySelector('.filter').value;
            const status = document.querySelector('.status').value;

            fetch('/getColumns', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken
                    },
                    body: JSON.stringify({
                        reportType: 0,
                        start_date: startDate,
                        end_date: endDate,
                        filter: filterType,
                        class: status
                    })
                })
                .then(res => res.json())
                .then(data => {
                    console.log('Report data:', data);
                    document.getElementById('attachment-table').innerHTML = data.html;

                    // Destroy existing DataTable if it exists
                    // if ($.fn.DataTable.isDataTable('.salesTable')) {
                    //     $('.salesTable').DataTable().destroy();
                    // }
                    

                    setTimeout(() => {
                        const columnDefs = data.columnKeys.map(key => ({
                            data: key,
                            
                        }));

                        $('.salesTable').DataTable({
                            processing: true,
                            serverSide: true,
                            ajax: { // Fix: Changed from 'ajax' to 'ajax'
                                url: '{{ route('sales.report.index') }}',
                                type: 'POST',
                                data: function(d) {
                                    d.start_date = startDate;
                                    d.end_date = endDate;
                                    d.filter = filterType;
                                    d.class = status;
                                    d._token = csrfToken;
                                }
                            },
                            columns: columnDefs,
                            searchable:false,
                        });
                    }, 10);
                })
                .catch(err => {
                    console.error('Fetch error:', err);
                    document.getElementById('reportResult').innerText = 'Error loading report.';
                });
        });
    </script>
@endpush
