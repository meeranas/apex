<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $this->getHeading() }}
        </x-slot>

        <x-slot name="description">
            {{ $this->getDescription() }}
        </x-slot>

        <div class="space-y-6">
            <!-- Summary Stats -->

            <!-- Customer Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200 dark:divide-gray-700">
                    <thead class="bg-gray-50 dark:bg-gray-700">
                        <tr>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Customer / العميل
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                City / المدينة
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Issuer / المُصدر
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Balance / الرصيد
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Payment % / نسبة الدفع
                            </th>
                            <th
                                class="px-6 py-3 text-left text-xs font-bold text-gray-700 dark:text-gray-300 uppercase tracking-wider">
                                Due Date / تاريخ الاستحقاق
                            </th>
                        </tr>
                    </thead>
                    <tbody class="bg-white dark:bg-gray-800 divide-y divide-gray-200 dark:divide-gray-700">
                        @foreach($this->getCustomerReports() as $index => $report)
                            <tr
                                class="hover:bg-gradient-to-r hover:from-blue-50 hover:to-indigo-50 dark:hover:from-gray-700 dark:hover:to-gray-600 transition-all duration-200 {{ $index % 2 === 0 ? 'bg-gray-50/50 dark:bg-gray-800/50' : '' }}">
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="items-left">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center text-white font-bold text-sm mr-4">
                                            {{ substr($report['customer_name'], 0, 2) }}
                                        </div>
                                        <div>
                                            <div class="text-sm font-bold text-gray-900 dark:text-white">
                                                {{ $report['customer_name'] }}
                                            </div>
                                            <!-- <div class="text-xs text-gray-500 dark:text-gray-400">Account #{{ $index + 1 }}</div> -->
                                        </div>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-white">{{ $report['city'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                        <span
                                            class="text-sm font-medium text-gray-900 dark:text-white">{{ $report['issuer'] }}</span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-2 h-2 bg-gradient-to-r from-green-400 to-blue-500 rounded-full mr-2">
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            SAR {{ number_format($report['current_balance'], 2) }}
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="w-16 bg-gray-200 dark:bg-gray-700 rounded-full h-2 mr-3">
                                            <div class="bg-gradient-to-r from-blue-500 to-indigo-600 h-2 rounded-full"
                                                style="width: {{ min(100, max(0, $report['payment_percentage'])) }}%"></div>
                                        </div>
                                        <span class="text-sm font-bold text-gray-900 dark:text-white">
                                            {{ number_format($report['payment_percentage'], 1) }}%
                                        </span>
                                    </div>
                                </td>
                                <td class="px-6 py-6 whitespace-nowrap">
                                    @if($report['due_date_status']['status'] !== 'no_date')
                                        <div class="flex flex-col">
                                            <span
                                                class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $report['due_date_status']['class'] }} mb-1">
                                                {{ $report['due_date_status']['text'] }}
                                            </span>
                                            <span class="text-xs text-gray-500 dark:text-gray-400">
                                                {{ $report['due_date_status']['days'] ?? '' }}
                                            </span>
                                        </div>
                                    @else
                                        <span
                                            class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-800 dark:bg-gray-700 dark:text-gray-300">
                                            No Due Date
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot class="bg-gradient-to-r from-gray-100 to-gray-200 dark:from-gray-700 dark:to-gray-600">
                        <tr>
                            <td colspan="3" class="px-6 py-6 text-lg font-bold text-gray-900 dark:text-white">
                                Grand Total / المجموع الكلي
                            </td>
                            <td
                                class="text-center font-bold text-gray-900 dark:text-white text-sm font-bold text-gray-900 dark:text-white">
                                <!-- SAR {{ number_format($this->getOverallCurrentBalance(), 2) }} -->
                            </td>
                            <td colspan="2" class="px-6 py-6"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>