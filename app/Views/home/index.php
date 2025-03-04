<?php 
    $session = session();
    $user = json_decode($session->get('user_data'), true);
?>

<div class="max-w-7xl mx-auto p-6 lg:px-8">
    <div class="p-4 bg-white shadow rounded-lg">
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-800">Quiz List</h1>
            <?php if ($user['role'] == 'admin'): ?>
                <a href="<?= base_url('home/add-quiz'); ?>">
                    <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                        Add Quiz
                    </button>
                </a>
            <?php endif; ?>
        </div>
        <div class="relative overflow-x-auto">
            <?php 
                $session = session();

                if ($session->getFlashdata('success')): ?>
                    <div class="text-green-500 font-bold mb-4 text-center">
                        <?= esc($session->getFlashdata('success')) ?>
                    </div>
                <?php endif; 
            ?>
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
                        <!-- <th scope="col" class="px-6 py-3 min-w-32">
                            Time Limit
                        </th> -->
                        <th scope="col" class="px-6 py-3 w-68">
                            Action
                        </th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($quiz_list as $index => $quiz): ?>
                        <tr class="<?= isset($quiz['quiz_completed']) && $quiz['quiz_completed'] ? 'bg-green-100 border-green-500 hover:bg-green-200' : 'bg-white border-gray-200 hover:bg-gray-50' ?> border-b">
                            <th class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($index + 1) ?>
                            </th>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($quiz['title']) ?>
                            </td>
                            <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($quiz['total_question']) ?>
                            </td>
                            <!-- <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                <?= esc($quiz['time'] . ' min') ?>
                            </td> -->
                            <td class="px-6 py-4">
                                <?php if ($user['role'] == 'admin'): ?>
                                    <a href="<?= base_url('home/edit-quiz/' . $quiz['id']); ?>" class="mr-1">
                                        <button class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded">
                                            Edit
                                        </button>
                                    </a>
                                    <button type="button" data-id="<?= $quiz['id']; ?>" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded deleteButton">
                                        Delete
                                    </button>
                                <?php else: ?>
                                    <a href="<?= base_url('home/start-quiz/' . $quiz['id'] . '/1'); ?>" class="mr-1">
                                        <?php if ($quiz['quiz_completed']): ?>
                                            <button class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-4 rounded">
                                                Restart
                                            </button>
                                        <?php else: ?>
                                            <button class="bg-green-500 hover:bg-green-700 text-white font-bold py-1 px-4 rounded">
                                                Start
                                            </button>
                                        <?php endif; ?>
                                    </a>
                                <?php endif; ?>
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

<div id="deleteModal" class="fixed z-10 inset-0 overflow-y-auto hidden">
    <div class="flex items-center justify-center min-h-screen">
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Are you sure?</h2>
            <p class="text-gray-600">Do you really want to delete this quiz? This process cannot be undone.</p>
            <div class="mt-6 flex justify-end">
                <button id="cancelDelete" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded mr-2">Cancel</button>
                <button id="confirmDelete" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">Delete</button>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        let deleteModal = document.getElementById('deleteModal');
        let confirmDelete = document.getElementById('confirmDelete');
        let cancelDelete = document.getElementById('cancelDelete');
        let deleteUrl = '';

        document.querySelectorAll('.deleteButton').forEach(button => {
            button.addEventListener('click', function () {
                let quizId = this.getAttribute('data-id');
                deleteUrl = "<?= base_url('home/delete-quiz/'); ?>" + quizId;

                deleteModal.classList.remove('hidden');
            });
        });

        cancelDelete.addEventListener('click', function () {
            deleteModal.classList.add('hidden');
        });

        confirmDelete.addEventListener('click', function () {
            window.location.href = deleteUrl;
        });
    });
</script>