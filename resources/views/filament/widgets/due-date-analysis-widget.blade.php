<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            {{ $this->getHeading() }}
        </x-slot>

        <x-slot name="description">
            {{ $this->getDescription() }}
        </x-slot>

        <div class="space-y-6">
            <!-- Due Date Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Overdue -->
                <div
                    class="bg-gradient-to-r from-red-50 to-red-100 dark:from-red-900/20 dark:to-red-800/20 rounded-xl p-6 border-l-4 border-red-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-red-500 rounded-xl flex items-center justify-center text-white font-bold mr-4">

                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Overdue / متأخرة </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Past due date</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="text-3xl font-bold text-red-600 dark:text-red-400">
                                    {{ $this->getOverdueCustomersCount() }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Customers / عملاء </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Due Soon -->
                <div
                    class="bg-gradient-to-r from-yellow-50 to-yellow-100 dark:from-yellow-900/20 dark:to-yellow-800/20 rounded-xl p-6 border-l-4 border-yellow-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-yellow-500 rounded-xl flex items-center justify-center text-white font-bold mr-4">

                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">Due Soon / قريب
                                        الاستحقاق</h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">Within 30 days</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">
                                    {{ $this->getDueSoonCustomersCount() }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Customers / عملاء</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- On Time -->
                <div
                    class="bg-gradient-to-r from-green-50 to-green-100 dark:from-green-900/20 dark:to-green-800/20 rounded-xl p-6 border-l-4 border-green-500">
                    <div class="flex items-center justify-between">
                        <div>
                            <div class="flex items-center">
                                <div
                                    class="w-12 h-12 bg-green-500 rounded-xl flex items-center justify-center text-white font-bold mr-4">

                                </div>
                                <div>
                                    <h3 class="text-lg font-bold text-gray-900 dark:text-white">On Time / في الموعد
                                    </h3>
                                    <p class="text-sm text-gray-600 dark:text-gray-400">30+ days remaining</p>
                                </div>
                            </div>
                            <div class="mt-4">
                                <div class="text-3xl font-bold text-green-600 dark:text-green-400">
                                    {{ $this->getOnTimeCustomersCount() }}
                                </div>
                                <div class="text-sm text-gray-600 dark:text-gray-400">Customers / عملاء </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Due Date Legend
            <div class="bg-gradient-to-r from-gray-50 to-gray-100 dark:from-gray-800 dark:to-gray-700 rounded-xl p-6">
                <h4 class="text-lg font-bold text-gray-900 dark:text-white mb-4 flex items-center">
                    📋 مفتاح الألوان / Color Legend
                </h4>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-red-500 rounded-full"></div>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">متأخرة / Overdue</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Past due date</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-yellow-500 rounded-full"></div>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">قريب الاستحقاق / Due Soon</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">Within 30 days</div>
                        </div>
                    </div>
                    <div class="flex items-center space-x-3">
                        <div class="w-6 h-6 bg-green-500 rounded-full"></div>
                        <div>
                            <div class="font-medium text-gray-900 dark:text-white">On Time / في الموعد</div>
                            <div class="text-sm text-gray-600 dark:text-gray-400">30+ days remaining</div>
                        </div>
                    </div>
                </div>
            </div> -->
        </div>
    </x-filament::section>
</x-filament-widgets::widget>