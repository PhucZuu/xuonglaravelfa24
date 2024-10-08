@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Transaction Details</h1>
        @if (session('pendingTransaction'))
            <div class="alert alert-warning">
                {{ session('pendingTransaction') }}
            </div>
        @endif

        @if (session()->has('transaction'))
            @php
                $transaction = session('transaction');
            @endphp

            <div class="alert alert-info">
                <strong>Transaction ID:</strong> {{ $transaction['transaction_id'] }}<br>
                <strong>Amount:</strong> {{ number_format($transaction['amount'], 2) }}<br>
                <strong>Receiver Account:</strong> {{ $transaction['receiver_account'] }}<br>
                <strong>Status:</strong> {{ $transaction['status'] }}<br>
            </div>

            <form action="{{ route('transactions.complete') }}" method="POST" class="mt-2">
                @csrf
                <button type="submit" class="btn btn-success">Confirm Transaction</button>
            </form>

            <form action="{{ route('transactions.cancel') }}" method="POST" class="d-inline-block">
                @csrf
                <button type="submit" class="btn btn-danger">Cancel Transaction</button>
            </form>
        @else
            <div class="alert alert-warning">
                No transaction details available.
            </div>
        @endif
    </div>
@endsection
