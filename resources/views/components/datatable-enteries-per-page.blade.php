<div {{ $attributes }}>
    <x-input-dropdown id="datatable-enteries-per-page" onchange="window.dataTable?.page.len(this.value).draw()">
        <option value="10">10</option>
        <option value="25">25</option>
        <option value="50">50</option>
        <option value="100">100</option>
    </x-input-dropdown>
</div>