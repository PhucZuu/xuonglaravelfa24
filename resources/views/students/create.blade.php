@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Create Student</h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session()->has('success') && !session()->get('success'))
            <div class="alert alert-success">
                Thao tác thất bại
            </div>
        @endif

        <form action="{{ route('students.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('email') }}">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" value="{{ old('email') }}" name="email">
            </div>

            <div class="mb-3">
                <label for="classroom_id" class="form-label">Classroom</label>
                <select class="form-select" id="classroom_id" name="classroom_id">
                    <option value="">Select a classroom</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}">{{ $classroom->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="passport_number" class="form-label">Passport Number</label>
                <input type="text" class="form-control" id="passport_number" value="{{ old('passport_number') }}"
                    name="passport_number">
            </div>

            <div class="mb-3">
                <label for="issued_date" class="form-label">Issued Date</label>
                <input type="date" class="form-control" id="issued_date" value="{{ old('issued_date') }}"
                    name="issued_date">
            </div>

            <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" value="{{ old('expiry_date') }}"
                    name="expiry_date">
            </div>

            <div class="mb-3">
                <label for="subjects" class="form-label">Subjects</label>
                <select class="form-select" id="subjects" name="subjects[]" multiple>
                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Student</button>
        </form>
    </div>
@endsection
