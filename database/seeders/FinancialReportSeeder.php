<?php

namespace Database\Seeders;

use App\Models\Expense;
use App\Models\FinancialReport;
use App\Models\Sale;
use App\Models\Tax;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FinancialReportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $totalSales = Sale::query()
                        ->whereMonth('sale_date',9)
                        ->whereYear('sale_date',2024)
                        ->sum('total');

        $totalExpenses = Expense::query()
                        ->whereMonth('expense_date',9)
                        ->whereYear('expense_date',2024)
                        ->sum('amount');

        $profitBeforeTax = $totalSales - $totalExpenses;

        $rate = Tax::query()->select('rate')->where('tax_name','VAT')->value('rate');

        $taxAmount = $totalSales * ($rate/100);

        $profitAfterTax = $profitBeforeTax - $taxAmount;        


        FinancialReport::insert([
            'month'             => 9,
            'year'              => 2024,
            'total_sales'       => $totalSales,
            'total_expenses'    => $totalExpenses,
            'profit_before_tax' => $profitBeforeTax,
            'tax_amount'        => $taxAmount,
            'profit_after_tax'  => $profitAfterTax,
            'created_at'        => now(),
            'updated_at'        => now(),
        ]);
    }
}
