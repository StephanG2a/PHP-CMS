<form action="/dashboard/users/update/<?= $user->getId() ?>" method="post" class="space-y-4">
    <div class="flex flex-col">
        <label for="firstname" class="text-lg font-semibold">First Name:</label>
        <input type="text" id="firstname" name="firstname" value="<?= $user->getFirstname() ?>" class="border rounded p-2" required>
    </div>

    <div class="flex flex-col">
        <label for="lastname" class="text-lg font-semibold">Last Name:</label>
        <input type="text" id="lastname" name="lastname" value="<?= $user->getLastname() ?>" class="border rounded p-2" required>
    </div>

    <div class="flex flex-col">
        <label for="email" class="text-lg font-semibold">Email:</label>
        <input type="email" id="email" name="email" value="<?= $user->getEmail() ?>" class="border rounded p-2" required>
    </div>

    <div class="flex flex-col">
        <label for="password" class="text-lg font-semibold">Password:</label>
        <input type="password" id="password" name="password" class="border rounded p-2" placeholder="Enter new password">
    </div>

    <div class="flex flex-col">
        <label for="role" class="text-lg font-semibold">Role:</label>
        <select id="role" name="role" class="border rounded p-2" required>
            <option value="admin" <?= $user->getRole() === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="blogger" <?= $user->getRole() === 'blogger' ? 'selected' : '' ?>>Blogger</option>
            <option value="guest" <?= $user->getRole() === 'guest' ? 'selected' : '' ?>>Guest</option>
        </select>
    </div>

    <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
        Update User
    </button>
</form>