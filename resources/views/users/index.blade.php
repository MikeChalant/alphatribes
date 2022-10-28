<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('Admin Users') }}</x-slot>
        <a class="flex items-center space-x-1 border px-3 py-1 rounded-lg" href="{{ route('admin.user.create') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"></path></svg>
            <span>new</span>
        </a>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
        @if (count($users))
        <div class="overflow-x-hidden relative">
           <div class="overflow-x-auto">
                <div class="flex md:justify-end items-center pb-4 bg-white dark:bg-gray-900">
                <label for="table-search" class="sr-only">Search</label>
                <div class="relative flex-1">
                    <div class="flex absolute inset-y-0 left-0 items-center pl-3 pointer-events-none">
                        <svg class="w-5 h-5 text-gray-500 dark:text-gray-400" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path></svg>
                    </div>
                    <form action="{{ route('admin.user.search') }}" method="get">
                        <input type="text" name="q" id="table-search-users" class="block p-2 pl-10 w-full md:w-80 text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Search for users">
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
                            Phone No
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Country
                        </th>
                        <th scope="col" class="py-3 px-6">
                            Last Seen
                        </th>
                        <th scope="col" class="py-3 px-6">
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody id="adminUserTable">
                    @foreach ($users as $user)
                    <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600">
                        <td class="p-4 w-4">
                            {{$loop->iteration}}
                        </td>
                        <th scope="row" 
                            class="flex items-center py-4 px-6 text-gray-900 whitespace-nowrap dark:text-white">
                            <img class="w-10 h-10 rounded-full" src="{{ asset('images/profile/'.$user->user_image) }}" alt="{{ $user->name }} image">
                            <div class="pl-3">
                                <div class="text-base font-semibold">{{ $user->name }}</div>
                                <div class="font-normal text-gray-500">{{ $user->email }}</div>
                            </div>  
                        </th>
                        <td class="py-4 px-6 whitespace-nowrap">
                            {{ $user->phone_no }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex items-center whitespace-nowrap">
                                <div class="h-2.5 w-2.5 rounded-full bg-green-400 mr-2"></div> Online
                            </div>
                        </td>
                        <td class="py-4 px-6 whitespace-nowrap">
                            {{ date('M d, Y H:i:s A') }}
                        </td>
                        <td class="py-4 px-6">
                            <div class="flex space-x-3">
                                <a href="{{ route('admin.user.delete', $user->id) }}" class="font-medium text-gray-600 dark:text-gray-500 hover:underline"
                                    onclick="confirmDelete(event,'deleteUserForm{{ $user->id }}', 'Delete User')"
                                >
                                    <form id="deleteUserForm{{ $user->id }}" action="{{ route('admin.user.delete', $user->id) }}" method="post">
                                        @csrf @method('delete')</form>
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                </a>
                                <a href="javascript://" class="font-medium text-gray-600 dark:text-gray-500 hover:underline"
                                    data-modal-toggle="admin-user-modal{{ $loop->iteration }}">
                                    <svg class="w-6 h-6 js-show-admin-user" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
                                </a>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                   
                </tbody>
            </table>
           </div>
        </div>
        @else
        <p class="text-lg font-bold">No users found</p>
        @endif
    </section>
    @include('partials.admin_user_modal',$users)
</x-app-layout>