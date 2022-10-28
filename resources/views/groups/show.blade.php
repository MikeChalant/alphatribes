<x-app-layout>
    <x-page-heading>
        <x-slot name="pageTitle">{{ __('Group Detail') }}</x-slot>
        <a class="flex items-center space-x-1 border px-3 py-1 rounded-lg" href="{{ route('admin.group.index') }}">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span>Groups</span>
        </a>
    </x-page-heading>
    <section class="bg-white p-4 rounded">
       <div class="px-4">
           <div class="flex flex-col py-6">
               <div class="w-20 h-20 rounded-full overflow-hidden">
                   <img src="{{ $group->image ? asset('images/group_profile/'.$group->image) : asset('images/noimage.png') }}"
                    class="w-full rounded-full object-cover">
               </div>
               <h2 class="font-semibold mt-4">{{ $group->group_name }}</h2>
           </div>
           <div class="space-y-6">
               <div class="grid lg:grid-cols-6">
                   <p class="lg:col-span-1">Description:</p>
                    <P class="lg:col-span-5">{{ $group->description }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Support Email:</p>
                    <P class="lg:col-span-5">{{ $group->support_email }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Category:</p>
                    <P class="lg:col-span-5">{{ $group->category->category_name }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Group Type:</p>
                    <P class="lg:col-span-5">{{ $group->group_type }} &amp; {{ ($group->paid_group === '1') ? 'Paid' : 'Free' }}</P>
               </div>
                @if($group->group_type === '1')
                <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Stripe Connect Email:</p>
                    <P class="lg:col-span-5">{{ $group->stripe_connect_email }}</P>
                </div>
                <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Payment Type:</p>
                    <P class="lg:col-span-5">{{ $group->payment_type }}</P>
                </div>
                @if ($group->payment_type === 'recurring')
                    <div class="grid lg:grid-cols-6">
                        <p class="lg:col-span-1">Daily Cost:</p>
                        <P class="lg:col-span-5">{{ $group->billing_currency }} {{ $group->daily_cost }}</P>
                    </div>
                    <div class="grid lg:grid-cols-6">
                        <p class="lg:col-span-1">Weekly Cost:</p>
                        <P class="lg:col-span-5">{{ $group->billing_currency }} {{ $group->weekly_cost }}</P>
                    </div>
                    <div class="grid lg:grid-cols-6">
                        <p class="lg:col-span-1">Monthly Cost:</p>
                        <P class="lg:col-span-5">{{ $group->billing_currency }} {{ $group->monthly_cost }}</P>
                    </div>
                    <div class="grid lg:grid-cols-6">
                        <p class="lg:col-span-1">Yearly Cost:</p>
                        <P class="lg:col-span-5">{{ $group->billing_currency }} {{ $group->yearly_cost }}</P>
                    </div>
                @else
                    <div class="grid lg:grid-cols-6">
                        <p class="lg:col-span-1">Onetime Cost:</p>
                        <P class="lg:col-span-5">{{ $group->onetime_cost }}</P> 
                    </div>
                @endif
                <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Trial Duration:</p>
                    <P class="lg:col-span-5">{{ $group->trial_duration }}</P>
                </div>
               @endif
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Total Subscribers:</p>
                    <P class="lg:col-span-5">{{ $group->total_subscribers }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Report Count:</p>
                    <P class="lg:col-span-5">{{ $group->total_subscribers }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">File Count:</p>
                    <P class="lg:col-span-5">{{ $group->file_count }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Audio Count:</p>
                    <P class="lg:col-span-5">{{ $group->audio_count }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Video Count:</p>
                    <P class="lg:col-span-5">{{ $group->video_count }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Created:</p>
                    <P class="lg:col-span-5">{{ date('M d, Y H:i A', strtotime($group->created_at)) }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
                    <p class="lg:col-span-1">Created By:</p>
                    <P class="lg:col-span-5">{{ $group->user->name }}</P>
               </div>
               <div class="grid lg:grid-cols-6">
               <p><a href="{{ route('admin.group.delete', $group->id) }}" class="font-medium text-gray-600 dark:text-gray-500 hover:underline"
                    onclick="confirmDelete(event,'deleteGroupForm{{ $group->id }}', 'Delete Group')"
                    >
                    <form id="deleteGroupForm{{ $group->id }}" action="{{ route('admin.group.delete', $group->id) }}" method="post">
                        @csrf @method('delete')</form>
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    </a>
                </p>
               </div>
           </div>
       </div>
    </section>
</x-app-layout>