<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: index.php
 * Main Entry Point for PHP / MySQL Deployment
 */
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';

$projects = getProjects('All');
?>

<main id="home">
    <!-- Hero Section -->
    <section class="py-20 lg:py-28 relative overflow-hidden border-b border-neutral-200/80 dark:border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 items-center">
                
                <!-- Left: Typography & Intro -->
                <div class="lg:col-span-7 space-y-6">
                    <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-rose-50 dark:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-semibold uppercase tracking-wider border border-rose-200/60 dark:border-rose-900/40">
                        <span class="w-2 h-2 rounded-full bg-rose-500 animate-pulse"></span>
                        <span>Available for Projects & Collaboration</span>
                    </div>

                    <h1 class="text-4xl sm:text-6xl font-extrabold font-heading text-neutral-900 dark:text-white tracking-tight leading-[1.1]">
                        Creative Web Developer & <span class="text-rose-600">Graphic Designer</span>
                    </h1>

                    <p class="text-lg text-neutral-600 dark:text-neutral-300 max-w-xl leading-relaxed">
                        Hi, I'm <strong class="text-neutral-900 dark:text-white">Rasindu Nawod</strong> from Matara, Sri Lanka. I bridge computational programming with clean visual design to craft responsive websites and compelling brand identities.
                    </p>

                    <!-- CTAs -->
                    <div class="flex flex-wrap items-center gap-4 pt-2">
                        <a href="#projects" class="px-6 py-3.5 rounded-xl font-semibold text-sm text-white bg-rose-600 hover:bg-rose-700 shadow-md transition-all">
                            View My Work
                        </a>
                        <a href="assets/cv/Rasindu-Nawod-CV.pdf" download class="px-6 py-3.5 rounded-xl font-semibold text-sm text-neutral-800 dark:text-neutral-200 bg-neutral-100 dark:bg-neutral-800 hover:bg-neutral-200 border border-neutral-300 dark:border-neutral-700 transition-all">
                            Download My CV
                        </a>
                        <a href="#contact" class="px-6 py-3.5 rounded-xl font-semibold text-sm text-neutral-700 dark:text-neutral-300 hover:text-rose-600">
                            Contact Me →
                        </a>
                    </div>
                </div>

                <!-- Right: Visual Badge / Terminal Mockup -->
                <div class="lg:col-span-5">
                    <div class="p-6 rounded-3xl bg-neutral-900 text-white border border-neutral-800 shadow-2xl space-y-4">
                        <div class="flex items-center justify-between pb-3 border-b border-neutral-800">
                            <div class="flex items-center gap-2">
                                <div class="w-3 h-3 rounded-full bg-rose-500"></div>
                                <div class="w-3 h-3 rounded-full bg-amber-500"></div>
                                <div class="w-3 h-3 rounded-full bg-emerald-500"></div>
                            </div>
                            <span class="text-[11px] font-mono text-neutral-400">rasindu.profile.php</span>
                        </div>
                        <div class="font-mono text-xs space-y-2 text-neutral-300">
                            <p><span class="text-rose-400">$developer</span> = new Developer('Rasindu Nawod');</p>
                            <p><span class="text-rose-400">$roles</span> = ['Web Developer', 'Graphic Designer'];</p>
                            <p><span class="text-rose-400">$education</span> = 'ICBT Campus (Software Engineering)';</p>
                            <p><span class="text-rose-400">$location</span> = 'Sri Lanka | Matara | Akuressa';</p>
                            <p><span class="text-emerald-400">// Ready to build modern web solutions</span></p>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Projects Section -->
    <section id="projects" class="py-20 bg-neutral-50 dark:bg-[#0e1015] border-b border-neutral-200/80 dark:border-neutral-800/80">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-2xl mx-auto mb-14">
                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Portfolio</span>
                <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white mt-1">Featured Case Studies</h2>
                <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto my-3"></div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <?php foreach ($projects as $project): ?>
                <div class="rounded-2xl bg-white dark:bg-neutral-900 border border-neutral-200 dark:border-neutral-800 overflow-hidden flex flex-col justify-between">
                    <img src="<?= htmlspecialchars($project['image']); ?>" alt="<?= htmlspecialchars($project['title']); ?>" class="w-full aspect-video object-cover">
                    <div class="p-6 flex-1 flex flex-col justify-between">
                        <div>
                            <span class="text-xs font-semibold text-rose-600 uppercase"><?= htmlspecialchars($project['category']); ?></span>
                            <h3 class="text-lg font-bold font-heading text-neutral-900 dark:text-white mt-1 mb-2"><?= htmlspecialchars($project['title']); ?></h3>
                            <p class="text-xs text-neutral-600 dark:text-neutral-400 leading-relaxed mb-4"><?= htmlspecialchars($project['description']); ?></p>
                        </div>
                        <div class="pt-4 border-t border-neutral-100 dark:border-neutral-800 flex justify-between items-center text-xs">
                            <span class="font-mono text-[11px] text-neutral-500"><?= htmlspecialchars($project['technologies']); ?></span>
                            <?php if (!empty($project['github_url'])): ?>
                                <a href="<?= htmlspecialchars($project['github_url']); ?>" target="_blank" class="text-rose-600 font-semibold hover:underline">GitHub</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </section>

    <!-- Contact Form Section -->
    <section id="contact" class="py-20 bg-white dark:bg-[#12141c]">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-semibold uppercase tracking-wider text-rose-600">Get In Touch</span>
                <h2 class="text-3xl font-extrabold font-heading text-neutral-900 dark:text-white mt-1">Let's Create Together</h2>
                <div class="w-12 h-1 bg-rose-500 rounded-full mx-auto my-3"></div>
            </div>

            <div id="form-feedback" class="hidden p-4 rounded-xl mb-6 text-xs sm:text-sm font-semibold"></div>

            <form id="contact-form" action="contact.php" method="POST" class="p-8 rounded-3xl bg-neutral-50 dark:bg-neutral-900/80 border border-neutral-200 dark:border-neutral-800 space-y-4">
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Your Name *</label>
                        <input type="text" name="name" required class="w-full px-4 py-3 rounded-xl text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Email Address *</label>
                        <input type="email" name="email" required class="w-full px-4 py-3 rounded-xl text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Phone (Optional)</label>
                        <input type="tel" name="phone" class="w-full px-4 py-3 rounded-xl text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Subject *</label>
                        <input type="text" name="subject" required class="w-full px-4 py-3 rounded-xl text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700">
                    </div>
                </div>

                <div>
                    <label class="block text-xs font-semibold text-neutral-700 dark:text-neutral-300 mb-1">Message *</label>
                    <textarea name="message" rows="5" required class="w-full px-4 py-3 rounded-xl text-sm bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700"></textarea>
                </div>

                <button type="submit" class="w-full py-3.5 px-6 rounded-xl font-semibold text-sm text-white bg-rose-600 hover:bg-rose-700 transition-all cursor-pointer">
                    Send Message
                </button>
            </form>
        </div>
    </section>
</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>
