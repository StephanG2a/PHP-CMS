<!-- <form>
    <div class="space-y-12 sm:space-y-16">
        <div>
            <h2 class="text-base font-semibold leading-7 text-gray-900">Personal Information</h2>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>

            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="first-name" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">First name</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="first-name" id="first-name" autocomplete="given-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="last-name" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Last name</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" name="last-name" id="last-name" autocomplete="family-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Email address</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input id="email" name="email" type="email" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-md sm:text-sm sm:leading-6">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="country" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Country</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <select id="country" name="country" autocomplete="country-name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:max-w-xs sm:text-sm sm:leading-6">
                            <option>United States</option>
                            <option>Canada</option>
                            <option>Mexico</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <button type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
        <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
</form> -->

<form action="/dashboard/users/store" method="post" class="space-y-4">
    <div>
        <label for="firstname" class="block text-sm font-medium text-gray-700">First Name:</label>
        <input type="text" id="firstname" name="firstname" class="border rounded p-2 w-full" required minlength="2">
    </div>

    <div>
        <label for="lastname" class="block text-sm font-medium text-gray-700">Last Name:</label>
        <input type="text" id="lastname" name="lastname" class="border rounded p-2 w-full" required minlength="2">
    </div>

    <div>
        <label for="email" class="block text-sm font-medium text-gray-700">Email:</label>
        <input type="email" id="email" name="email" class="border rounded p-2 w-full" required>
    </div>

    <div>
        <label for="password" class="block text-sm font-medium text-gray-700">Password:</label>
        <input type="password" id="password" name="password" class="border rounded p-2 w-full" required minlength="8">
    </div>

    <div>
        <label for="role" class="block text-sm font-medium text-gray-700">Role:</label>
        <select id="role" name="role" class="border rounded p-2 w-full" required>
            <option value="admin">Admin</option>
            <option value="blogger">Blogger</option>
            <option value="guest">Guest</option>
        </select>
    </div>

    <div>
        <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Create User
        </button>
    </div>
</form>