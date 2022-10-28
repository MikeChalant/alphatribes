<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('Admin Users') }}</x-slot>
        <a class="flex items-center space-x-1 border px-3 py-1 rounded-lg" href="{{ route('admin.country.create') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
            <span>new</span>
        </a>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
        @if (count($countries))
        <div class="overflow-x-hidden relative">
            <div class="overflow-x-auto">
                <div class="flex md:justify-end items-center pb-4 bg-white dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative flex-1">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <form action="{{ route('admin.country.search') }}" method="get">
                        <input type="text" name="q" id="table-search-countries" class="block p-2 pl-10 w-full md:w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for country">
                    </form>
                </div>
            </div>
            <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="p-4">
                            #
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Name
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Code
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Currency
                        </th>
                        <th scope="col" class="py-3 px-6">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($countries as $country)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="p-4 w-4">
                            {{$loop->iteration}}
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            {{ $country->country_name }}
                        </td>
                        <td class="py-4 px-6">
                            {{ $country->country_code }}
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            {{ $country->currency_symbol }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.country.delete', $country->id) }}" class="font-medium text-gray-600 dark:text-gray-500 hover:underline"
                                    onclick="confirmDelete(event,'deleteCountryForm{{ $country->id }}','Delete Country')"
                                >
                                    <form id="deleteCountryForm{{ $country->id }}" action="{{ route('admin.country.delete', $country->id) }}" method="post">
                                        @csrf @method('delete')</form>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                                <a href="javascript://" class="font-medium text-gray-600 dark:text-gray-500 hover:underline"
                                    data-modal-toggle="country-modal{{ $loop->iteration }}">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
            </div>
        </div>
        <div class="my-3">
            {{ $countries->links() }}
        </div>
        @else
        <p class="text-lg font-bold">No country found</p>
        @endif
    </section>
    @include('partials.country_modal',$countries)
</x-app-layout>