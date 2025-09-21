<x-filament-panels::page>
    <div class="space-y-6">
        <div class="grid grid-cols-1 gap-6">
            <x-filament-widgets::widgets :columns="$this->getColumns()" :widgets="$this->getWidgets()" />
        </div>
    </div>
</x-filament-panels::page>
