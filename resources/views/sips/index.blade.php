<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('SIPs') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="w-full px-2">
            <div class="bg-white overflow-hidden shadow-sm rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="row section-header pb-4">
                        <p class="text-xl font-bold">{{ __('SIPs') }}</p>
                        <x-a href="{{ route('sips.create') }}">{{ __('Create SIP') }}</x-a>
                    </div>
                    
                    <div class="grid grid-cols-5 gap-4 pt-5">
                        <x-datatable-enteries-per-page />
                        <x-datatable-search />
                        <div class="col-span-3"></div>
                    </div>
                    <div class="mt-4 overflow-x-auto">
                        <table id="sips" class="w-full min-w-full mt-6"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script type="module">
        var cancelURL = "{{ route('sips.cancel', ':sipId') }}";

        $(document).ready(function() {
            window.dataTable = $("#sips").DataTable({
                ...window.datatableConfig,
                responsive: true,
                ajax: {
                    url: "{{ route('sips.datatable') }}",
                },
                columns: [{
                        title: "Amount",
                        data: "amount",
                        width: "15%"
                    },
                    {
                        title: "Frequency",
                        data: "frequency",
                        width: "15%"
                    },
                    {
                        title: "SIP Date",
                        data: "sip_day",
                        width: "10%",
                        render: function(data, type, row) {
                            return data ?? '-';
                        }
                    },
                    {
                        title: "Start Date",
                        data: "start_date",
                        width: "20%",
                        render: function (data) {
                            return data ? moment(data).format('DD-MM-YYYY') : '-';
                        }
                    },
                    {
                        title: "End Date",
                        data: "end_date",
                        width: "20%",
                        render: function (data) {
                            return data ? moment(data).format('DD-MM-YYYY') : '-';
                        }
                    },
                    {
                        title: "Status",
                        data: "status",
                        width: "10%",
                        render: function(data) {
                            return data.charAt(0).toUpperCase() + data.slice(1);
                        }
                    },
                    {
                        title: "Actions",
                        data: "id",
                        width: "10%",
                        sortable: false,
                        searchable: false,
                        render: function(data, type, row) {
                            return row.status === 'active' ? 
                                `<div style="display: inline-flex;">
                                    <a href="#" data-id="${data}" class="cancel-sip-link text-yellow-600 hover:underline">Cancel</a>
                                </div>`
                                : '';
                        }
                    }
                ],
            });

            $(document).on('click', '.cancel-sip-link', function(e) {
                e.preventDefault();
                const id = $(this).data('id');
                if (confirm(`Are you sure you want to cancel SIP`)) {
                    $.ajax({
                        url: cancelURL.replace(':sipId', id),
                        type: 'POST',
                        data: {
                            _method: 'PATCH',
                            _token: '{{ csrf_token() }}'
                        },
                        success: function(response) {
                            if (response.status) {
                                showSuccess(response.message || 'SIP cancelled successfully!');
                            } else {
                                showError(response.message || 'Failed to cancel SIP.');
                            }
                            window.dataTable.ajax.reload();
                        },
                        error: function() {
                            showError('Something went wrong while cancelling the SIP.');
                        }
                    });
                }
            });
        });
    </script>
</x-app-layout>