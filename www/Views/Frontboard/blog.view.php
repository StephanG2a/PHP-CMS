<div class="mx-auto max-w-2xl text-center mb-4">
    <label for="categoryFilter" class="block text-sm font-medium text-gray-700">Filter by Category:</label>
    <select id="categoryFilter" name="categoryFilter" class="mt-1 block w-full py-2 px-3 border rounded-md shadow-sm focus:ring focus:ring-opacity-50">
        <option value="all">All Categories</option>
        <?php foreach ($categories as $category) : ?>
            <option value="<?= $category['id'] ?>"><?= $category['name'] ?></option>
        <?php endforeach; ?>
    </select>
</div>
<div class="mx-auto mt-16 grid max-w-2xl grid-cols-1 gap-x-8 gap-y-20 lg:mx-0 lg:max-w-none lg:grid-cols-3">

    <?php foreach ($posts as $post) : ?>
        <article class="flex flex-col items-start justify-between">
            <div class="relative w-full">
                <img src="https://images.unsplash.com/photo-1496128858413-b36217c2ce36?ixlib=rb-4.0.3&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=3603&q=80" alt="" class="aspect-[16/9] w-full rounded-2xl bg-gray-100 object-cover sm:aspect-[2/1] lg:aspect-[3/2]">
                <div class="absolute inset-0 rounded-2xl ring-1 ring-inset ring-gray-900/10"></div>
            </div>
            <div class="max-w-xl">
                <div class="mt-8 flex items-center gap-x-4 text-xs">
                    <time datetime="<?= $post['created_at'] ?>" class="text-gray-500"><?= $post['created_at'] ?></time>
                    <a href="/blog/<?= $post['name'] ?>" class="relative z-10 rounded-full bg-gray-50 px-3 py-1.5 font-medium text-gray-600 hover:bg-gray-100"><?= $post['name'] ?></a>
                </div>
                <div class="group relative">
                    <h3 class="mt-3 text-lg font-semibold leading-6 text-gray-900 group-hover:text-gray-600">
                        <a href="/post/<?= $post['id'] ?>">
                            <span class="absolute inset-0"></span>
                            <?= $post['title'] ?>
                        </a>
                    </h3>
                    <p class="mt-5 line-clamp-3 text-sm leading-6 text-gray-600"><?= $post['content'] ?></p>
                </div>
                <div class="relative mt-8 flex items-center gap-x-4">
                    <img src="https://images.unsplash.com/photo-1519244703995-f4e0f30006d5?ixlib=rb-1.2.1&ixid=eyJhcHBfaWQiOjEyMDd9&auto=format&fit=facearea&facepad=2&w=256&h=256&q=80" alt="" class="h-10 w-10 rounded-full bg-gray-100">
                    <div class="text-sm leading-6">
                        <p class="font-semibold text-gray-900">
                            <a href="#">
                                <span class="absolute inset-0"></span>
                                <?= $post['firstname'] . ' ' . $post['lastname'] ?>
                            </a>
                        </p>
                        <p class="text-gray-600"><?= $post['role'] ?></p>
                    </div>
                </div>
            </div>
        </article>
    <?php endforeach; ?>
</div>