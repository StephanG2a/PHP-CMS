<form action="/dashboard/users/update/<?= $user->getId() ?>" method="post">
    <div class="space-y-12 sm:space-y-16">
        <div>
            <h2 class="text-base font-semibold leading-7 text-gray-900">Update User</h2>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Use a permanent address where you can receive mail.</p>

            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="firstname" class="block text-sm font-medium text-gray-700">First Name:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" id="firstname" name="firstname" value="<?= $user->getFirstname() ?>" class="border rounded p-2 w-full" autocomplete="given-name" required minlength="2">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="lastname" class="block text-sm font-medium text-gray-700">Last Name:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" id="lastname" name="lastname" value="<?= $user->getLastname() ?>" class="border rounded p-2 w-full" autocomplete="family-name" required minlength="2">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="email" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Email:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" class="border rounded p-2 w-full" autocomplete="email" required>
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="role" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Role :</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <select id="role" name="role" class="border rounded p-2 w-full" required>
                            <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Admin</option>
                            <option value="blogger" <?= $user->getRole() === 'blogger' ? 'selected' : '' ?>>Blogger</option>
                            <option value="guest" <?= $user->getRole() === 'guest' ? 'selected' : '' ?>>Guest</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="/dashboard/users" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
        <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
</form>