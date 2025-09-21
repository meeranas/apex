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
            padding: 30px;
            direction: rtl;
            background-color: #fafbfc;
            line-height: 1.6;
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
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }
        
        .header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 50%, #3b82f6 100%);
            color: white;
            padding: 40px 35px;
            text-align: center;
            position: relative;
        }
        
        .header h1 {
            margin: 0;
            font-size: 32px;
            font-weight: 800;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            position: relative;
            z-index: 1;
        }
        
        .header .arabic-title {
            font-family: 'Amiri', serif;
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 15px;
            opacity: 0.95;
        }
        
        .header .subtitle {
            margin: 0;
            font-size: 16px;
            opacity: 0.9;
            font-weight: 500;
            position: relative;
            z-index: 1;
        }
        
        .content {
            padding: 35px;
        }
        
        .section {
            margin-bottom: 40px;
        }
        
        .section-title {
            color: #1e3a8a;
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 20px;
            text-align: center;
            position: relative;
            padding-bottom: 12px;
        }
        
        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 60px;
            height: 3px;
            background: linear-gradient(90deg, #3b82f6, #10b981);
            border-radius: 2px;
        }
        
        .arabic-section-title {
            font-family: 'Amiri', serif;
            font-size: 20px;
            color: #4a5568;
            margin-top: 5px;
            text-align: center;
        }
        
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
            margin-bottom: 30px;
        }
        
        .stat-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px 20px;
            text-align: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        
        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--accent-color);
        }
        
        .stat-card:nth-child(1) {
            --accent-color: #3b82f6;
        }
        
        .stat-card:nth-child(2) {
            --accent-color: #10b981;
        }
        
        .stat-card:nth-child(3) {
            --accent-color: #f59e0b;
        }
        
        .stat-card:nth-child(4) {
            --accent-color: #ef4444;
        }
        
        .stat-value {
            font-size: 28px;
            font-weight: 800;
            margin-bottom: 8px;
            color: var(--accent-color);
        }
        
        .stat-label {
            font-size: 13px;
            color: #64748b;
            font-weight: 600;
            line-height: 1.4;
        }
        
        .stat-label .arabic {
            font-family: 'Amiri', serif;
            display: block;
            margin-top: 4px;
            color: #94a3b8;
        }
        
        .filters-section {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 25px;
            margin-bottom: 30px;
        }
        
        .filter-tags {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            justify-content: center;
            margin-top: 15px;
        }
        
        .filter-tag {
            background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
            color: white;
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            box-shadow: 0 2px 6px rgba(59, 130, 246, 0.3);
        }
        
        .table-container {
            background: white;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        }
        
        .table-header {
            background: linear-gradient(135deg, #1e3a8a 0%, #2563eb 100%);
            color: white;
            padding: 20px;
            text-align: center;
        }
        
        .table-header h3 {
            margin: 0;
            font-size: 20px;
            font-weight: 700;
        }
        
        .table-header .arabic {
            font-family: 'Amiri', serif;
            font-size: 18px;
            margin-top: 5px;
            opacity: 0.9;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }
        
        th, td {
            padding: 16px 12px;
            text-align: right;
            border-bottom: 1px solid #f1f5f9;
        }
        
        th {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            font-weight: 700;
            color: #1e3a8a;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #3b82f6;
        }
        
        tr:nth-child(even) {
            background-color: #fafbfc;
        }
        
        tr:hover {
            background-color: #f0f9ff;
        }
        
        .customer-name {
            font-weight: 700;
            color: #1a202c;
            font-size: 14px;
        }
        
        .city-name {
            color: #64748b;
            font-weight: 500;
        }
        
        .amount {
            font-weight: 700;
            color: #1a202c;
            font-size: 13px;
        }
        
        .positive {
            color: #10b981;
            background: #dcfce7;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
        }
        
        .negative {
            color: #ef4444;
            background: #fce7f3;
            padding: 3px 8px;
            border-radius: 4px;
            font-weight: 700;
        }
        
        .no-data {
            text-align: center;
            padding: 60px 20px;
            color: #64748b;
            font-style: italic;
            background: #f8fafc;
        }
        
        .footer {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border-top: 1px solid #e2e8f0;
            padding: 25px 35px;
            text-align: center;
            color: #64748b;
            font-size: 13px;
        }
        
        .footer .system-name {
            font-weight: 700;
            color: #1e3a8a;
            font-size: 15px;
            margin-bottom: 5px;
        }
        
        .footer .arabic {
            font-family: 'Amiri', serif;
            color: #94a3b8;
            margin-bottom: 10px;
        }
        
        .footer .tagline {
            font-size: 11px;
            color: #9ca3af;
            margin-top: 8px;
            font-style: italic;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(90deg, transparent, #e2e8f0, transparent);
            margin: 25px 0;
        }
        
        @media print {
            body {
                margin: 0;
                padding: 15px;
                background: white;
            }
            
            .report-container {
                box-shadow: none;
                border-radius: 0;
            }
            
            .section {
                margin-bottom: 30px;
            }
            
            .stats-grid {
                gap: 15px;
            }
            
            .stat-card {
                padding: 20px 15px;
            }
        }
    </style>
</head>
<body>
    <div class="report-container">
        <div class="header">
            <h1 class="english-text">Comprehensive Financial Report</h1>
            <div class="arabic-title arabic-text">التقرير المالي الشامل</div>
            <p class="subtitle english-text">Generated on: {{ $generated_at }}</p>
        </div>

        <div class="content">
            <!-- Overall Statistics Section -->
            <div class="section">
                <h2 class="section-title english-text">Overall Statistics</h2>
                <div class="arabic-section-title arabic-text">الإحصائيات العامة</div>
                
                <div class="stats-grid">
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($statistics['overall_balance'], 2) }} ر.س</div>
                        <div class="stat-label english-text">Overall Balance</div>
                        <div class="stat-label arabic arabic-text">الرصيد الإجمالي</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($statistics['total_invoices'], 2) }} ر.س</div>
                        <div class="stat-label english-text">Total Invoices</div>
                        <div class="stat-label arabic arabic-text">إجمالي الفواتير</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($statistics['remaining_balance'], 2) }} ر.س</div>
                        <div class="stat-label english-text">Remaining Balance</div>
                        <div class="stat-label arabic arabic-text">الرصيد المتبقي</div>
                    </div>
                    <div class="stat-card">
                        <div class="stat-value">{{ number_format($statistics['percentage_remaining'], 2) }}%</div>
                        <div class="stat-label english-text">Percentage Remaining</div>
                        <div class="stat-label arabic arabic-text">النسبة المتبقية</div>
                    </div>
                </div>
            </div>

            <!-- Applied Filters Section -->
            @if(!empty($filters))
            <div class="section">
                <h2 class="section-title english-text">Applied Filters</h2>
                <div class="arabic-section-title arabic-text">الفلاتر المطبقة</div>
                
                <div class="filters-section">
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
            </div>
            @endif

            <!-- Customer Report Table Section -->
            <div class="section">
                <div class="table-container">
                    <div class="table-header">
                        <h3 class="english-text">Customer Financial Details</h3>
                        <div class="arabic arabic-text">تفاصيل العملاء المالية</div>
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
