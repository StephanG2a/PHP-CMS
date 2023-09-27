<form action="/dashboard/posts/update/<?= $post->getId() ?>" method="post">
    <div class="space-y-12 sm:space-y-16">
        <div>
            <h2 class="text-base font-semibold leading-7 text-gray-900">Update Post</h2>
            <p class="mt-1 max-w-2xl text-sm leading-6 text-gray-600">Update the details of the selected post.</p>

            <div class="mt-10 space-y-8 border-b border-gray-900/10 pb-12 sm:space-y-0 sm:divide-y sm:divide-gray-900/10 sm:border-t sm:pb-0">
                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="title" class="block text-sm font-medium text-gray-700">Title:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <input type="text" id="title" name="title" value="<?= $post->getTitle() ?>" class="border rounded p-2 w-full" required minlength="2">
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="content" class="block text-sm font-medium text-gray-700">Content:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <textarea id="content" name="content" class="border rounded p-2 w-full" required><?= $post->getContent() ?></textarea>
                    </div>
                </div>

                <div class="sm:grid sm:grid-cols-3 sm:items-start sm:gap-4 sm:py-6">
                    <label for="category_id" class="block text-sm font-medium leading-6 text-gray-900 sm:pt-1.5">Category:</label>
                    <div class="mt-2 sm:col-span-2 sm:mt-0">
                        <select id="category_id" name="category_id" class="border rounded p-2 w-full" required>
                            <?php foreach ($categories as $category) : ?>
                                <option value="<?= $category['id'] ?>" <?= $post->getCategoryId() == $category['id'] ? 'selected' : '' ?>>
                                    <?= $category['name'] ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6 flex items-center justify-end gap-x-6">
        <a href="/dashboard/posts" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</a>
        <button type="submit" class="inline-flex justify-center rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
    </div>
</form>