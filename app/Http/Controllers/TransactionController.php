<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    public function index()
    {
        // session()->forget('transaction');
        return view('transactions.index');
    }

    public function create()
    {
        if(!session()->has('transaction')){
            return view('transactions.create');
        }else{
            return redirect()->route('transactions.confirm')->with('pendingTransaction', 'Bạn đang có 1 giao dịch cần xác nhận');
        }
    }

    public function startTransaction(Request $request)
    {
        $infoTransaction = $request->validate([
            'transaction_id'   => 'required',
            'amount'           => 'required|numeric',
            'receiver_account' => 'required|max:255',
        ]);

        // Lưu thông tin transaction
        session()->put('transaction', [
            'transaction_id'   => $infoTransaction['transaction_id'],
            'amount'           => $infoTransaction['amount'],
            'receiver_account' => $infoTransaction['receiver_account'],
            'status'           => 'pending',
        ]);

        // Chuyển trang Xác nhận
        return redirect()->route('transactions.confirm');
    }

    public function confirmTransaction()
    {
        return view('transactions.transaction-details');
    }

    public function completeTransactionStatus()
    {
        // Kiểm tra xem session có chứa giao dịch không
        if (session()->has('transaction')) {

            session()->put('transaction.status','confirmed');
            // Lấy dữ liệu từ session
            $transaction = session('transaction');

            if ($transaction['status'] === 'confirmed') {
                DB::table('transactions')->insert([
                    'transaction_id'    => $transaction['transaction_id'],
                    'amount'            => $transaction['amount'],
                    'receiver_account'  => $transaction['receiver_account'],
                    'status'            => 'success',
                ]);

                session()->forget('transaction');

                return redirect()->route('transactions')->with('success', 'Transaction completed successfully.');
            }
        }

        return redirect()->route('transactions')->with('error', 'No transaction found in session.');
    }

    public function cancelTransaction()
    {
        session()->forget('transaction');

        return redirect()->route('transactions')->with('success', 'Transaction cancelled successfully.');
    }
}
