<div class="px-4 sm:px-6 lg:px-8">
    <h1 class="text-base font-semibold leading-6 text-gray-900">Comments</h1>
    <p class="mt-2 text-sm text-gray-700">Manage all the comments in your application.</p>
    <div class="mt-8 flow-root">
        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead>
                        <tr>
                            <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Comment</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Post</th>
                            <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">User</th>
                            <th class="relative py-3.5 pl-3 pr-4 sm:pr-0">
                                <span class="sr-only">Actions</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                        <?php foreach ($comments as $comment) : ?>
                            <tr>
                                <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm"><?= $comment['content'] ?></td>
                                <td class="whitespace-nowrap px-3 py-5 text-sm"><?= $comment['post_title'] ?></td>
                                <td class="whitespace-nowrap px-3 py-5 text-sm"><?= $comment['user_name'] ?></td>
                                <td class="relative whitespace-nowrap py-5 pl-3 pr-4 text-right text-sm font-medium sm:pr-0">
                                    <a href="/dashboard/comments/edit/<?= $comment['id'] ?>" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">Edit</a>
                                    <a href="/dashboard/comments/delete/<?= $comment['id'] ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>