@extends('master')

@section('title')
    Cập nhật nhân viên
@endsection

@section('content')
    <h1 class="text-center">Cập nhật nhân viên: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-success">
            Thao tác thành công
        </div>
    @endif 

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-danger">
            Thao tác thất bại

            {{session('error')}}
        </div>
    @endif 

    <div class="container">
        <form action="{{ route('employees.update', $employee) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3 row">
                <label for="first_name" class="col-4 col-form-label">First Name</label>
                <div class="col-8">
                    <input type="text" value="{{ $employee->first_name }}" class="form-control" name="first_name" id="first_name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="last_name" class="col-4 col-form-label">Last Name</label>
                <div class="col-8">
                    <input type="text" value="{{ $employee->last_name }}" class="form-control" name="last_name" id="last_name" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="email" class="col-4 col-form-label">Email</label>
                <div class="col-8">
                    <input type="email" value="{{ $employee->email }}" class="form-control" name="email" id="email" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="phone" class="col-4 col-form-label">Phone</label>
                <div class="col-8">
                    <input type="tel" value="{{ $employee->phone }}" class="form-control" name="phone" id="phone" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="date_of_birth" class="col-4 col-form-label">Date of Birth</label>
                <div class="col-8">
                    <input type="date" value="{{ $employee->date_of_birth }}" class="form-control" name="date_of_birth" id="date_of_birth" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="hire_date" class="col-4 col-form-label">Hire date</label>
                <div class="col-8">
                    <input type="datetime-local" value="{{ $employee->hire_date }}" class="form-control" name="hire_date" id="hire_date" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="is_active" class="col-4 col-form-label">Active</label>
                <div class="col-8">
                    <input type="checkbox" @checked($employee->is_active) value="1" class="form-checkbox" name="is_active" id="is_active" />
                </div>
            </div>

            <div class="mb-3 row">
                <label for="address" class="col-4 col-form-label">Address</label>
                <div class="col-8">
                    <input type="text" value="{{ $employee->address }}" class="form-control" name="address" id="address" />
                </div>
            </div>     

            <div class="mb-3 row">
                <label for="manager_id" class="col-4 col-form-label">Manger name</label>
                <div class="col-8">
                    <select class="form-select" name="manager_id">
                        @foreach ($managers as $manager)
                            @if ($employee->manager_id === $manager->id)
                                <option selected value="{{ $manager->id }}">{{ $manager->manager_name }}</option>
                            @else
                                <option value="{{ $manager->id }}">{{ $manager->manager_name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="mb-3 row">
                <label for="department_id" class="col-4 col-form-label">Department</label>
                <div class="col-8">
                    <select class="form-select" name="department_id">
                        @foreach ($departments as $department)
                            @if ($department->id === $employee->department_id)
                                <option selected value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @else
                                <option value="{{ $department->id }}">{{ $department->department_name }}</option>
                            @endif

                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="mb-3 row">
                <label for="profile_picture" class="col-4 col-form-label">Profile picture</label>
                <div class="col-8">
                    <input type="file" class="form-control" name="profile_picture" id="profile_picture" />
                    <img width="100px" src="data:image/jpeg;base64,{{ base64_encode($employee->profile_picture) }}" alt="Profile Picture">
                </div>
            </div>


            <div class="mb-3 row">
                <div class="offset-sm-4 col-sm-8">
                    <button type="submit" class="btn btn-primary">
                        Submit
                    </button>
                </div>
            </div>
        </form>
    </div>
@endsection
