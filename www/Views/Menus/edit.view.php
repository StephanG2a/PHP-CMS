<form action="/dashboard/menus/update/<?= $menuItem->getId() ?>" method="post">
    <div class="space-y-12 sm:space-y-16">
        <div>
            <h2 class="text-base font-semibold leading-7 text-gray-900">Update Menu</h2>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Update the menu item details.</p>

            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="name" class="block text-sm font-medium text-gray-700">Menu Name:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" id="name" name="name" value="<?= $menuItem->getName() ?>" class="border rounded p-2 w-full" required minlength="2">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="url" class="block text-sm font-medium text-gray-700">URL:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" id="url" name="url" value="<?= $menuItem->getUrl() ?>" class="border rounded p-2 w-full" required>
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="order" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Order:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="number" id="order" name="order" value="<?= $menuItem->getOrder() ?>" class="border rounded p-2 w-full" required>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="/dashboard/menus" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
        <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
</form>