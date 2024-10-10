@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Chi tiết sinh viên: {{ $student->name }}</h1>
        <table class="table">
            <tr>
                <th>ID</th>
                <td>{{ $student->id }}</td>
            </tr>
            <tr>
                <th>Tên</th>
                <td>{{ $student->name }}</td>
            </tr>
            <tr>
                <th>Email</th>
                <td>{{ $student->email }}</td>
            </tr>
            <tr>
                <th>Lớp học</th>
                <td>{{ $student->classroom->name ?? 'Chưa có lớp' }}</td>
            </tr>
            <tr>
                <th>Tên giáo viên</th>
                <td>{{ $student->classroom->teacher_name ?? 'Chưa có giáo viên' }}</td>
            </tr>
            <tr>
                <th>Số hộ chiếu</th>
                <td>{{ $student->passport->passport_number ?? 'Không có' }}</td>
            </tr>
            <tr>
                <th>Ngày cấp</th>
                <td>{{ $student->passport->issued_date ?? 'Không có' }}</td>
            </tr>
            <tr>
                <th>Ngày hết hạn</th>
                <td>{{ $student->passport->expiry_date ?? 'Không có' }}</td>
            </tr>
            <tr>
                <th>Môn học</th>
                <td>
                    @foreach ($student->subjects as $subject)
                        {{ $subject->name }} ({{ $subject->credits }} tín chỉ)<br>
                    @endforeach
                </td>
            </tr>
        </table>
        <a class="btn btn-secondary" href="{{ url('/students') }}">Quay lại danh sách sinh viên</a>
    </div>
@endsection
