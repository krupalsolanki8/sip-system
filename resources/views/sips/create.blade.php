<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create SIP') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <section>
                    <header>
                        <h2 class="text-xl font-bold text-gray-900 mb-5">
                            {{ __('SIP Information') }}
                        </h2>
                    </header>
                    <form method="POST" action="{{ route('sips.store') }}" class="space-y-4 grid grid-cols-1 md:grid-cols-2 gap-x-4 gap-y-2">
                        @csrf
                        <div>
                            <x-input-label for="amount" :value="__('Amount')" class="required" />
                            <x-text-input id="amount" name="amount" type="number" min="1" step="0.01" :value="old('amount')" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('amount')" />
                        </div>
                        <div>
                            <x-input-label for="frequency" :value="__('Frequency')" class="required" />
                            <select name="frequency" id="frequency" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required onchange="toggleSipDay()">
                                <option value="daily" {{ old('frequency') == 'daily' ? 'selected' : '' }}>Daily</option>
                                <option value="monthly" {{ old('frequency') == 'monthly' ? 'selected' : '' }}>Monthly</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('frequency')" />
                        </div>
                        <div id="sip_day_field" style="display: {{ old('frequency') == 'monthly' ? 'block' : 'none' }};">
                            <x-input-label for="sip_day" :value="__('SIP Date (1-30)')" />
                            <select id="sip_day" name="sip_day" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Select Date</option>
                                @for ($i = 1; $i <= 30; $i++)
                                    <option value="{{ $i }}" {{ old('sip_day') == $i ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('sip_day')" />
                        </div>
                        <div>
                            <x-input-label for="start_date" :value="__('Start Date')" class="required" />
                            <x-text-input id="start_date" name="start_date" type="date" :value="old('start_date')" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('start_date')" />
                        </div>
                        <div>
                            <x-input-label for="end_date" :value="__('End Date')" class="required" />
                            <x-text-input id="end_date" name="end_date" type="date" :value="old('end_date')" class="mt-1 block w-full" required />
                            <x-input-error class="mt-2" :messages="$errors->get('end_date')" />
                        </div>
                        <div class="col-span-2 flex justify-end space-x-2 mt-4">
                            <x-primary-button>{{ __('Create') }}</x-primary-button>
                        </div>
                    </form>
                </section>
            </div>
        </div>
    </div>
    <script>
    function toggleSipDay() {
        var freq = document.getElementById('frequency').value;
        document.getElementById('sip_day_field').style.display = (freq === 'monthly') ? 'block' : 'none';
    }
    </script>
</x-app-layout> 