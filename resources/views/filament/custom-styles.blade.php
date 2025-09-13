<style>
    /* Enhanced custom table header styling for bilingual headers */
    .fi-ta-table th,
    .filament-table th {
        /* white-space: pre-line !important; */
        line-height: 1.4 !important;
        vertical-align: top !important;
        padding: 16px 12px !important;
        height: auto !important;
        min-height: 70px !important;
        text-align: left !important;
        position: relative !important;
    }

    .fi-ta-table th .fi-ta-header-cell-label,
    .filament-tables-header-cell-label,
    .fi-ta-table th .fi-ta-header-cell-label span,
    .filament-table th .filament-tables-header-cell-label,
    .filament-table th .fi-ta-header-cell-label,
    .filament-table th .fi-ta-header-cell-label span,
    .fi-ta-table th .fi-ta-header-cell-label .fi-ta-header-cell-label-text,
    .filament-tables-header-cell-label-text {
        white-space: pre-line !important;
        line-height: 1.4 !important;
        display: block !important;
        text-align: left !important;
        font-size: 0.875rem !important;
        font-weight: 500 !important;
        color: rgb(55 65 81) !important;
        padding-right: 20px !important;
    }

    /* Style the English text (first line) */
    .fi-ta-table th .fi-ta-header-cell-label::first-line,
    .filament-tables-header-cell-label::first-line {
        font-weight: 600 !important;
        color: rgb(17 24 39) !important;
        font-size: 0.875rem !important;
    }

    /* Style the Arabic text (second line) */
    .fi-ta-table th .fi-ta-header-cell-label::after,
    .filament-tables-header-cell-label::after {
        content: "" !important;
        display: block !important;
        margin-top: 2px !important;
    }

    /* Ensure proper spacing for dropdown icons */
    .fi-ta-table th .fi-ta-header-cell-label,
    .filament-tables-header-cell-label {
        padding-right: 20px !important;
    }

    /* Style the sort/dropdown icons */
    .fi-ta-table th .fi-ta-header-cell-sort-button,
    .filament-tables-header-cell-sort-button {
        position: absolute !important;
        right: 8px !important;
        top: 50% !important;
        transform: translateY(-50%) !important;
        margin-top: 0 !important;
    }

    /* Ensure the header cell has relative positioning */
    .fi-ta-table th,
    .filament-table th {
        position: relative !important;
    }

    /* Better spacing for the header content */
    .fi-ta-table th .fi-ta-header-cell,
    .filament-tables-header-cell {
        padding: 0 !important;
        height: auto !important;
        min-height: 60px !important;
    }

    /* Additional styling for better appearance */
    .fi-ta-table th .fi-ta-header-cell-label,
    .filament-tables-header-cell-label {
        margin-bottom: 0 !important;
    }

    /* Ensure proper text direction for Arabic */
    .fi-ta-table th .fi-ta-header-cell-label,
    .filament-tables-header-cell-label {
        direction: ltr !important;
    }

    /* Style for the second line (Arabic text) */
    .fi-ta-table th .fi-ta-header-cell-label::after,
    .filament-tables-header-cell-label::after {
        content: "" !important;
        display: block !important;
        margin-top: 4px !important;
        font-size: 0.8rem !important;
        color: rgb(75 85 99) !important;
        font-weight: 400 !important;
    }
</style>