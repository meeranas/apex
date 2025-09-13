<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $this->getHeading() }}
        </x-slot>
        
        <x-slot name="description">
            {{ $this->getDescription() }}
        </x-slot>

        <div class="space-y-4">
            @foreach($this->getCustomerReportsByCity() as $city => $customers)
                <div class="bg-gradient-to-r from-emerald-50 to-teal-50 dark:from-emerald-900/20 dark:to-teal-900/20 rounded-xl p-4 border border-emerald-200 dark:border-emerald-800 hover:shadow-lg transition-all duration-200">
                    <div class="flex items-center justify-between">
                        <div class="flex items-center">
                            <div class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-teal-600 rounded-xl flex items-center justify-center text-white font-bold mr-4">
                                {{ substr($city, 0, 2) }}
                            </div>
                            <div>
                                <h4 class="font-bold text-gray-900 dark:text-white text-lg">{{ $city }}</h4>
                                <p class="text-sm text-gray-600 dark:text-gray-400">{{ $customers->count() }} Customers / عملاء </p>
                            </div>
                        </div>
                        <div class="text-right">
                            <div class="text-xl font-bold text-gray-900 dark:text-white">
                                SAR {{ number_format($customers->sum('current_balance'), 2) }}
                            </div>
                            <div class="text-sm text-emerald-600 dark:text-emerald-400">Total Balance / إجمالي الرصيد</div>
                        </div>
                    </div>
                    
                    <!-- Progress bar showing percentage of total balance -->
                    <div class="mt-4">
                        <div class="flex justify-between text-xs text-gray-600 dark:text-gray-400 mb-1">
                            <span>% of Total / نسبة من الإجمالي</span>
                            <span>{{ number_format(($customers->sum('current_balance') / $this->getOverallCurrentBalance()) * 100, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 dark:bg-gray-700 rounded-full h-2">
                            <div class="bg-gradient-to-r from-emerald-500 to-teal-600 h-2 rounded-full" 
                                 style="width: {{ ($customers->sum('current_balance') / $this->getOverallCurrentBalance()) * 100 }}%"></div>
                        </div>
                    </div>
                </div>
            @endforeach
            
            @if($this->getCustomerReportsByCity()->isEmpty())
                <div class="text-center py-8 text-gray-500 dark:text-gray-400">
                    <svg class="w-12 h-12 mx-auto mb-4 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <p>No city data available / لا توجد بيانات للمدن</p>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>