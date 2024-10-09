@extends('layouts.app')

@section('content')
    <div class="table-responsive">
        <table class="table table-primary">
            <thead>
                <tr>
                    <th scope="col">User</th>
                    <th scope="col">Phone</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($data as $user)
                    <tr class="">
                        <td scope="row">{{ $user->name }}</td>
                        <td>{{ $user->phone->value }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
