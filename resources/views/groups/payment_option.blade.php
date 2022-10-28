<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('Payment Option') }}</x-slot>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
        <form id="allow_trial_form" onsubmit="allowTrial(event)" method="POST" action="{{ route('admin.group.save_payment_option', $groupId) }}">
            @csrf
            @method('patch')
            <div class="flex mb-6 space-x-6">
                <div class="flex items-center pl-4">
                    <input @if(old('payment_option') && old('payment_option') === 'onetime') checked @endif 
                    @if(!old('payment_option')) checked @endif id="onetime" onchange="togglePaymentOption(event)" 
                    type="radio" value="onetime" name="payment_option" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="onetime" class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Onetime</label>
                </div>
                <div class="flex items-center pl-4">
                    <input @if(old('payment_option') && old('payment_option') === 'recurring') checked @endif
                     onchange="togglePaymentOption(event)" id="recurring" type="radio" value="recurring" name="payment_option" class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
                    <label for="recurring" class="py-4 ml-2 w-full text-sm font-medium text-gray-900 dark:text-gray-300">Recurring</label>
                </div> 
            </div>
            <div id="onetime_payment_option" 
                class="@if(old('payment_option') && old('payment_option') === 'recurring') hidden @else grid @endif gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="onetime_cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Onetime Cost</label>
                    <input type="text" name="onetime_cost" id="onetime_cost" 
                        value="{{ old('onetime_cost') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($errors->has('onetime_cost'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('onetime_cost') }}</span>
                    @endif
                </div> 
            </div>
            <div id="recurring_payment_option" class="@if(old('payment_option') && old('payment_option') === 'recurring') grid @else hidden @endif gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="daily_cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Daily Cost</label>
                    <input type="text" name="daily_cost" id="daily_cost" 
                        value="{{ old('daily_cost') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($errors->has('daily_cost'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('daily_cost') }}</span>
                    @endif
                </div>
                <div>
                    <label for="weekly_cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Weekly Cost</label>
                    <input type="text" name="weekly_cost" id="weekly_cost" 
                        value="{{ old('weekly_cost') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($errors->has('weekly_cost'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('weekly_cost') }}</span>
                    @endif
                </div> 
                <div>
                    <label for="monthly_cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Monthly Cost</label>
                    <input type="text" name="monthly_cost" id="monthly_cost" 
                        value="{{ old('monthly_cost') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($errors->has('monthly_cost'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('monthly_cost') }}</span>
                    @endif
                </div> 
                <div>
                    <label for="yearly_cost" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Yearly Cost</label>
                    <input type="text" name="yearly_cost" id="yearly_cost" 
                        value="{{ old('yearly_cost') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    @if ($errors->has('yearly_cost'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('yearly_cost') }}</span>
                    @endif
                </div> 
            </div>
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="billing_currency" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Billing Currency</label>
                    <select name="billing_currency" id="billing_currency" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($currency_codes as $currency)
                            <option value="{{ $currency->currency_code }}">{{ $currency->currency_code }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('billing_currency'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('billing_currency') }}</span>
                    @endif
                </div>
            </div>
            <input type="hidden" name="allow_trial" id="allow_trial" value="0">
           
            <button type="submit" class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </form>
    </section>
</x-app-layout>