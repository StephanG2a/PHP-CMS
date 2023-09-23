<form method="<?= $config["config"]["method"] ?? "GET" ?>" action="<?= $config["config"]["action"] ?>" class="space-y-6">
    <?php foreach ($config["inputs"] as $name => $input) : ?>
        <div>
            <label for="<?= $name; ?>" class="block text-sm font-medium leading-6 text-gray-900"><?= ucfirst($name); ?></label>
            <div class="mt-2">
                <?php if ($input["type"] == "select") : ?>
                    <select name="<?= $name; ?>" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                        <?php foreach ($input["options"] as $option) : ?>
                            <option><?= $option; ?></option>
                        <?php endforeach; ?>
                    </select>
                <?php else : ?>
                    <input name="<?= $name; ?>" type="<?= $input["type"] ?>" placeholder="<?= $input["placeholder"] ?>" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6 px-3">
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    <div>
        <input type="submit" name="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm font-semibold leading-6 text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600" value="<?= $config["config"]["submit"] ?>">
    </div>
</form>