<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Invoices') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row justify-content-between pb-4">
                        <p class="text-xl font-bold">{{ __('Invoices') }}</p>
                    </div>
                    <div class="grid grid-cols-5 gap-4 pt-5">
                        <x-datatable-enteries-per-page />
                        <x-datatable-search />
                        <div class="col-span-3"></div>
                    </div>
                    <div class="mt-4 overflow-x-auto">
                        <table id="invoices" class="w-full"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        $(document).ready(function() {
            window.invoiceTable = $("#invoices").DataTable({
                ...window.datatableConfig,
                responsive: true,
                ajax: {
                    url: "{{ route('invoices.datatable') }}",
                },
                columns: [
                    { title: "SIP Amount", data: "amount" },
                    {
                        title: "Scheduled Date",
                        data: "scheduled_date",
                        render: function (data) {
                            return data ? moment(data).format('DD-MM-YYYY') : '-';
                        }
                    },
                    { title: "Status", data: "status" },
                    {
                        title: "Download",
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            if (row.status && row.status.toLowerCase() === 'success') {
                                return `<div class='flex justify-center'>
                                    <a href="/invoices/${row.id}/download" target="_blank" title="Download PDF">
                                        <svg xmlns='http://www.w3.org/2000/svg' class='h-5 w-5 text-blue-600' fill='none' viewBox='0 0 24 24' stroke='currentColor'><path stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5m0 0l5-5m-5 5V4' /></svg>
                                    </a>
                                </div>`;
                            }
                            return '';
                        }
                    },
                ],
            });
        });
    </script>
</x-app-layout> 