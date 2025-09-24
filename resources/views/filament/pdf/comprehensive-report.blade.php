<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Report / تقرير</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@300;400;500;600;700;800&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Amiri', 'Inter', 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            direction: ltr;
            background-color: #f8fafc;
            line-height: 1.5;
            color: #1a202c;
            font-size: 14px;
        }

        .report-container {
            width: 100%;
            margin: 0 auto;
            background: white;
            border: 1px solid #e5e7eb;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .arabic-text {
            font-family: 'Amiri', 'DejaVu Sans', serif;
            font-weight: 400;
        }

        .english-text {
            font-family: 'Inter', 'DejaVu Sans', sans-serif;
            font-weight: 500;
        }

        /* Header Section */
        .header {
            background: #ffffff;
            padding: 30px;
            border-bottom: 2px solid #f3f4f6;
        }

        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: center;
            direction: ltr;
        }

        .report-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            text-align: left;
        }

        .report-date {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            text-align: right;
        }

        /* Content Section */
        .content {
            padding: 30px;
        }

        .summary-section {
            margin-bottom: 30px;
        }

        .summary-cards-row {
            width: 100%;
            display: block;
            position: relative;
        }

        .summary-card {
            width: 16.5%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            padding: 20px 15px;
            text-align: center;
            min-height: 120px;
            float: left;
            position: relative;
            margin-right: 3%;
        }

        .summary-card:last-child {
            margin-right: 0;
        }

        .summary-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 8px;
            line-height: 1.2;
        }

        .summary-value.negative {
            color: #dc2626;
        }

        .summary-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 3px;
            line-height: 1.3;
        }

        .summary-label .arabic {
            font-family: 'Amiri', serif;
            display: block;
            margin-top: 3px;
            color: #9ca3af;
            font-size: 11px;
            text-transform: none;
            letter-spacing: normal;
            line-height: 1.2;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }

        /* Table Section */
        .table-section {
            margin-top: 25px;
        }

        .table-container {
            background: white;
            border: 1px solid #e5e7eb;
            /* border-radius: 8px; */
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
            direction: ltr;
        }

        thead {
            display: table-header-group;
        }

        th {
            background: #f8fafc;
            color: #374151;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 15px;
            text-align: left;
            border-bottom: 2px solid #3b82f6;
            border-right: 1px solid #e5e7eb;
        }

        th:last-child {
            border-right: none;
        }

        td {
            padding: 12px 15px;
            text-align: left;
            border-bottom: 1px solid #f3f4f6;
            border-right: 1px solid #f3f4f6;
        }

        td:last-child {
            border-right: none;
        }

        tr:nth-child(even) {
            background-color: #fafbfc;
        }

        tr:nth-child(odd) {
            background-color: #ffffff;
        }

        .customer-name {
            font-weight: 700;
            color: #1f2937;
            font-size: 14px;
        }

        .city-name {
            color: #6b7280;
            font-weight: 500;
        }

        .amount {
            font-weight: 700;
            color: #1f2937;
            font-size: 13px;
        }

        .positive {
            color: #059669;
            background: #d1fae5;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .negative {
            color: #dc2626;
            background: #fee2e2;
            padding: 4px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .no-data {
            text-align: center;
            padding: 40px 20px;
            color: #6b7280;
            font-style: italic;
            background: #f9fafb;
        }

        /* Footer Section */
        .footer {
            background: #f8fafc;
            border-top: 1px solid #e5e7eb;
            padding: 20px 25px;
            text-align: center;
            color: #6b7280;
            font-size: 12px;
        }

        .footer .tagline {
            font-size: 10px;
            color: #9ca3af;
            margin-top: 5px;
            font-style: italic;
        }
    </style>
</head>

<body>
    <div class="report-container">
        <div class="header">
            <table style="width: 100%; direction: ltr;">
                <tr>
                    <td
                        style="text-align: left; font-size: 24px; font-weight: 700; color: #1f2937; border-bottom: none;">
                        <span class="english-text" dir="ltr">Report</span> /
                        <span class="arabic-text" dir="rtl">تقرير</span>
                    </td>
                    <td style="text-align: right; color: #6b7280; font-size: 14px; font-weight: 500; border-bottom: none;"
                        dir="ltr">
                        {{ $generated_at ?? now()->format('d-m-Y') }}
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <div class="summary-section">
                <div class="summary-cards-row clearfix">
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['remaining_balance'], 2) }}</div>
                        <div class="summary-label english-text">Overall Balance</div>
                        <div class="summary-label arabic arabic-text">الرصيد الإجمالي</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['overall_debit'], 2) }}</div>
                        <div class="summary-label english-text">Overall Debit</div>
                        <div class="summary-label arabic arabic-text">أجمالي التحصيل</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['overall_discount'], 2) }}</div>
                        <div class="summary-label english-text">Overall Discount</div>
                        <div class="summary-label arabic arabic-text">أجمالي الخصم</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['overall_return'], 2) }}</div>
                        <div class="summary-label english-text">Overall Return</div>
                        <div class="summary-label arabic arabic-text">أجمالي المرتجع</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['payment_percentage'], 2) }}%</div>
                        <div class="summary-label english-text">% of Payments</div>
                        <div class="summary-label arabic arabic-text">نسبة الدفع</div>
                    </div>
                </div>
            </div>
            <div class="table-section">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th class="english-text">Customer Name</th>
                                <th class="english-text">City</th>
                                <th class="english-text">Old Balance</th>
                                <th class="english-text">Total Invoices</th>
                                <th class="english-text">Overall Debit</th>
                                <th class="english-text">Total Discount</th>
                                <th class="english-text">Overall Return Goods</th>
                                <th class="english-text">Remaining Balance</th>
                                <th class="english-text">% of Payments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($customers) && count($customers) > 0)
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="customer-name english-text"><b>{{ $customer['name'] }}</b></td>
                                        <td class="city-name english-text">{{ $customer['city'] }}</td>
                                        <td class="amount english-text">{{ number_format($customer['old_balance'], 2) }}</td>
                                        <td class="amount english-text">{{ number_format($customer['total_invoices'], 2) }}</td>
                                        <td class="amount english-text">{{ number_format($customer['overall_debit'], 2) }}</td>
                                        <td class="amount english-text">{{ number_format($customer['total_discount'], 2) }}</td>
                                        <td class="amount english-text">{{ number_format($customer['overall_return'], 2) }}</td>
                                        <td
                                            class="amount english-text {{ $customer['remaining_balance'] >= 0 ? 'positive' : 'negative' }}">
                                            {{ number_format($customer['remaining_balance'], 2) }}
                                        </td>
                                        <td class="amount english-text">{{ number_format($customer['payment_percentage'], 2) }}%
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="no-data">No data available</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>

</html>