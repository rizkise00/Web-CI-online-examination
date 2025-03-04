<div class="max-w-7xl mx-auto p-6 lg:px-8">
    <div class="p-4 bg-white shadow rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6">Feedback Form</h1>
        <div class="relative">
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
            <form action="<?= base_url('users/store-feedback'); ?>" method="POST">
                <div class="mb-5">
                    <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Message</label>
                    <textarea name="message" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"></textarea>
                </div>
                <div class="flex justify-end save">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>