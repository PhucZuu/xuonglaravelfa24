@extends('layouts.app')

@section('content')
    <div class="container mt-5">
        <h1>Create Transaction</h1>
        <form action="{{ route('transactions.start') }}" method="POST">
            @csrf
            <div class="form-group mb-2">
                <label for="transaction_id">Transaction ID:</label>
                <input type="text" name="transaction_id" id="transaction_id" class="form-control" value="{{ Str::uuid() }}"
                    readonly>
            </div>
            <div class="form-group mb-2">
                <label for="amount">Amount:</label>
                <input type="number" name="amount" id="amount" class="form-control" required>
            </div>
            <div class="form-group mb-2">
                <label for="receiver_account">Receiver Account:</label>
                <input type="text" name="receiver_account" id="receiver_account" class="form-control" required>
            </div>
            <button type="submit" class="btn btn-primary">Start Transaction</button>
            <a href="{{ route('transactions') }}" class="btn btn-secondary">Back to Transactions</a>
        </form>
    </div>
@endsection
