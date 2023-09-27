<form action="/dashboard/comments/update/<?= $comment['id'] ?>" method="post" class="space-y-4">
    <div>
        <label for="new_content" class="block text-sm font-medium leading-6 text-gray-900">Content:</label>
        <div class="mt-2">
            <textarea rows="4" name="new_content" id="new_content" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 px-2">
                <?= isset($comment['content']) ? $comment['content'] : '' ?>
            </textarea>
        </div>
    </div>

    <div>
        <label for="is_published" class="block text-sm font-medium leading-6 text-gray-900">Is Published:</label>
        <select id="is_published" name="is_published" class="mt-2 block w-full rounded-md border-0 py-1.5 pl-3 pr-10 text-gray-900 ring-1 ring-inset ring-gray-300 focus:ring-2 focus:ring-indigo-600 sm:text-sm sm:leading-6">
            <option value="1" <?= isset($comment['is_published']) && $comment['is_published'] ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= isset($comment['is_published']) && !$comment['is_published'] ? 'selected' : '' ?>>No</option>
        </select>
    </div>

    <input type="hidden" name="comment_id" value="<?= isset($comment['id']) ? $comment['id'] : '' ?>">

    <div>
        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700 focus:outline-none focus:border-indigo-700 focus:ring focus:ring-indigo-200 active:bg-indigo-800">
            Update
        </button>
    </div>
</form>