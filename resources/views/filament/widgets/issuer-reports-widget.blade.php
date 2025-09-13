<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $this->getHeading() }}
        </x-slot>
        
        <x-slot name="description">
            {{ $this->getDescription() }}
        </x-slot>

        <div class="space-y-4">
            @foreach($this->getCustomerReportsByIssuer() as $issuer => $customers)
                <div class="bg-gradient-to-r from-purple-50 to-pink-50 dark:from-purple-900/20 dark:to-pink-900/20 rounded-xl p-4 border border-purple-200 dark:border-purple-800 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl flex items-center justify-center text-white font-bold mr-4">
                                {{ substr($issuer, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg">{{ $issuer }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $customers->count() }} Customers / عملاء</p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold text-gray-900 dark:text-white">
                                SAR {{ number_format($customers->sum('current_balance'), 2) }}
                            </div>
                            <div class="text-sm text-purple-600 dark:text-purple-400">Total Balance / إجمالي الرصيد</div>
                        </div>
                    </div>
                    
                    <!-- Progress bar showing percentage of total balance -->
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                            <span>% of Total / نسبة من الإجمالي</span>
                            <span>{{ number_format(($customers->sum('current_balance') / $this->getOverallCurrentBalance()) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-purple-500 to-pink-600 h-2 rounded-full" 
                                 style="width: {{ ($customers->sum('current_balance') / $this->getOverallCurrentBalance()) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($this->getCustomerReportsByIssuer()->isEmpty())
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                    </svg>
                    <p>No issuer data available / لا توجد بيانات للمُصدرين</p>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>