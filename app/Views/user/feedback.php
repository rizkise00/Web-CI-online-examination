<div class="max-w-7xl mx-auto p-6 lg:px-8">
    <div class="p-4 bg-white shadow rounded-lg">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Feedback List</h1>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3 w-32">
                            Full Name
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-40">
                            Email
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-32">
                            Message
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($user_list as $index => $user): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($index + 1) ?>
                            </th>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($user['full_name']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($user['email']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 dark:text-white break-words">
                                <?= esc(ucfirst($user['message'])) ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <div class="mt-4">
                <?= $pager->simpleLinks('default', 'tailwind_pagination') ?>
            </div>
        </div>
    </div>
</div>