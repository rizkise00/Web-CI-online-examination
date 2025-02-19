<div class="max-w-7xl mx-auto p-6 lg:px-8">
    <div class="p-4 bg-white shadow rounded-lg">
        <div class="mx-auto p-6 mt-10">
            <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">Quiz Results</h2>
            <div class="space-y-4">
                <div class="flex justify-between text-lg font-medium">
                    <span>Total Questions:</span>
                    <span class="px-3 py-1 rounded-lg">
                        <?= isset($result['total_question']) ? htmlspecialchars($result['total_question']) : '' ?>
                    </span>
                </div>
                <div class="flex justify-between text-lg font-medium text-green-600">
                    <span>Correct Answers:</span>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-lg">
                        <?= isset($result['total_correct']) ? htmlspecialchars($result['total_correct']) : '' ?>
                    </span>
                </div>
                <div class="flex justify-between text-lg font-medium text-red-600">
                    <span>Wrong Answers:</span>
                    <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg">
                        <?= isset($result['total_wrong']) ? htmlspecialchars($result['total_wrong']) : '' ?>
                    </span>
                </div>
                <div class="flex justify-between text-lg font-medium text-blue-600">
                    <span>Total Score:</span>
                    <span class="px-3 py-1 bg-blue-100 text-blue-700 rounded-lg">
                        <?= isset($result['total_score']) ? htmlspecialchars($result['total_score']) : '' ?>
                    </span>
                </div>
            </div>
            <div class="mt-6 flex justify-center space-x-4">
                <a href="<?= base_url('home/start-quiz/' . $result['quiz_id'] . '/1'); ?>" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold rounded-lg">Retake Quiz</a>
                <a href="<?= base_url('home') ?>" class="px-4 py-2 bg-gray-600 hover:bg-gray-700 text-white font-semibold rounded-lg">Back to Home</a>
            </div>
        </div>
    </div>
</div>