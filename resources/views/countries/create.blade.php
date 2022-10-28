<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('New Country') }}</x-slot>
        <a class="flex items-center space-x-1 border px-3 py-1 rounded-lg" href="{{ route('admin.country.index') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            <span>Countries</span>
        </a>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
        <form method="POST" action={{ route('admin.country.store') }} enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="United Kingdom" required>
                    @if ($errors->has('name'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div>
                    <label for="code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Code</label>
                    <input type="text" name="code" id="code" maxlength="4"
                        value="{{ old('code') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+1" required>
                    @if ($errors->has('code'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('code') }}</span>
                    @endif
                </div>  
                <div>
                    <label for="currency_code" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Currency code</label>
                    <input type="text" name="currency_code" id="currency_code" maxlength="3"
                        value="{{ old('currency_code') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="alphatribesignals.com">
                    @if ($errors->has('currency_code'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('currency_code') }}</span>
                    @endif
                </div>
            </div>
            <button type="submit" class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </form>
    </section>
</x-app-layout>