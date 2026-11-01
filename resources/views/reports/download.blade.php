<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>{{ ucfirst($range) }} Report</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            color: #333;
            background-color: white;
        }

        .container {
            max-width: 900px;
            margin: 0 auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #ddd;
            margin: 20px 0;
            background-color: white;
        }

        th {
            background-color: #d2ffee;
            border: 1px solid #6b6b6b;
            padding: 10px 5px;
            text-align: left;
            font-weight: bold;
        }

        td {
            border: 1px solid #6b6b6b;
            padding: 8px 5px;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #333;
            padding-bottom: 15px;
        }

        .shop-name {
            font-size: 20px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .report-title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
            text-transform: capitalize;
        }

        .report-date {
            font-size: 12px;
            color: #666;
        }

        .section-header {
            background-color: #1a1a1a;
            color: white;
            padding: 10px;
            font-weight: bold;
            text-align: center;
        }

        .footer {
            margin-top: 30px;
            text-align: center;
            font-size: 12px;
            color: #666;
            border-top: 2px solid #333;
            padding-top: 15px;
        }

        @media print {
            body {
                background-color: white;
            }
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="shop-name">{{ $settings->shop_name ?? 'Shop Name' }}</div>
            <div class="report-title">{{ $range }} Report</div>
            <div class="report-date">
                @if ($range == 'daily')
                    {{ \Carbon\Carbon::now()->format('d F, Y') }} - {{ \Carbon\Carbon::parse(\Carbon\Carbon::now())->dayName }}
                @elseif ($range == 'monthly')
                    {{ \Carbon\Carbon::now()->format('F, Y') }}
                @elseif ($range == 'yearly')
                    {{ \Carbon\Carbon::now()->format('Y') }}
                @elseif ($range == 'custom')
                    {{ \Carbon\Carbon::createFromFormat('Y-m-d', $to)->format('d F, Y') }} to {{ \Carbon\Carbon::createFromFormat('Y-m-d', $from)->format('d F, Y') }}
                @endif
            </div>
        </div>

        @if (isset($report) && $report)
            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="section-header">Product Report</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($range == 'daily')
                    <tr>
                        <th>Total Product (Instock)</th>
                        <td>{{ $report['productsCount'] }} pc</td>
                    </tr>
                    <tr>
                        <th>Total Product (Out of Stock)</th>
                        <td>{{ $report['outOfStockProducts'] }} pc</td>
                    </tr>
                    @endif
                    <tr>
                        <th>Total Sold Product</th>
                        <td>{{ $report['soldProducts'] }} pc</td>
                    </tr>
                    <tr>
                        <th>Top Sold Product</th>
                        <td>{{ $report['topSoldProduct']['maxProduct'] }} - {{ $report['topSoldProduct']['maxQuantity'] }} pc</td>
                    </tr>
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="section-header">Sell Report</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Total Invoice</th>
                        <td>{{ $report['totalOrder'] }}</td>
                    </tr>
                    <tr>
                        <th>Total Sell Amount</th>
                        <td>KSH {{ number_format((int) $report['totalSellAmount'], 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total Paid Amount</th>
                        <td>KSH {{ number_format((int) $report['totalSellAmount'] - (int) $report['totalDueAmount'], 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total Due Amount</th>
                        <td>KSH {{ number_format((int) $report['totalDueAmount'], 2) }}</td>
                    </tr>
                    <tr>
                        <th>Total Profit</th>
                        <td>KSH {{ number_format((int) $report['profit'], 2) }}</td>
                    </tr>
                </tbody>
            </table>

            <table>
                <thead>
                    <tr>
                        <th colspan="2" class="section-header">Expense Report</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>Total Expense</th>
                        <td>KSH {{ number_format((int) $report['totalExpense'], 2) }}</td>
                    </tr>
                    <tr>
                        <th>Top Expense Criteria</th>
                        <td>{{ $report['topExpenseCategory'] }}</td>
                    </tr>
                </tbody>
            </table>
        @endif

        <div class="footer">
            <p>Generated on {{ \Carbon\Carbon::now()->format('d F, Y H:i:s') }}</p>
        </div>
    </div>
</body>
</html>