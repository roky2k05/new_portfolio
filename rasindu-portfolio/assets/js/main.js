/**
 * Rasindu Nawod Portfolio Custom JavaScript
 * File: assets/js/main.js
 */

document.addEventListener('DOMContentLoaded', () => {
    // Theme Management
    const themeToggleBtn = document.getElementById('theme-toggle');
    const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
    const savedTheme = localStorage.getItem('rasindu_theme');

    if (savedTheme === 'dark' || (!savedTheme && prefersDark)) {
        document.documentElement.classList.add('dark');
    } else {
        document.documentElement.classList.remove('dark');
    }

    if (themeToggleBtn) {
        themeToggleBtn.addEventListener('click', () => {
            const isDark = document.documentElement.classList.toggle('dark');
            localStorage.setItem('rasindu_theme', isDark ? 'dark' : 'light');
        });
    }

    // Contact Form AJAX Submission
    const contactForm = document.getElementById('contact-form');
    const feedbackDiv = document.getElementById('form-feedback');

    if (contactForm) {
        contactForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const submitBtn = contactForm.querySelector('button[type="submit"]');
            const originalBtnText = submitBtn.innerHTML;
            submitBtn.disabled = true;
            submitBtn.innerHTML = 'Sending...';

            if (feedbackDiv) {
                feedbackDiv.className = 'hidden';
            }

            const formData = new FormData(contactForm);

            try {
                const response = await fetch('contact.php', {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'Accept': 'application/json'
                    }
                });

                const result = await response.json();

                if (feedbackDiv) {
                    feedbackDiv.classList.remove('hidden');
                    if (result.success) {
                        feedbackDiv.className = 'p-4 rounded-xl mb-6 text-xs sm:text-sm font-semibold bg-emerald-500/20 text-emerald-400 border border-emerald-500/30';
                        feedbackDiv.innerText = result.message;
                        contactForm.reset();
                    } else {
                        feedbackDiv.className = 'p-4 rounded-xl mb-6 text-xs sm:text-sm font-semibold bg-rose-500/20 text-rose-400 border border-rose-500/30';
                        feedbackDiv.innerText = result.message || 'An error occurred. Please try again.';
                    }
                }
            } catch (err) {
                if (feedbackDiv) {
                    feedbackDiv.classList.remove('hidden');
                    feedbackDiv.className = 'p-4 rounded-xl mb-6 text-xs sm:text-sm font-semibold bg-rose-500/20 text-rose-400 border border-rose-500/30';
                    feedbackDiv.innerText = 'Network error. Please try again or message via WhatsApp.';
                }
            } finally {
                submitBtn.disabled = false;
                submitBtn.innerHTML = originalBtnText;
            }
        });
    }
});
