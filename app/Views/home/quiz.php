<div class="max-w-7xl mx-auto p-6 lg:px-8">
    <div class="p-4 bg-white shadow rounded-lg">
        <h1 class="text-2xl font-bold text-gray-800 mb-6 mt-4">Quiz : <?= isset($quiz['quiz_title']) ? htmlspecialchars($quiz['quiz_title']) : '' ?></h1>
        <div class="relative">
            <form action="<?= base_url('home/store-question'); ?>" method="POST">
                <input type="hidden" name="quiz_id" value="<?= isset($quiz['quiz_id']) ? htmlspecialchars($quiz['quiz_id']) : '' ?>">
                <input type="hidden" name="question_id" value="<?= isset($quiz['question_id']) ? htmlspecialchars($quiz['question_id']) : '' ?>">
                <input type="hidden" name="current_question" value="<?= isset($quiz['question_no']) ? htmlspecialchars($quiz['question_no']) : '' ?>">
                <input type="hidden" name="total_question" value="<?= isset($quiz['total_question']) ? htmlspecialchars($quiz['total_question']) : '' ?>">
                <div class="mb-5">
                    <label for="base-input" class="block mb-2 text-xl font-medium text-gray-900 dark:text-white">Question <?= isset($quiz['question_no']) ? htmlspecialchars($quiz['question_no']) : '' ?></label>
                    <div class="text-gray-900 text-base mt-4">
                        <?= isset($quiz['question']) ? htmlspecialchars($quiz['question']) : '' ?>
                    </div>
                    <div class="mt-4">
                        <div class="mt-2 space-y-2">
                            <?php foreach ($quiz['options'] as $option): ?>
                                <label class="flex items-center">
                                    <input type="radio" name="answer" value="<?= htmlspecialchars($option['value']) ?>" class="form-radio text-blue-600">
                                    <span class="ml-2"><?= htmlspecialchars($option['name']) ?></span>
                                </label>
                            <?php endforeach; ?>
                        </div>
                    </div>
                </div>

                <div class="flex justify-end">
                    <button type="submit" id="nextButton" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 text-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 opacity-50 cursor-not-allowed" disabled>
                        <?php if ($quiz['question_no'] == $quiz['total_question']): ?>
                            Submit
                        <?php else: ?>
                            Next
                        <?php endif; ?>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.addEventListener("DOMContentLoaded", function () {
        const radioButtons = document.querySelectorAll('input[name="answer"]');
        const nextButton = document.getElementById("nextButton");

        radioButtons.forEach((radio) => {
            radio.addEventListener("change", function () {
                nextButton.disabled = false;
                nextButton.classList.remove("opacity-50", "cursor-not-allowed");
            });
        });
    });
</script>