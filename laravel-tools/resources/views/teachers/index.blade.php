@extends('dashboards.template')

@section('content')

<div class="container mt-5">

    <h2 class="mb-4 text-center font-weight-bold">Teacher List</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow-lg p-4">
        <div class="table-responsive">
            <table id="teachersTable" class="table table-bordered table-striped">
                <thead class="bg-dark text-white">
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Education</th>
                        <th>Phone</th>
                        <th>Account No</th>
                        <th>Age</th>
                        <th>National ID</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                    @foreach($teachers as $t)
                    <tr>
                        <td>{{ $t->id }}</td>
                        <td>{{ $t->user->name }}</td>
                        <td>{{ $t->email }}</td>
                        <td>{{ $t->education }}</td>
                        <td>{{ $t->phone_number }}</td>
                        <td>{{ $t->account_no }}</td>
                        <td>{{ $t->age }}</td>
                        <td>
                            <a href="{{ asset('storage/' . $t->national_id_image) }}" target="_blank" class="btn btn-sm btn-info">
                                View
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('teachers.edit', $t->id) }}" class="btn btn-sm btn-warning">Edit</a>

                            <form action="{{ route('teachers.destroy', $t->id) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')

                                <button class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?');">
                                    Delete
                                </button>
                            </form>

                        </td>
                    </tr>
                    @endforeach
                </tbody>

            </table>
        </div>
    </div>

</div>

@endsection

@section('scripts')
<script>
$(document).ready(function () {
    $('#teachersTable').DataTable();
});
</script>

@endsection

