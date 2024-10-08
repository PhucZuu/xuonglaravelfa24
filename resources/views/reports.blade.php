<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Báo Cáo Tài Chính</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="container mt-5">
        <h1 class="text-center">Báo Cáo Tài Chính</h1>

        <h2 class="mt-4">Tổng Doanh Thu Theo Tháng</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Năm</th>
                    <th>Tổng Doanh Thu (VND)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($salesData as $data)
                    <tr>
                        <td>{{ $data->month }}</td>
                        <td>{{ $data->year }}</td>
                        <td>{{ number_format($data->total_sale) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-4">Tổng Chi Phí Theo Tháng</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>Tháng</th>
                    <th>Năm</th>
                    <th>Tổng Chi Phí (VND)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expensesData as $data)
                    <tr>
                        <td>{{ $data->month }}</td>
                        <td>{{ $data->year }}</td>
                        <td>{{ number_format($data->total_expenses) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h2 class="mt-4">Báo Cáo Tài Chính</h2>
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tháng</th>
                    <th>Năm</th>
                    <th>Tổng Doanh Thu (VND)</th>
                    <th>Tổng Chi Phí (VND)</th>
                    <th>Lợi Nhuận Trước Thuế (VND)</th>
                    <th>Thuế (VND)</th>
                    <th>Lợi Nhuận Sau Thuế (VND)</th>
                </tr>
            </thead>
            <tbody>
                @foreach($financialReports as $report)
                    <tr>
                        <td>{{ $report->id }}</td>
                        <td>{{ $report->month }}</td>
                        <td>{{ $report->year }}</td>
                        <td>{{ number_format($report->total_sales) }} VND</td>
                        <td>{{ number_format($report->total_expenses) }} VND</td>
                        <td>{{ number_format($report->profit_before_tax) }} VND</td>
                        <td>{{ number_format($report->tax_amount) }} VND</td>
                        <td>{{ number_format($report->profit_after_tax) }} VND</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>