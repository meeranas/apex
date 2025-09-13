<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Transaction;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        // Create sample customers
        $customers = [
            [
                'customer_name' => 'Ahmed Mohamed Ali / أحمد محمد علي العلي',
                'account_number' => 'ACC001',
                'city' => 'Riyadh / الرياض',
                'representative_name' => 'Salem Ahmed / سالم أحمد',
                'mobile_number' => '+966501234567',
                'address' => 'Riyadh / شارع الملك فهد، الرياض / King Fahd Street, Riyadh',
                'remarks' => 'Premium Customer / عميل مميز',
                'old_balance' => 0,
            ],
            [
                'customer_name' => 'Fatima Al-Saad / فاطمة السعد',
                'account_number' => 'ACC002',
                'city' => 'Jeddah / جدة',
                'representative_name' => 'Khaled Al-Nour / خالد النور',
                'mobile_number' => '+966502345678',
                'address' => 'Jeddah / حي الروضة، جدة / Al-Rawdah District, Jeddah',
                'remarks' => 'New Customer / عميل جديد',
                'old_balance' => 0,
            ],
            [
                'customer_name' => 'Mohamed Abdullah / محمد عبدالله',
                'account_number' => 'ACC003',
                'city' => 'Dammam / الدمام',
                'representative_name' => 'Abdulrahman Al-Qahtani / عبدالرحمن القحطاني',
                'mobile_number' => '+966503456789',
                'address' => 'Dammam / المنطقة الشرقية، الدمام / Eastern Province, Dammam',
                'remarks' => 'Regular Customer / عميل منتظم',
                'old_balance' => 2500.00,
            ],
            [
                'customer_name' => 'Noura Al-Shammari / نورا الشمري',
                'account_number' => 'ACC004',
                'city' => 'Riyadh / الرياض',
                'representative_name' => 'Abdulaziz Al-Mutairi / عبدالعزيز المطيري',
                'mobile_number' => '+966504567890',
                'address' => 'Riyadh / حي النرجس، الرياض / Al-Narjis District, Riyadh',
                'remarks' => 'VIP Customer / عميل VIP',
                'old_balance' => 0,
            ],
            [
                'customer_name' => 'Abdullah Al-Saeed / عبدالله السعيد',
                'account_number' => 'ACC005',
                'city' => 'Mecca / مكة المكرمة',
                'representative_name' => 'Youssef Al-Harthi / يوسف الحارثي',
                'mobile_number' => '+966505678901',
                'address' => 'Mecca / حي الزاهر، مكة / Al-Zahir District, Mecca',
                'remarks' => 'Trusted Customer / عميل موثوق',
                'old_balance' => 5000.00,
            ],
        ];

        foreach ($customers as $customerData) {
            $customer = Customer::create($customerData);

            // Create sample invoices for each customer
            $invoices = [
                [
                    'invoice_number' => 'INV-' . $customer->id . '-001',
                    'goods_delivery_document_number' => 'GD-' . $customer->id . '-001',
                    'invoice_date' => now()->subDays(rand(1, 30)),
                    'customer_id' => $customer->id,
                    'customer_city' => $customer->city,
                    'customer_name' => $customer->customer_name,
                    'due_date' => now()->addDays(rand(15, 45)),
                    'remarks' => 'Regular Invoice / فاتورة عادية',
                    'issuer_name' => $customer->representative_name,
                ],
                [
                    'invoice_number' => 'INV-' . $customer->id . '-002',
                    'goods_delivery_document_number' => 'GD-' . $customer->id . '-002',
                    'invoice_date' => now()->subDays(rand(1, 15)),
                    'customer_id' => $customer->id,
                    'customer_city' => $customer->city,
                    'customer_name' => $customer->customer_name,
                    'due_date' => now()->addDays(rand(20, 60)),
                    'remarks' => 'Special Invoice / فاتورة خاصة',
                    'issuer_name' => $customer->representative_name,
                ],
            ];

            foreach ($invoices as $invoiceData) {
                $invoice = Invoice::create($invoiceData);

                // Create 2-4 random invoice items for each invoice
                $itemCount = rand(2, 4);
                $totalYards = 0;
                $totalAmount = 0;

                for ($i = 1; $i <= $itemCount; $i++) {
                    $yards = rand(10, 100);
                    $pricePerYard = rand(50, 200);
                    $total = $yards * $pricePerYard;

                    InvoiceItem::create([
                        'invoice_id' => $invoice->id,
                        'item_name' => 'Product ' . $i . ' / منتج ' . $i,
                        'item_number' => rand(1000, 9999),
                        'yards' => $yards,
                        'price_per_yard' => $pricePerYard,
                        'total' => $total,
                    ]);

                    $totalYards += $yards;
                    $totalAmount += $total;
                }

            }

            // Create sample transactions for each customer
            $transactions = [
                [
                    'type' => 'debit',
                    'document_number' => 'DEB-' . $customer->id . '-001',
                    'transaction_date' => now()->subDays(rand(1, 20)),
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->customer_name,
                    'customer_city' => $customer->city,
                    'amount' => rand(1000, 5000),
                    'payment_method' => ['cash', 'check', 'bank_transfer', 'credit_card'][rand(0, 3)],
                    'remarks' => 'Cash Payment / دفعة نقدية',
                    'issuer_name' => $customer->representative_name,
                ],
                [
                    'type' => 'discount',
                    'document_number' => 'DIS-' . $customer->id . '-001',
                    'transaction_date' => now()->subDays(rand(1, 10)),
                    'customer_id' => $customer->id,
                    'customer_name' => $customer->customer_name,
                    'customer_city' => $customer->city,
                    'amount' => rand(100, 1000),
                    'remarks' => 'Special Discount / خصم خاص',
                    'issuer_name' => $customer->representative_name,
                ],
            ];

            foreach ($transactions as $transactionData) {
                Transaction::create($transactionData);
            }
        }
    }
}
