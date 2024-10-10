@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Edit Student</h1>

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
            <div class="alert alert-success">
                Thao tác thất bại
            </div>
        @endif

        <form action="{{ route('students.update', $student->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label for="name" class="form-label">Name</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ $student->name }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="{{ $student->email }}"
                    required>
            </div>

            <div class="mb-3">
                <label for="classroom_id" class="form-label">Classroom</label>
                <select class="form-select" id="classroom_id" name="classroom_id" required>
                    <option value="">Select a classroom</option>
                    @foreach ($classrooms as $classroom)
                        <option value="{{ $classroom->id }}"
                            {{ $student->classroom_id == $classroom->id ? 'selected' : '' }}>
                            {{ $classroom->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="passport_number" class="form-label">Passport Number</label>
                <input type="text" class="form-control" id="passport_number" name="passport_number"
                    value="{{ $student->passport->passport_number }}" required>
            </div>

            <div class="mb-3">
                <label for="issued_date" class="form-label">Issued Date</label>
                <input type="date" class="form-control" id="issued_date" name="issued_date"
                    value="{{ $student->passport->issued_date }}" required>
            </div>

            <div class="mb-3">
                <label for="expiry_date" class="form-label">Expiry Date</label>
                <input type="date" class="form-control" id="expiry_date" name="expiry_date"
                    value="{{ $student->passport->expiry_date }}" required>
            </div>

            <div class="mb-3">
                <label for="subjects" class="form-label">Subjects</label>
                <select class="form-select" id="subjects" name="subjects[]" multiple required>
                    @php
                        $selectedSubjects = old('subjects', $student->subjects->pluck('id')->toArray());
                    @endphp

                    @foreach ($subjects as $subject)
                        <option value="{{ $subject->id }}"
                            {{ in_array($subject->id, $selectedSubjects) ? 'selected' : '' }}>
                            {{ $subject->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Update Student</button>
        </form>

        <a href="{{ route('students.index') }}" class="btn btn-secondary mt-3">Back to Student List</a>
    </div>
@endsection
