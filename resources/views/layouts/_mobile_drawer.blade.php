<!-- drawer component -->
<div id="drawer-disable-body-scrolling" class="fixed hidden z-40 h-screen p-4 overflow-y-auto bg-teal-700 w-80 dark:bg-gray-800" tabindex="-1" aria-labelledby="drawer-disable-body-scrolling-label">
    <h5 id="drawer-disable-body-scrolling-label" class="text-base font-semibold text-white uppercase dark:text-gray-400">Alphatribesignals</h5>
    <button type="button" data-drawer-dismiss="drawer-disable-body-scrolling" aria-controls="drawer-disable-body-scrolling" class="text-white bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center dark:hover:bg-gray-600 dark:hover:text-white" >
        <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
        <span class="sr-only">Close menu</span>
    </button>
  <div class="py-4 overflow-y-auto">
   <ul class="space-y-2">
      <li>
         <a href="{{ route('admin.dashboard') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg aria-hidden="true" class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path><path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path></svg>
            <span class="ml-3">Dashboard</span>
         </a>
      </li>
      <li>
         <button type="button" class="flex items-center p-2 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-groups" data-collapse-toggle="dropdown-groups">
               <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-white dark:text-gray-700 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
               <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Groups</span>
               <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
         </button>
         <ul id="dropdown-groups" class="hidden py-2 space-y-2">
               <li>
                  <a href="{{ route('admin.group.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">Active Groups</a>
               </li>
               <li>
                  <a href="{{ route('admin.group.blocked') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">Blocked Groups</a>
               </li>
               <li>
                  <a href="{{ route('admin.group.create') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">New Group</a>
               </li>
         </ul>
      </li>
      <li>
         <a href="{{ route('admin.profile.index') }}" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path></svg>
            <span class="ml-3">Profile</span>
         </a>
      </li>
      <li>
         <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
            <span class="ml-3">Site Settings</span>
         </a>
      </li>
      <li>
         <button type="button" class="flex items-center p-2 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-admin-user" data-collapse-toggle="dropdown-admin-user">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-white dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>
            <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Users</span>
            <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
         </button>
         <ul id="dropdown-admin-user" class="hidden py-2 space-y-2">
               <li>
                  <a href="" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">Users</a>
               </li>
               <li>
                  <a href="{{ route('admin.user.create') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">New Admin User</a>
               </li>
               <li>
                  <a href="{{ route('admin.user.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">Admin Users</a>
               </li>
         </ul>
      </li>
      <li>
         <button type="button" class="flex items-center p-2 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-country" data-collapse-toggle="dropdown-country">
               <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-white dark:text-gray-700 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path></svg>
               <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Countries</span>
               <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
         </button>
         <ul id="dropdown-country" class="hidden py-2 space-y-2">
               <li>
                  <a href="{{ route('admin.country.create') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">New Country</a>
               </li>
               <li>
                  <a href="{{ route('admin.country.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">View Countries</a>
               </li>
         </ul>
      </li>
      <li>
         <button type="button" class="flex items-center p-2 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700" aria-controls="dropdown-group-category" data-collapse-toggle="dropdown-group-category">
               <svg class="flex-shrink-0 w-6 h-6 text-white transition duration-75 group-hover:text-white dark:text-gray-700 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"></path></svg>
               <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Group Categories</span>
               <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
         </button>
         <ul id="dropdown-group-category" class="hidden py-2 space-y-2">
               <li>
                  <a href="{{ route('admin.category.create') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">New Category</a>
               </li>
               <li>
                  <a href="{{ route('admin.category.index') }}" class="flex items-center p-2 pl-11 w-full text-base font-normal text-white rounded-lg transition duration-75 group hover:bg-teal-600 dark:text-white dark:hover:bg-gray-700">View Categories</a>
               </li>
         </ul>
      </li>
      {{-- <li>
         <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z"></path></svg>
            <span class="ml-3">App Update</span>
         </a>
      </li> --}}
      {{-- <li>
         <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
            <span class="ml-3">Site Images</span>
         </a>
      </li> --}}
      {{-- <li>
         <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>
            <span class="ml-3">Notification</span>
         </a>
      </li> --}}
      {{-- <li>
         <a href="#" class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
            <span class="ml-3">SEO</span>
         </a>
      </li> --}}
      <li>
         <a href="logout" onclick="event.preventDefault();document.querySelector('#logoutForm').submit()" 
         class="flex items-center p-2 text-base font-normal text-white rounded-lg dark:text-white hover:bg-teal-600 dark:hover:bg-gray-700">
            <svg class="w-6 h-6 text-white transition duration-75 dark:text-gray-700 group-hover:text-teal-600 dark:group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 21h7a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v11m0 5l4.879-4.879m0 0a3 3 0 104.243-4.242 3 3 0 00-4.243 4.242z"></path></svg>
            <span class="ml-3">Logout</span>
         </a>
         <form action="logout" method="post" id="logoutForm">@csrf</form>
      </li>
   </ul>
   </div>
</div>