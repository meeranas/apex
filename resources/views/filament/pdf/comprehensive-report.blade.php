<!DOCTYPE html>
<html lang="ar" dir="rtl">

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
            direction: rtl;
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
            /* This is the key change to make the header behave as LTR */
        }

        .report-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            display: inline-block;
        }

        .report-date {
            color: #6b7280;
            font-size: 14px;
            font-weight: 500;
            display: inline-block;
        }

        /* Content Section */
        .content {
            padding: 30px;
        }

        /* Summary Cards Section */
        .summary-section {
            margin-bottom: 30px;
        }

        .summary-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 15px 0;
            table-layout: fixed;
        }

        .summary-card-cell {
            padding: 0;
        }

        .summary-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px 15px;
            text-align: center;
            box-shadow: 0 1px 2px rgba(0, 0, 0, 0.05);
        }

        .summary-value {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin-bottom: 5px;
        }

        .summary-label {
            font-size: 12px;
            color: #6b7280;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .summary-label .arabic {
            font-family: 'Amiri', serif;
            display: block;
            margin-top: 3px;
            color: #9ca3af;
            font-size: 11px;
            text-transform: none;
            letter-spacing: normal;
        }

        /* Table Section */
        .table-section {
            margin-top: 25px;
        }

        .table-container {
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        /* Make table header repeat on every page */
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

        .footer .system-name {
            font-weight: 700;
            color: #374151;
            font-size: 14px;
            margin-bottom: 5px;
        }

        .footer .arabic {
            font-family: 'Amiri', serif;
            color: #9ca3af;
            margin-bottom: 8px;
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
            <table style="width: 100%;">
                <tr>
                    <!-- Bilingual Title -->
                    <td style="text-align: left; font-size: 24px; font-weight: 700; color: #1f2937;">
                        <span class="english-text" dir="ltr">Report</span> /
                        <span class="arabic-text" dir="rtl">تقرير</span>
                    </td>

                    <!-- Date always LTR -->
                    <td style="text-align: right; color: #6b7280; font-size: 14px; font-weight: 500;" dir="ltr">
                        2025-09-21 10:30 AM
                    </td>
                </tr>
            </table>
        </div>
        <div class="content">
            <div class="summary-section">
                <table class="summary-table">
                    <tr>
                        <td class="summary-card-cell">
                            <div class="summary-card">
                                <div class="summary-value">{{ number_format($statistics['overall_balance'], 2) }}</div>
                                <div class="summary-label english-text">Overall Balance</div>
                                <div class="summary-label arabic arabic-text">الرصيد الإجمالي</div>
                            </div>
                        </td>
                        <td class="summary-card-cell">
                            <div class="summary-card">
                                <div class="summary-value">{{ number_format($statistics['total_invoices'], 2) }}</div>
                                <div class="summary-label english-text">Total Invoices</div>
                                <div class="summary-label arabic arabic-text">إجمالي الفواتير</div>
                            </div>
                        </td>
                        <td class="summary-card-cell">
                            <div class="summary-card">
                                <div class="summary-value">{{ number_format($statistics['remaining_balance'], 2) }}
                                </div>
                                <div class="summary-label english-text">Remaining Balance</div>
                                <div class="summary-label arabic arabic-text">الرصيد المتبقي</div>
                            </div>
                        </td>
                        <td class="summary-card-cell">
                            <div class="summary-card">
                                <div class="summary-value">{{ number_format($statistics['percentage_remaining'], 2) }}%
                                </div>
                                <div class="summary-label english-text">Percentage Remaining</div>
                                <div class="summary-label arabic arabic-text">النسبة المتبقية</div>
                            </div>
                        </td>
                    </tr>
                </table>
            </div>
            <div class="table-section">
                <div class="table-container">
                    @if($customers->count() > 0)
                        <table>
                            <thead>
                                <tr>
                                    <th class="english-text">Customer Name</th>
                                    <th class="english-text">City</th>
                                    <th class="english-text">Old Balance</th>
                                    <th class="english-text">Total Invoices</th>
                                    <th class="english-text">Remaining Balance</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($customers as $customer)
                                    <tr>
                                        <td class="customer-name english-text">{{ $customer['name'] }}</td>
                                        <td class="city-name english-text">{{ $customer['city'] }}</td>
                                        <td class="amount">{{ number_format($customer['old_balance'], 2) }} ر.س</td>
                                        <td class="amount">{{ number_format($customer['total_invoices'], 2) }} ر.س</td>
                                        <td class="amount {{ $customer['remaining_balance'] >= 0 ? 'positive' : 'negative' }}">
                                            {{ number_format($customer['remaining_balance'], 2) }} ر.س
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    @else
                        <div class="no-data">
                            <p class="english-text">No customers found matching the applied filters.</p>
                            <p class="arabic-text">لم يتم العثور على عملاء يطابقون الفلاتر المطبقة.</p>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        <div class="footer">
            <div class="tagline english-text">Generated on {{ $generated_at }} | Apex </div>
        </div>
    </div>
</body>

</html>