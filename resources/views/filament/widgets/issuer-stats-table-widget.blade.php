<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Issuer Statistics / إحصائيات الموظفين
        </x-slot>
        <x-slot name="description">
            Overall remaining balance and payment percentage for each issuer (not affected by filters) / إجمالي الرصيد المتبقي ونسبة الدفع لكل موظف (غير متأثر بالمرشحات)
        </x-slot>
        
        <div class="overflow-x-auto">
            <table class="w-full divide-y divide-gray-200 dark:divide-gray-700">
                <thead class="bg-gray-50 dark:bg-gray-800">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Issuer / الموظف
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Remaining Balance / الرصيد المتبقي
                        </th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 dark:text-gray-400 uppercase tracking-wider">
                            Payment % / نسبة الدفع
                        </th>
                    </tr>
                </thead>
                <tbody class="bg-white dark:bg-gray-900 divide-y divide-gray-200 dark:divide-gray-700">
                    @foreach($this->getIssuerStats() as $stat)
                        <tr class="hover:bg-gray-50 dark:hover:bg-gray-800">
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900 dark:text-gray-100">
                                {{ $stat['issuer_name'] }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $stat['remaining_balance'] > 0 ? 'text-yellow-600 dark:text-yellow-400' : 'text-green-600 dark:text-green-400' }}">
                                {{ number_format($stat['remaining_balance'], 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold {{ $stat['payment_percentage'] >= 80 ? 'text-green-600 dark:text-green-400' : ($stat['payment_percentage'] >= 50 ? 'text-yellow-600 dark:text-yellow-400' : 'text-red-600 dark:text-red-400') }}">
                                {{ number_format($stat['payment_percentage'], 2) }}%
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
