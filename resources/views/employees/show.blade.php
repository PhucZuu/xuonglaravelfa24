@extends('master')

@section('content')
    <h1 class="text-center">Chi tiết nhân viên: {{ $employee->first_name }} {{ $employee->last_name }}</h1>

    <table class="table text-center table-striped table-hover table-responsive">
        <thead>
            <tr>
                <th>Feild</th>
                <th>Value</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($employee->getAttributes() as $key => $value)
                <tr>
                    <td>{{ $key }}</td>
                    <td>
                        @php
                            switch ($key) {
                                case 'profile_picture':
                                    echo '<img width="100px" src="data:image/jpeg;base64,'.base64_encode($value).'" alt="">';
                                    break;
                                case 'is_active':
                                    if ($value) {
                                        echo "<span class=\"badge bg-success\">Yes</span>";
                                    }else{
                                        echo "<span class=\"badge bg-danger\">No</span>";
                                    }
                                    break;
                                default:
                                    echo $value;
                                    break;
                            }
                        @endphp
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
