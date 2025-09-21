<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Comprehensive Financial Report / التقرير المالي الشامل</title>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Inter:wght@300;400;500;600;700;800&display=swap');
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Inter', 'DejaVu Sans', Arial, sans-serif;
            margin: 0;
            padding: 20px;
            direction: rtl;
            background-color: #ffffff;
            line-height: 1.5;
            color: #1a202c;
            font-size: 14px;
        }
        
        .arabic-text {
            font-family: 'Amiri', 'DejaVu Sans', serif;
            font-weight: 400;
        }
        
        .english-text {
            font-family: 'Inter', 'DejaVu Sans', sans-serif;
            font-weight: 500;
        }
        
        .report-container {
            max-width: 210mm;
            margin: 0 auto;
            background: white;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }
        
        /* Header Section - Clean and Professional */
        .header {
            background: #ffffff;
            padding: 30px 25px 20px 25px;
            border-bottom: 2px solid #f3f4f6;
        }
        
        .header-content {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }
        
        .report-title {
            font-size: 24px;
            font-weight: 700;
            color: #1f2937;
            margin: 0;
            background: #fef3c7;
            padding: 8px 12px;
            border-radius: 4px;
            border: 1px solid #f59e0b;
        }
        
        .report-date {
            background: #f9fafb;
            color: #6b7280;
            padding: 8px 16px;
            border-radius: 6px;
            font-size: 14px;
            font-weight: 500;
            border: 1px solid #e5e7eb;
        }
        
        .arabic-title {
            font-family: 'Amiri', serif;
            font-size: 18px;
            color: #4b5563;
            margin-top: 8px;
            font-weight: 600;
        }
        
        /* Content Section */
        .content {
            padding: 25px;
        }
        
        /* Summary Cards Section */
        .summary-section {
            margin-bottom: 30px;
        }
        
        .summary-cards {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 15px;
            margin-top: 20px;
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
        
        /* Applied Filters Section */
        .filters-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
        }
        
        .filters-title {
            font-size: 16px;
            font-weight: 600;
            color: #374151;
            margin-bottom: 15px;
        }
        
        .filters-title .arabic {
            font-family: 'Amiri', serif;
            font-size: 14px;
            color: #6b7280;
            margin-top: 3px;
        }
        
        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }
        
        .filter-tag {
            background: #3b82f6;
            color: white;
            padding: 6px 12px;
            border-radius: 16px;
            font-size: 11px;
            font-weight: 600;
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
        
        .table-header {
            background: #3b82f6;
            color: white;
            padding: 15px 20px;
            text-align: center;
        }
        
        .table-title {
            font-size: 18px;
            font-weight: 700;
            margin: 0;
        }
        
        .table-title .arabic {
            font-family: 'Amiri', serif;
            font-size: 16px;
            margin-top: 3px;
            opacity: 0.9;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        
        th {
            background: #f8fafc;
            color: #374151;
            font-weight: 700;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            padding: 12px 15px;
            text-align: right;
            border-bottom: 2px solid #3b82f6;
            border-right: 1px solid #e5e7eb;
        }
        
        th:last-child {
            border-right: none;
        }
        
        td {
            padding: 12px 15px;
            text-align: right;
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
        
        /* Print Styles */
        @media print {
            body {
                margin: 0;
                padding: 10px;
                background: white;
            }
            
            .report-container {
                box-shadow: none;
                border: 1px solid #d1d5db;
            }
            
            .summary-cards {
                gap: 12px;
            }
            
            .summary-card {
                padding: 15px 12px;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <!-- Header Section -->
        <div class="header">
            <div class="header-content">
                <div>
                    <div class="report-title english-text">| Report Name |</div>
                    <div class="arabic-title arabic-text">التقرير المالي الشامل</div>
                </div>
                <div class="report-date english-text">Date of issue {{ $generated_at }}</div>
            </div>
        </div>

        <div class="content">
            <!-- Summary Cards Section -->
            <div class="summary-section">
                <div class="summary-cards">
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['overall_balance'], 2) }}</div>
                        <div class="summary-label english-text">Overall Balance</div>
                        <div class="summary-label arabic arabic-text">الرصيد الإجمالي</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['total_invoices'], 2) }}</div>
                        <div class="summary-label english-text">Total Invoices</div>
                        <div class="summary-label arabic arabic-text">إجمالي الفواتير</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['remaining_balance'], 2) }}</div>
                        <div class="summary-label english-text">Remaining Balance</div>
                        <div class="summary-label arabic arabic-text">الرصيد المتبقي</div>
                    </div>
                    <div class="summary-card">
                        <div class="summary-value">{{ number_format($statistics['percentage_remaining'], 2) }}%</div>
                        <div class="summary-label english-text">Percentage Remaining</div>
                        <div class="summary-label arabic arabic-text">النسبة المتبقية</div>
                    </div>
                </div>
            </div>

            <!-- Applied Filters Section -->
            @if(!empty($filters))
            <div class="filters-section">
                <div class="filters-title english-text">Applied Filters</div>
                <div class="filters-title arabic arabic-text">الفلاتر المطبقة</div>
                
                <div class="filter-tags">
                    @if(isset($filters['issuers']))
                        @foreach($filters['issuers'] as $id => $name)
                            <span class="filter-tag english-text">Issuer: {{ $name }}</span>
                        @endforeach
                    @endif
                    @if(isset($filters['cities']))
                        @foreach($filters['cities'] as $id => $name)
                            <span class="filter-tag english-text">City: {{ $name }}</span>
                        @endforeach
                    @endif
                    @if(isset($filters['customers']))
                        @foreach($filters['customers'] as $id => $name)
                            <span class="filter-tag english-text">Customer: {{ $name }}</span>
                        @endforeach
                    @endif
                    @if(isset($filters['products']))
                        @foreach($filters['products'] as $id => $name)
                            <span class="filter-tag english-text">Product: {{ $name }}</span>
                        @endforeach
                    @endif
                    @if(isset($filters['due_date_from']))
                        <span class="filter-tag english-text">From: {{ $filters['due_date_from'] }}</span>
                    @endif
                    @if(isset($filters['due_date_to']))
                        <span class="filter-tag english-text">To: {{ $filters['due_date_to'] }}</span>
                    @endif
                </div>
            </div>
            @endif

            <!-- Customer Report Table Section -->
            <div class="table-section">
                <div class="table-container">
                    <div class="table-header">
                        <div class="table-title english-text">Customer Financial Details</div>
                        <div class="table-title arabic arabic-text">تفاصيل العملاء المالية</div>
                    </div>
                    
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
            <div class="system-name english-text">Report generated by Apex Dashboard System</div>
            <div class="arabic arabic-text">تم إنشاء التقرير بواسطة نظام لوحة تحكم أبكس</div>
            <div class="tagline english-text">Generated on {{ $generated_at }} | Professional Business Report</div>
        </div>
    </div>
</body>
</html>
