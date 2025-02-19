<?php 
    $currentRoute = uri_string(); 
    $session = session();
    $user = json_decode($session->get('user_data'), true);
?>

<header class="bg-white">
    <nav class="mx-auto flex max-w-7xl items-center justify-between p-6 lg:px-8" aria-label="Global">
        <div class="flex lg:hidden">
            <button type="button" class="-m-2.5 inline-flex items-center justify-center rounded-md p-2.5 text-gray-700">
                <span class="sr-only">Open main menu</span>
                <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>
        </div>
        <div class="hidden lg:flex lg:gap-x-12">
            <a href="<?= base_url('home'); ?>" class="<?= (strpos($currentRoute, 'home') !== false) ? 'text-blue-500' : 'text-gray-900'; ?> text-sm/6 font-semibold hover:text-blue-700">Home</a>
            <?php if ($user['role'] == 'admin'): ?>
                <a href="<?= base_url('users'); ?>" class="<?= ($currentRoute == 'users') ? 'text-blue-500' : 'text-gray-900'; ?> text-sm/6 font-semibold hover:text-blue-700">User</a>
            <?php else: ?>
                <a href="<?= base_url('users/quiz-history'); ?>" class="<?= ($currentRoute == 'users/quiz-history') ? 'text-blue-500' : 'text-gray-900'; ?> text-sm/6 font-semibold hover:text-blue-700">History</a>
            <?php endif; ?>
            <a href="<?= base_url('users/ranking'); ?>" class="<?= ($currentRoute == 'users/ranking') ? 'text-blue-500' : 'text-gray-900'; ?> text-sm/6 font-semibold hover:text-blue-700">Ranking</a>
            <?php if ($user['role'] == 'admin'): ?>
                <a href="<?= base_url('users/feedback'); ?>" class="<?= ($currentRoute == 'users/feedback') ? 'text-blue-500' : 'text-gray-900'; ?> text-sm/6 font-semibold hover:text-blue-700">Feedback</a>
            <?php else: ?>
                <a href="<?= base_url('users/feedback-form'); ?>" class="<?= ($currentRoute == 'users/feedback-form') ? 'text-blue-500' : 'text-gray-900'; ?> text-sm/6 font-semibold hover:text-blue-700">Feedback</a>
            <?php endif; ?>
        </div>
        <div class="hidden lg:flex lg:flex-1 lg:justify-end">
            <a href="<?= base_url('logout'); ?>" class="text-sm/6 font-semibold text-gray-900 hover:text-blue-700">Log out <span aria-hidden="true">&rarr;</span></a>
        </div>
    </nav>

    <!-- Mobile menu, show/hide based on menu open state. -->
    <div class="hidden lg:hidden" role="dialog" aria-modal="true">
        <div class="fixed inset-0 z-10"></div>
        <div class="fixed inset-y-0 right-0 z-10 w-full overflow-y-auto bg-white px-6 py-6 sm:max-w-sm sm:ring-1 sm:ring-gray-900/10">
            <div class="flex items-center justify-end">
                <button type="button" class="-m-2.5 rounded-md p-2.5 text-gray-700">
                    <span class="sr-only">Close menu</span>
                    <svg class="size-6" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" aria-hidden="true" data-slot="icon">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
            <div class="mt-6 flow-root">
                <div class="-my-6 divide-y divide-gray-500/10">
                    <div class="space-y-2 py-6">
                        <a href="<?= base_url('home'); ?>" class="<?= ($currentRoute == 'home') ? 'text-blue-500' : 'text-gray-900'; ?> -mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold hover:bg-gray-100">Home</a>
                        <?php if ($user['role'] == 'admin'): ?>
                            <a href="<?= base_url('users'); ?>" class="<?= ($currentRoute == 'users') ? 'text-blue-500' : 'text-gray-900'; ?> -mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold hover:bg-gray-100">User</a>
                        <?php else: ?>
                            <a href="<?= base_url('users/quiz-history'); ?>" class="<?= ($currentRoute == 'users/quiz-history') ? 'text-blue-500' : 'text-gray-900'; ?> -mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold hover:bg-gray-100">History</a>
                        <?php endif; ?>
                        <a href="<?= base_url('users/ranking'); ?>" class="<?= ($currentRoute == 'users/ranking') ? 'text-blue-500' : 'text-gray-900'; ?> -mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold hover:bg-gray-100">Ranking</a>
                        <?php if ($user['role'] == 'admin'): ?>
                            <a href="<?= base_url('users/feedback'); ?>" class="<?= ($currentRoute == 'users/feedback') ? 'text-blue-500' : 'text-gray-900'; ?> -mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold hover:bg-gray-100">Feedback</a>
                        <? else: ?>
                            <a href="<?= base_url('users/feedback-form'); ?>" class="<?= ($currentRoute == 'users/feedback-form') ? 'text-blue-500' : 'text-gray-900'; ?> -mx-3 block rounded-lg px-3 py-2 text-base/7 font-semibold hover:bg-gray-100">Feedback</a>
                        <?php endif; ?>
                    </div>
                    <div class="py-6">
                        <a href="<?= base_url('logout'); ?>" class="-mx-3 block rounded-lg px-3 py-2.5 text-base/7 font-semibold text-gray-900 hover:bg-gray-100">Log out</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>

<script>
    const menuButton = document.querySelector('.lg\\:hidden button');
    const mobileMenu = document.querySelector('.lg\\:hidden[role="dialog"]');
    const closeButton = mobileMenu.querySelector('button');

    menuButton.addEventListener('click', () => {
        mobileMenu.classList.remove('hidden');
    });

    closeButton.addEventListener('click', () => {
        mobileMenu.classList.add('hidden');
    });
</script>