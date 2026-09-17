<?php
/**
 * Rasindu Nawod Portfolio Website
 * File: includes/footer.php
 */
?>
<footer class="bg-neutral-950 text-neutral-300 relative pt-16 pb-12 border-t border-neutral-900">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        
        <div class="grid grid-cols-1 md:grid-cols-12 gap-10 pb-12 border-b border-neutral-800">
            <div class="md:col-span-6 space-y-4">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl bg-neutral-900 border border-neutral-700 flex items-center justify-center font-bold text-lg text-white">
                        <span>R</span><span class="text-rose-500">N</span>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold font-heading text-white">Rasindu Nawod</h3>
                        <p class="text-xs text-rose-400 font-medium">Web Developer | Graphic Designer</p>
                    </div>
                </div>
                <p class="text-sm text-neutral-400 max-w-md">
                    Passionate Sri Lankan creator crafting responsive web applications and visual brand graphics from Matara, Sri Lanka.
                </p>
            </div>

            <div class="md:col-span-3 space-y-2 text-xs">
                <h4 class="font-bold uppercase tracking-wider text-white mb-3">Navigation</h4>
                <div><a href="#about" class="text-neutral-400 hover:text-white">About</a></div>
                <div><a href="#education" class="text-neutral-400 hover:text-white">Education</a></div>
                <div><a href="#skills" class="text-neutral-400 hover:text-white">Skills & Tools</a></div>
                <div><a href="#services" class="text-neutral-400 hover:text-white">Services</a></div>
                <div><a href="#projects" class="text-neutral-400 hover:text-white">Projects</a></div>
                <div><a href="#contact" class="text-neutral-400 hover:text-white">Contact</a></div>
            </div>

            <div class="md:col-span-3 space-y-2 text-xs">
                <h4 class="font-bold uppercase tracking-wider text-white mb-3">Direct Contact</h4>
                <p class="text-neutral-400">Phone: <?= PHONE_NUMBER; ?></p>
                <p class="text-neutral-400">Email: <?= ADMIN_EMAIL; ?></p>
                <p class="text-neutral-400">Location: <?= LOCATION_INFO; ?></p>
                <div class="pt-2">
                    <a href="<?= WHATSAPP_LINK; ?>" target="_blank" class="inline-block px-3 py-1.5 rounded-lg bg-emerald-600 text-white font-semibold hover:bg-emerald-500 transition-colors">
                        Chat on WhatsApp
                    </a>
                </div>
            </div>
        </div>

        <div class="pt-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-neutral-500">
            <p>© 2026 Rasindu Nawod. All Rights Reserved.</p>
            <p>Built with PHP 8, MySQL, and Tailwind CSS.</p>
            <a href="#home" class="hover:text-white">Back to Top ↑</a>
        </div>

    </div>
</footer>

<script src="assets/js/main.js"></script>
</body>
</html>
