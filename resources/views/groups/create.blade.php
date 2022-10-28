<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('New Group') }}</x-slot>
        <a class="flex items-center space-x-1 border px-3 py-1 rounded-lg" href="{{ route('admin.group.index') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span>Groups</span>
        </a>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
        <form method="POST" action={{ route('admin.group.store') }} enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="group_name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                    <input type="text" name="group_name" id="group_name"
                        value="{{ old('group_name') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Muse Signals" required>
                    @if ($errors->has('group_name'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('group_name') }}</span>
                    @endif
                </div>
                <div>
                    <label for="support_email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Support Email</label>
                    <input type="text" name="support_email" id="support_email"
                        value="{{ old('support_email') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="notaplayboy@tribe.com" required>
                    @if ($errors->has('support_email'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('support_email') }}</span>
                    @endif
                </div>  
                <div>
                    <label for="website" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Website/Lintree Url</label>
                    <input type="url" name="website" id="website"
                        value="{{ old('website') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="alphatribesignals.com">
                    @if ($errors->has('website'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('website') }}</span>
                    @endif
                </div>
                <div>
                    <label for="category_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Category</label>
                    <select name="category_id" id="category_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        @foreach ($categories as $category)
                            <option value="{{ $category->id }}">{{ $category->category_name }}</option>
                        @endforeach
                    </select>
                    @if ($errors->has('category_id'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('category_id') }}</span>
                    @endif
                </div>
            </div>
            <div class="mb-6">
                <label for="description" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Description</label>
                <input type="text" name="description" id="description" 
                    value="{{ old('description') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="I got a simple life..." required>
                @if ($errors->has('description'))
                    <span class="text-red-400 mt-1 text-sm">{{ $errors->first('description') }}</span>
                @endif
            </div> 
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="group_image">Group Image</label>
                <input name="group_image" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="group_image" type="file">
                @if ($errors->has('group_image'))
                    <span class="text-red-400 mt-1 text-sm">{{ $errors->first('group_image') }}</span>
                @endif
            </div> 
            <div class="mb-6">
                <label for="paid_group" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Group Type</label>
                <select name="paid_group" id="paid_group" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option value="0">Free</option>
                    <option value="1">Paid</option>
                </select>
            </div>
           
            <button type="submit" class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </form>
    </section>
</x-app-layout>