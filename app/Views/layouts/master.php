<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
        <?php include 'header.php'; ?>
        <main>
            <?= isset($content) ? $content : '' ?>
        </main>
    </body>
</html>