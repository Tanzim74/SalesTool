@extends('dashboards.template')
@section('content')
    <style>
        .register-container {
            max-width: 650px;
            margin: 30px auto;
        }

        .register-card {
            padding: 35px 40px;
            border-radius: 12px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .form-header-title {
            font-size: 26px;
            font-weight: 700;
            text-align: center;
            margin-bottom: 8px;
            color: #2f4f6f;
        }

        .form-header-subtitle {
            font-size: 14px;
            text-align: center;
            color: #6c757d;
            margin-bottom: 25px;
        }

        @media(max-width: 576px) {
            .register-card {
                padding: 25px;
            }

            .form-header-title {
                font-size: 22px;
            }
        }
    </style>

    <div class="register-container">
        <div class="card register-card">

            <!-- Header -->
            <h2 class="form-header-title">Teacher Registration</h2>
            <p class="form-header-subtitle">
                Please fill in the details below to create a teacher account.
            </p>

            <form action="{{ route('teachers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <!-- Personal Info -->
                <h5 class="mb-3 mt-4 font-weight-bold text-primary">Personal Information</h5>

                {{-- Name --}}
                <div class="form-group">
                    <label class="font-weight-600">Full Name</label>
                    <input type="text" name="name" class="form-control" placeholder="Enter full name" required>
                </div>
                @error('name')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <div class="form-group">
                    <label class="font-weight-600">Email</label>
                    <input type="email" name="email" class="form-control" placeholder="Enter email" required>
                </div>
                @error('email')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- National ID Image --}}
                <div class="form-group">
                    <label class="font-weight-600">National ID Image</label>
                    <input type="file" name="national_id" class="form-control" accept="image/*" required>
                </div>

                @error('national_id')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- Age --}}
                <div class="form-group">
                    <label class="font-weight-600">Age</label>
                    <input type="number" name="age" class="form-control" min="18" max="80" required>
                </div>
                @error('age')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- Phone Number --}}
                <div class="form-group">
                    <label class="font-weight-600">Phone Number</label>
                    <input type="text" name="phone_number" class="form-control" placeholder="01XXXXXXXXX" required>
                </div>
                @error('phone_number')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <!-- Education Section -->
                <h5 class="mb-3 mt-4 font-weight-bold text-primary">Educational Background</h5>

                {{-- Education --}}
                <div class="form-group">
                    <label class="font-weight-600">Education Level</label>
                    <select name="education" class="form-control" required>
                        <option value="">Select Education</option>
                        <option value="SSC">SSC</option>
                        <option value="HSC">HSC</option>
                        <option value="Bachelors">Bachelors</option>
                        <option value="Masters">Masters</option>
                    </select>
                </div>
                @error('education')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- Last Qualification --}}
                <div class="form-group">
                    <label class="font-weight-600">Last Qualification</label>
                    <input type="text" name="last_qualification" class="form-control"
                        placeholder="e.g. B.Sc in Mathematics" required>
                </div>
                @error('last_qualification')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                <!-- Login Information -->
                <h5 class="mb-3 mt-4 font-weight-bold text-primary">Account Information</h5>

                {{-- Account No --}}
                <div class="form-group">
                    <label class="font-weight-600">Account No. (5 digits)</label>
                    <input type="text" name="account_no" maxlength="5" pattern="\d{5}" class="form-control"
                        placeholder="12345" required>
                </div>
                @error('account_no')
                    <small class="text-danger">{{ $message }}</small>
                @enderror

                {{-- Password --}}
                <div class="form-group">
                    <label class="font-weight-600">Password (Min 8 characters)</label>
                    <input type="password" name="password" minlength="8" class="form-control" required>
                </div>

                @error('password')
                    <small class="text-danger">{{ $message }}</small>
                @enderror
                <!-- Submit -->
                <button type="submit" class="btn btn-primary btn-block font-weight-bold mt-4 py-2"
                    style="font-size: 16px;">
                    Register Teacher
                </button>

            </form>
        </div>
    </div>
@endsection
