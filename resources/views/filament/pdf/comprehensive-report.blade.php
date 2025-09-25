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
            padding: 5px;
            border-bottom: 2px solid #f3f4f6;
        }

        /* Content Section */
        .content {
            padding: 15px;
        }

        /* Summary Tables Section */
        .summary-section {
            margin-bottom: 30px;
        }

        .summary-tables-container {
            width: 100%;
            overflow: hidden;
        }

        .summary-table-wrapper {
            float: left;
            width: 44%;
            margin-right: 12%;
        }

        .summary-table-wrapper:last-child {
            margin-right: 0;
        }

        .summary-table {
            width: 100%;
            border-collapse: collapse;
            border: 1px solid #d1d5db;
            background: #f9fafb;
        }

        .summary-table td {
            padding: 12px 15px;
            border: 1px solid #ffffff;
            font-size: 14px;
            line-height: 1.4;
        }

        .summary-table .label-cell {
            background: #e5e7eb;
            text-align: left;
            vertical-align: middle;
            width: 60%;
        }

        .summary-table .label-cell-white {
            background: #ffffff;
            text-align: left;
            vertical-align: middle;
            width: 60%;
        }

        .summary-table .value-cell {
            background: #e5e7eb;
            text-align: center;
            vertical-align: middle;
            width: 40%;
            font-weight: bold;
        }

        .summary-table .value-cell-white {
            background: #ffffff;
            text-align: center;
            vertical-align: middle;
            width: 40%;
            font-weight: bold;
        }

        .summary-table .label-cell .english-label {
            display: block;
            font-weight: bold;
            color: #374151;
            margin-bottom: 6px;
            line-height: 1.3;
            white-space: nowrap;
        }

        .summary-table .label-cell .arabic-label {
            display: block;
            color: #374151;
            font-size: 13px;
            line-height: 1.3;
            white-space: nowrap;
        }

        .summary-table .label-cell-white .english-label {
            display: block;
            font-weight: bold;
            color: #374151;
            margin-bottom: 6px;
            line-height: 1.3;
            white-space: nowrap;
        }

        .summary-table .label-cell-white .arabic-label {
            display: block;
            color: #374151;
            font-size: 13px;
            line-height: 1.3;
            white-space: nowrap;
        }

        .summary-table .value-cell.red-value {
            color: #dc2626;
        }

        .summary-table .value-cell.gray-value {
            color: #374151;
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
            border-bottom: 2px solid #d97706;
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
                <div class="summary-tables-container">
                    <!-- Left Table -->
                    <div class="summary-table-wrapper" style="width: 44%; margin-right: 10%;">
                        <table class="summary-table" style="border: 1px solid #d1d5db;">
                            <tr>
                                <td class="label-cell" style="border: 1px solid #d1d5db;">
                                    <span class="english-label">Current Balances</span>
                                    <span class="arabic-label arabic-text">أجمالي الأرصدة</span>
                                </td>
                                <td class="value-cell red-value" style="border: 1px solid #d1d5db;">
                                    {{ number_format($statistics['overall_balance'], 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell" style="border: 1px solid #d1d5db;">
                                    <span class="english-label">Remaining Balance</span>
                                    <span class="arabic-label arabic-text">الأرصدة المتبقية</span>
                                </td>
                                <td class="value-cell red-value" style="border: 1px solid #d1d5db;">
                                    {{ number_format($statistics['remaining_balance'], 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell" style="border: 1px solid #d1d5db;">
                                    <span class="english-label">% of Payments</span>
                                    <span class="arabic-label arabic-text">نسبة المدفوع</span>
                                </td>
                                <td class="value-cell red-value" style="border: 1px solid #d1d5db;">
                                    {{ number_format($statistics['payment_percentage'], 0) }}
                                </td>
                            </tr>
                        </table>
                    </div>

                    <!-- Right Table -->
                    <div class="summary-table-wrapper" style="width: 44%; margin-left: 11.8%;">
                        <table class="summary-table" style="border: 1px solid #f3f4f6;">
                            <tr>
                                <td class="label-cell-white" style="border: 1px solid #f3f4f6;">
                                    <span class="english-label">Overall Debit</span>
                                    <span class="arabic-label arabic-text">أجمالي التحصيل</span>
                                </td>
                                <td class="value-cell-white gray-value" style="border: 1px solid #f3f4f6;">
                                    {{ number_format($statistics['overall_debit'], 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell-white" style="border: 1px solid #f3f4f6;">
                                    <span class="english-label">Overall Discount</span>
                                    <span class="arabic-label arabic-text">أجمالي الخصم</span>
                                </td>
                                <td class="value-cell-white gray-value" style="border: 1px solid #f3f4f6;">
                                    {{ number_format($statistics['overall_discount'], 0) }}
                                </td>
                            </tr>
                            <tr>
                                <td class="label-cell-white" style="border: 1px solid #f3f4f6;">
                                    <span class="english-label">Overall Return</span>
                                    <span class="arabic-label arabic-text">أجمالي المرتجع</span>
                                </td>
                                <td class="value-cell-white gray-value" style="border: 1px solid #f3f4f6;">
                                    {{ number_format($statistics['overall_return'], 0) }}
                                </td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
            <div class="table-section">
                <div class="table-container">
                    <table>
                        <thead>
                            <tr>
                                <th class="english-text">Customer Name<br><span class="arabic-text" style="">أسم
                                        العميل</span></th>
                                <th class="english-text">City<br><span class="arabic-text" style="">المدينة</span></th>
                                <th class="english-text">Old Balance<br><span class="arabic-text" style="">الرصيد
                                        السابق</span></th>
                                <th class="english-text">Total Invoices<br><span class="arabic-text" style="">اجمالي
                                        الفواتير</span></th>
                                <th class="english-text">Overall Debit<br><span class="arabic-text"
                                        style="">التحصيل</span></th>
                                <th class="english-text">Total Discount<br><span class="arabic-text"
                                        style="">الخصم</span></th>
                                <th class="english-text">Overall Return Goods<br><span class="arabic-text"
                                        style="">المراجع</span></th>
                                <th class="english-text">Remaining Balance<br><span class="arabic-text" style="">الرصيد
                                        الحالي</span></th>
                                <th class="english-text">% of Payments</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if(isset($customers))
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