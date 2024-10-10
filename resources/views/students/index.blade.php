@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>List Students</h1>

        <a href="{{ route('students.create') }}" class="btn btn-success mb-4">Add New Student</a>

        <form action="{{ route('students.index') }}" method="GET" class="mb-4">
            <div class="input-group">
                <input type="text" class="form-control" name="search" placeholder="Search by name or classroom"
                    value="{{ request('search') }}">
                <button class="btn btn-primary" type="submit">Search</button>
            </div>
        </form>

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

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Classroom</th>
                    <th>Passport Number</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($students as $student)
                    <tr>
                        <td>{{ $student->id }}</td>
                        <td>{{ $student->name }}</td>
                        <td>{{ $student->email }}</td>
                        <td>
                            @if ($student->classroom->name)
                                {{ $student->classroom->name }}
                            @else
                                <span class="badge bg-warning">Not found</span>
                            @endif
                        </td>
                        <td>
                            @if ($student->passport->passport_number)
                                {{ $student->passport->passport_number }}
                            @else
                                <span class="badge bg-warning">Not found</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('students.show', $student) }}" class="btn btn-info">View</a>
                            <a href="{{ route('students.edit', $student) }}" class="btn btn-primary">Edit</a>
                            <form action="{{ route('students.destroy', $student) }}" method="post">
                                @csrf
                                @method('DELETE')
                                
                                <button type="submit" onclick="return confirm('Are you sure???')" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No students found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $students->links() }}
    </div>
@endsection
