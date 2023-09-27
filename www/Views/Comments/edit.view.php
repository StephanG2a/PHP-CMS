<form action="/updateCommentStatus" method="post">
    <label>
        Content:
        <textarea name="content"><?= $comment['content'] ?></textarea>
    </label>
    <label>
        Is Published:
        <select name="is_published">
            <option value="1" <?= $comment['is_published'] ? 'selected' : '' ?>>Yes</option>
            <option value="0" <?= !$comment['is_published'] ? 'selected' : '' ?>>No</option>
        </select>
    </label>
    <input type="hidden" name="comment_id" value="<?= $comment['id'] ?>">
    <button type="submit">Update</button>
</form>