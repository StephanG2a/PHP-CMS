<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>CMS</title>
    <meta name="description" content="Front Office">
    <link href="/dist/output.css" rel="stylesheet">
    <script type="text/javascript" src="/assets/js/categories.js"></script>
</head>

<body>
    <div class="bg-white py-24 sm:py-32">
        <div class="mx-auto max-w-7xl px-6 lg:px-8">
            <div class="mx-auto max-w-2xl text-center">
                <h2 class="text-3xl font-bold tracking-tight text-gray-900 sm:text-4xl">From the blog</h2>
                <p class="mt-2 text-lg leading-8 text-gray-600">Learn how to grow your business with our expert advice.</p>
            </div>
            <?php include $this->view; ?>
        </div>
    </div>
</body>

</html>