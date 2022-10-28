<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('New Admin User') }}</x-slot>
        <a class="flex items-center space-x-1 border px-3 py-1 rounded-lg" href="{{ route('admin.user.index') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span>users</span>
        </a>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
        <form method="POST" action={{ route('admin.user.store') }} enctype="multipart/form-data">
            @csrf
            <div class="grid gap-6 mb-6 md:grid-cols-2">
                <div>
                    <label for="name" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Name</label>
                    <input type="text" name="name" id="name"
                        value="{{ old('name') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="John Duke" required>
                    @if ($errors->has('name'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('name') }}</span>
                    @endif
                </div>
                <div>
                    <label for="email" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Email</label>
                    <input type="text" name="email" id="email"
                        value="{{ old('email') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="notaplayboy@tribe.com" required>
                    @if ($errors->has('email'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('email') }}</span>
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
                    <label for="country_id" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Country code</label>
                    <input type="number" minlength="1" maxlength="3" name="country_id"
                        value="{{ old('country_id') }}"
                        id="country_id" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="+1" required>
                    @if ($errors->has('country_id'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('country_id') }}</span>
                    @endif
                </div>
                <div>
                    <label for="phone" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Phone number</label>
                    <input type="tel" name="phone" id="phone"
                        value="{{ old('phone') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="123-45-678"  required>
                    @if ($errors->has('phone'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('phone') }}</span>
                    @endif
                </div>
                <div>
                    <label for="username" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Username</label>
                    <input type="text" name="username" id="username" 
                        value="{{ old('username') }}"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="notaplayboy" required>
                    @if ($errors->has('username'))
                        <span class="text-red-400 mt-1 text-sm">{{ $errors->first('username') }}</span>
                    @endif
                </div>
            </div>
            <div class="mb-6">
                <label for="about" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">About</label>
                <input type="text" name="about" id="about" 
                    value="{{ old('about') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="I got a simple life..." required>
                @if ($errors->has('about'))
                    <span class="text-red-400 mt-1 text-sm">{{ $errors->first('about') }}</span>
                @endif
            </div> 
            <div class="mb-6">
                <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300" for="user_image">Profile Image</label>
                <input name="user_image" class="block w-full text-sm text-gray-900 bg-gray-50 rounded-lg border border-gray-300 cursor-pointer dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400" id="user_image" type="file">
                @if ($errors->has('user_image'))
                    <span class="text-red-400 mt-1 text-sm">{{ $errors->first('user_image') }}</span>
                @endif
            </div> 
            <div class="mb-6">
                <label for="password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Password</label>
                <input type="password" name="password" id="password" 
                    value="{{ old('password') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required>
                @if ($errors->has('password'))
                    <span class="text-red-400 mt-1 text-sm">{{ $errors->first('password') }}</span>
                @endif
            </div> 
            <div class="mb-6">
                <label for="confirm_password" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Confirm password</label>
                <input type="password" name="confirm_password" id="confirm_password" 
                    value="{{ old('confirm_password') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="•••••••••" required>
                @if ($errors->has('confirm_password'))
                    <span class="text-red-400 mt-1 text-sm">{{ $errors->first('confirm_password') }}</span>
                @endif
            </div> 
           
            <button type="submit" class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </form>
    </section>
</x-app-layout>