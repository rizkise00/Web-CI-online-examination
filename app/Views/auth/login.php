<!DOCTYPE html>
<html lang="en">
    <head>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link href="<?= base_url('assets/css/style.css') ?>" rel="stylesheet">
        <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    </head>
    <body class="bg-gray-100">
        <main>
            <div class="flex h-screen flex-col justify-center px-6 py-12 lg:px-8">
                <div class="sm:mx-auto sm:w-full sm:max-w-sm">
                    <h2 class="mt-10 text-center text-2xl/9 font-bold tracking-tight text-gray-900">Sign in to your account</h2>
                </div>

                <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
                    <?php
                        $session = session();

                        if ($session->getFlashdata('validation_errors')): 
                            foreach ($session->getFlashdata('validation_errors') as $field => $error): ?>
                                <div class="text-red-500 font-bold mb-4 text-center">
                                    <?= esc($error) ?>
                                </div>
                            <?php endforeach;
                        endif;

                        if ($session->getFlashdata('error')): ?>
                            <div class="text-red-500 font-bold mb-4 text-center">
                                <?= esc($session->getFlashdata('error')) ?>
                            </div>
                        <?php endif;

                        if ($session->getFlashdata('success')): ?>
                            <div class="text-green-500 font-bold mb-4 text-center">
                                <?= esc($session->getFlashdata('success')) ?>
                            </div>
                        <?php endif; 
                    ?>
                    <form class="space-y-6" action="<?= base_url('login'); ?>" method="POST">
                        <div>
                            <label for="email" class="block text-sm/6 font-medium text-gray-900">Email</label>
                            <div class="mt-2">
                                <input type="email" name="email" id="email" autocomplete="email" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            </div>
                        </div>

                        <div>
                            <div class="flex items-center justify-between">
                                <label for="password" class="block text-sm/6 font-medium text-gray-900">Password</label>
                                <div class="text-sm">
                                    <a href="#" class="font-semibold text-indigo-600 hover:text-indigo-500">Forgot password?</a>
                                </div>
                            </div>
                            <div class="mt-2">
                                <input type="password" name="password" id="password" autocomplete="current-password" required class="block w-full rounded-md bg-white px-3 py-1.5 text-base text-gray-900 outline-1 -outline-offset-1 outline-gray-300 placeholder:text-gray-400 focus:outline-2 focus:-outline-offset-2 focus:outline-indigo-600 sm:text-sm/6">
                            </div>
                        </div>

                        <div>
                            <button type="submit" class="flex w-full justify-center rounded-md bg-indigo-600 px-3 py-1.5 text-sm/6 font-semibold text-white shadow-xs hover:bg-indigo-500 focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Sign in</button>
                        </div>
                    </form>

                    <p class="mt-10 text-center text-sm/6 text-gray-500">
                        Don't have an account?
                        <a href="<?= base_url('register'); ?>" class="font-semibold text-indigo-600 hover:text-indigo-500">Register</a>
                    </p>
                </div>
            </div>
        </main>
    </body>
</html>