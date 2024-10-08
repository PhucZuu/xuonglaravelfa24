@extends('master')

@section('content')
    <h1 class="text-center">Danh sách nhân viên</h1>

    <a href="{{ route('employees.create') }}" class="btn btn-primary mb-2">Thêm mới</a>

    @if (session()->has('success') && session()->get('success'))
        <div class="alert alert-success">
            Thao tác thành công
        </div>
    @endif

    @if (session()->has('success') && !session()->get('success'))
        <div class="alert alert-success">
            Thao tác thất bại
        </div>
    @endif

    <table class="table text-center table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Date of Birth</th>
                <th>Hire Date</th>
                <th>Active</th>
                <th>Address</th>
                <th>Profile Picture</th>
                <th>Manager</th>
                <th>Department</th>
                <th>#</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->first_name }}</td>
                    <td>{{ $employee->last_name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->date_of_birth }}</td>
                    <td>{{ $employee->hire_date }}</td>
                    <td>
                        @if ($employee->is_active)
                            <span class="badge bg-success">Yes</span>
                        @else
                            <span class="badge bg-warning">No</span>
                        @endif
                    </td>
                    <td>{{ $employee->address }}</td>
                    <td>
                        @if ($employee->profile_picture)
                            <img width="100px" src="data:image/jpeg;base64,{{ base64_encode($employee->profile_picture) }}"
                                alt="Profile Picture">
                        @else
                            <span class="badge bg-warning">No Image</span>
                        @endif
                    </td>
                    <td>{{ $employee->manager_name }}</td>
                    <td>{{ $employee->department_name }}</td>
                    <td class="text-center">
                        <a href="{{ route('employees.edit', $employee) }}" class="btn btn-primary">Edit</a>
                        <a href="{{ route('employees.show', $employee) }}" class="btn btn-info mb-2 mt-2">Show</a>

                        <form action="{{ route('employees.destroy', $employee) }}" method="post">
                            @csrf
                            @method('DELETE')

                            <button type="submit" onclick="return confirm('Are you sure 🤨🤨🤨')" class="btn btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
        {{ $employees->links() }}
    </table>
@endsection
