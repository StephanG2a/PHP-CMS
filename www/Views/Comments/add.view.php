<div class="mt-8">
    <h2 class="text-2xl font-semibold mb-4">Leave a Comment:</h2>
    <form action="/blog/<?= $post['id'] ?>" method="post" class="space-y-4">
        <div class="flex flex-col">
            <label for="comment" class="text-lg font-medium">Your Comment</label>
            <textarea id="comment" name="comment" rows="4" class="p-2 border rounded-md" placeholder="Write your comment here..."></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="bg-blue-500 text-white px-6 py-2 rounded-md hover:bg-blue-600">
                Submit Comment
            </button>
        </div>
    </form>
</div>