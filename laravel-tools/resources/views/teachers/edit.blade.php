@extends('dashboards.template')

@section('content')
    <div class="container mt-4">

        <div class="card shadow-lg p-4" 
             style="max-width: 650px; margin: auto; border-radius: 14px; border: none;">

            <h2 class="text-center font-weight-bold text-primary mb-1">Edit Teacher</h2>
            <p class="text-center text-muted mb-4">Update teacher information below.</p>

            <form action="{{ route('teachers.update', $teacher->id) }}" 
                  method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                {{-- Full Name --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">Full Name</label>
                    <input type="text" name="name"
                           class="form-control @error('name') is-invalid @enderror"
                           value="{{ old('name', $teacher->user->name) }}">
                    @error('name')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Email --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">Email</label>
                    <input type="email" name="email"
                           class="form-control @error('email') is-invalid @enderror"
                           value="{{ old('email', $teacher->user->email) }}">
                    @error('email')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- National ID --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">National ID Image</label>
                    <input type="file" name="national_id"
                           class="form-control @error('national_id') is-invalid @enderror">

                    @if ($teacher->national_id_image)
                        <div class="mt-2">
                            <small class="text-muted">Current Image:</small><br>
                            <img src="{{ asset('storage/' . $teacher->national_id_image) }}"
                                 alt="National ID"
                                 style="max-width: 200px; border-radius: 8px; margin-top: 5px; box-shadow: 0 2px 6px rgba(0,0,0,0.15);">
                        </div>
                    @endif

                    @error('national_id')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Age --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">Age</label>
                    <input type="number" name="age"
                           class="form-control @error('age') is-invalid @enderror"
                           value="{{ old('age', $teacher->age) }}">
                    @error('age')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Phone --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">Phone Number</label>
                    <input type="text" name="phone_number"
                           class="form-control @error('phone_number') is-invalid @enderror"
                           value="{{ old('phone_number', $teacher->phone_number) }}">
                    @error('phone_number')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Education --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">Education</label>
                    <select name="education"
                            class="form-control @error('education') is-invalid @enderror">
                        <option value="">Select Education</option>
                        <option value="SSC" {{ old('education', $teacher->education) == 'SSC' ? 'selected' : '' }}>SSC</option>
                        <option value="HSC" {{ old('education', $teacher->education) == 'HSC' ? 'selected' : '' }}>HSC</option>
                        <option value="Bachelors" {{ old('education', $teacher->education) == 'Bachelors' ? 'selected' : '' }}>Bachelors</option>
                        <option value="Masters" {{ old('education', $teacher->education) == 'Masters' ? 'selected' : '' }}>Masters</option>
                    </select>
                    @error('education')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Last Qualification --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">Last Qualification</label>
                    <input type="text" name="last_qualification"
                           class="form-control @error('last_qualification') is-invalid @enderror"
                           value="{{ old('last_qualification', $teacher->last_qualification) }}">
                    @error('last_qualification')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                {{-- Account Number --}}
                <div class="form-group mb-3">
                    <label class="font-weight-600">Account Number (5 digits)</label>
                    <input type="text" name="account_no" maxlength="5" pattern="\d{5}"
                           class="form-control @error('account_no') is-invalid @enderror"
                           value="{{ old('account_no', $teacher->account_no) }}">
                    @error('account_no')
                        <small class="text-danger">{{ $message }}</small>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary btn-block mt-3 py-2 font-weight-bold">
                    Update Teacher
                </button>

            </form>

        </div>

    </div>
@endsection
