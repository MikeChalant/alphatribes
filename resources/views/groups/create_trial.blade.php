<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('Setup Trial Period') }}</x-slot>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
        <form method="POST" action="{{ route('admin.group.save_trial', $groupId) }}">
            @csrf
           @method('patch')
            <div class="mb-6">
                <label for="trial_period" class="block mb-2 text-sm font-medium text-gray-900 dark:text-gray-300">Trial Period</label>
                <input type="number" name="trial_period" id="trial_period" 
                    value="{{ old('trial_period') }}"
                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="30" required>
                @if ($errors->has('trial_period'))
                    <span class="text-red-400 mt-1 text-sm">{{ $errors->first('trial_period') }}</span>
                @endif
            </div> 
           
            <button type="submit" class="text-white bg-teal-700 hover:bg-teal-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm w-full sm:w-auto px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
        </form>
    </section>
</x-app-layout>