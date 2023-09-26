<form action="/dashboard/users/update/<?= $user->getId() ?>" method="post">
    <label for="firstname">First Name:</label>
    <input type="text" id="firstname" name="firstname" value="<?= $user->getFirstname() ?>" class="border rounded" required>

    <label for="lastname">Last Name:</label>
    <input type="text" id="lastname" name="lastname" value="<?= $user->getLastname() ?>" class="border rounded" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" class="border rounded" required>

    <label for="role">Role:</label>
    <select id="role" name="role" class="border rounded" required>
        <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Admin</option>
        <option value="user" <?= $user->getRole() === 'user' ? 'selected' : '' ?>>User</option>
    </select>

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Update User
    </button>
</form>