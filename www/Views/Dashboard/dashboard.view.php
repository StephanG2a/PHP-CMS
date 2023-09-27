<div>
    <h3 class="text-base font-semibold leading-6 text-gray-900">Stats</h3>
    <dl class="mt-5 grid grid-cols-1 gap-5 sm:grid-cols-4">
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Users</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $userCount ?></dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Comments</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $commentCount ?></dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Posts</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $postCount ?></dd>
        </div>
        <div class="overflow-hidden rounded-lg bg-white px-4 py-5 shadow sm:p-6">
            <dt class="truncate text-sm font-medium text-gray-500">Total Categories</dt>
            <dd class="mt-1 text-3xl font-semibold tracking-tight text-gray-900"><?= $categoryCount ?></dd>
        </div>
    </dl>
</div>