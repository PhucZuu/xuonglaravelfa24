@extends('layouts.app')

@section('content')
    <div class="container text-center mt-5">
        <h1>Welcome to the Transaction System</h1>

        <!-- Hiển thị thông báo thành công -->
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <!-- Hiển thị thông báo lỗi -->
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif


        <a href="{{ route('transactions.create') }}" class="btn btn-primary btn-lg mt-4">Start a Transaction</a>
    </div>
@endsection
