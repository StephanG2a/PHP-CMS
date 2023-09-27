<div class="container mx-auto mt-8 p-4">
    <h1 class="text-3xl font-bold mb-2"><?= $post['title'] ?></h1>
    <p class="text-gray-600 mb-4"><?= $post['created_at'] ?></p>
    <div class="mt-4 mb-8">
        <?= $post['content'] ?>
    </div>
    <div class="my-0.5">
        <?php foreach ($comments as $comment) : ?>
            <?php if ($comment['is_published']) : ?>
                <div class="comment bg-gray-100 p-4 rounded-md mb-4">
                    <p class="text-lg"><?= $comment['content'] ?></p>
                    <small class="text-gray-500">By <?= isset($comment['user_name']) ? $comment['user_name'] : 'Anonymous' ?></small>
                </div>
            <?php endif; ?>
        <?php endforeach; ?>
    </div>

    <!-- Comment Form -->
    <?php if (isset($_SESSION['user_id'])) : ?>
        <div class="mt-8">
            <h2 class="text-2xl font-semibold mb-4">Leave a Comment</h2>
            <form action="/comment" method="post" class="mt-4">
                <input type="hidden" name="post_id" value="<?= $post['id'] ?>">
                <div class="mb-4">
                    <label for="comment" class="block text-sm font-medium text-gray-700 mb-2">Your Comment</label>
                    <textarea id="comment" name="comment" rows="4" class="mt-1 p-2 w-full border rounded-md"></textarea>
                </div>
                <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                    Submit Comment
                </button>
            </form>
        </div>
    <?php else : ?>
        <p class="mt-4 text-gray-600">You must be logged in to post a comment.</p>
    <?php endif; ?>
</div>