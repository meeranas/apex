<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Comprehensive Report Generator / مولد التقرير الشامل
        </x-slot>

        <x-slot name="description">
            Generate detailed PDF reports with advanced filtering options / إنشاء تقارير PDF مفصلة مع خيارات فلترة متقدمة
        </x-slot>

        {{ $this->form }}

        <div class="flex justify-end gap-3 mt-6">
            <x-filament::button
                type="button"
                color="gray"
                wire:click="clearFilters"
            >
                Clear Filters / مسح الفلاتر
            </x-filament::button>

            <x-filament::button
                type="button"
                color="primary"
                wire:click="generateReport"
                icon="heroicon-o-document-arrow-down"
            >
                Generate Report / إنشاء التقرير
            </x-filament::button>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
