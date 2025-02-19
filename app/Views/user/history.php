<div class="max-w-7xl mx-auto p-6 lg:px-8">
    <div class="p-4 bg-white shadow rounded-lg">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Quiz History</h1>
        </div>
        <div class="relative overflow-x-auto">
            <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-400">
                    <tr>
                        <th scope="col" class="px-6 py-3">
                            No
                        </th>
                        <th scope="col" class="px-6 py-3">
                            Topic
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-40">
                            Total Question
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-40">
                            Total Correct
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-32">
                            Total Incorrect
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-32">
                            Total Score
                        </th>
                        <th scope="col" class="px-6 py-3 min-w-32">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($history_list as $index => $history): ?>
                        <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($index + 1) ?>
                            </th>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($history['title']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($history['total_question']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($history['right']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($history['wrong']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($history['score']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <a href="<?= base_url('home/start-quiz/' . $history['quiz_id'] . '/1'); ?>" class="mr-1">
                                    <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">
                                        Restart
                                    </button>
                                </a>
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