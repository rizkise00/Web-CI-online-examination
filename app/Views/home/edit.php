<div class="max-w-7xl mx-auto p-6 lg:px-8">
    <div class="p-4 bg-white shadow rounded-lg">
        <a href="<?= base_url('home'); ?>">
            <button class="px-4 py-2 bg-blue-500 text-white font-semibold rounded-lg hover:bg-blue-600 transition">
                <i class="fas fa-arrow-left mr-2"></i>Back
            </button>
        </a>
        <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-4">Edit Quiz</h1>
        <div class="relative">
            <form action="<?= base_url('home/update-quiz/' . $quiz['id']); ?>" method="POST">
                <div class="mb-5">
                    <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Title</label>
                    <input 
                        type="text" 
                        name="title" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="<?= isset($quiz['title']) ? htmlspecialchars($quiz['title']) : '' ?>"
                    >
                </div>
                <div class="mb-5">
                    <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Total Question</label>
                    <input 
                        readonly
                        type="number" 
                        name="total_question" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="<?= isset($quiz['total_question']) ? htmlspecialchars($quiz['total_question']) : '' ?>"
                    >
                </div>
                <div class="mb-5">
                    <label for="base-input" class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">Time (minutes)</label>
                    <input 
                        type="number" 
                        name="time" 
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500"
                        value="<?= isset($quiz['time']) ? htmlspecialchars($quiz['time']) : '' ?>"
                    >
                </div>
                <div class="border-b border-gray-300 my-12"></div>
                <div class="question">
                    <?php $i = 1; ?>
                    <?php foreach ($questions as $question): ?>
                        <input type="hidden" name="questions[<?= $i ?>][id]" value="<?= isset($question['id']) ? htmlspecialchars($question['id']) : '' ?>">
                        <div class="mb-5">
                            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white">
                                Question Number <?= $i ?>
                            </label>
                            <textarea 
                                name="questions[<?= $i ?>][question]" 
                                placeholder="Write question number <?= $i ?> here..." 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            ><?= htmlspecialchars($question['question'] ?? '') ?></textarea>
                            <div class="my-4">
                                <?php 
                                    $options = $question['options'] ?? ['', '', '', '']; 
                                    $optionLabels = ['A', 'B', 'C', 'D'];
                                ?>
                                <?php foreach ($options as $key => $option): ?>
                                    <input 
                                        type="text" 
                                        name="questions[<?= $i ?>][options][]" 
                                        value="<?= htmlspecialchars($option) ?>" 
                                        placeholder="Enter option <?= $optionLabels[$key] ?>" 
                                        class="mb-2 bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                                    >
                                <?php endforeach; ?>
                            </div>
                            <select 
                                name="questions[<?= $i ?>][answer]" 
                                class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg block w-full p-2.5"
                            >
                                <option disabled>Select answer for question <?= $i ?></option>
                                <?php foreach ($optionLabels as $label): ?>
                                    <option value="<?= $label ?>" <?= isset($question['answer']) && $question['answer'] === $label ? 'selected' : '' ?>>
                                        Option <?= $label ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                            <p class="text-xs text-gray-500 mt-1 ml-1">Select the correct answer from the options above.</p>
                        </div>
                        <?php $i++; ?>
                    <?php endforeach; ?>
                </div>

                <div class="flex justify-end save">
                    <button type="submit" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>