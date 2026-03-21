document.addEventListener('DOMContentLoaded', function () {
    var toggle = document.getElementById('mobile-toggle');
    var nav = document.getElementById('main-nav');

    if (toggle && nav) {
        toggle.addEventListener('click', function () {
            nav.classList.toggle('open');
        });
    }

    document.querySelectorAll('form[data-ajax="true"]').forEach(function (form) {
        form.addEventListener('submit', function (event) {
            event.preventDefault();

            var submitButton = form.querySelector('button[type="submit"]');
            if (submitButton) {
                submitButton.disabled = true;
            }

            var formData = new FormData(form);

            fetch(form.getAttribute('action'), {
                method: 'POST',
                body: formData
            })
                .then(function (response) {
                    return response.json();
                })
                .then(function (payload) {
                    var targetId = form.getAttribute('data-flash-target');
                    var flashNode = targetId ? document.getElementById(targetId) : null;

                    if (flashNode) {
                        flashNode.className = payload.success ? 'flash success' : 'flash error';
                        flashNode.textContent = payload.message || 'Request completed.';
                        flashNode.style.display = 'block';
                    } else {
                        alert(payload.message || 'Request completed.');
                    }

                    if (payload.success) {
                        form.reset();
                    }
                })
                .catch(function () {
                    alert('Something went wrong while sending your form. Please try again.');
                })
                .finally(function () {
                    if (submitButton) {
                        submitButton.disabled = false;
                    }
                });
        });
    });

    initLatestNoticeModal();
    initRevealAnimations();
});

function initRevealAnimations() {
    var revealElements = document.querySelectorAll('.reveal');
    if (!revealElements.length) {
        return;
    }

    if (!('IntersectionObserver' in window)) {
        revealElements.forEach(function (el) {
            el.classList.add('show');
        });
        return;
    }

    var observer = new IntersectionObserver(function (entries, io) {
        entries.forEach(function (entry) {
            if (entry.isIntersecting) {
                entry.target.classList.add('show');
                io.unobserve(entry.target);
            }
        });
    }, {
        threshold: 0.12,
        rootMargin: '0px 0px -30px 0px'
    });

    revealElements.forEach(function (el) {
        observer.observe(el);
    });
}

function initLatestNoticeModal() {
    var modal = document.getElementById('latest-notice-modal');
    if (!modal) {
        return;
    }

    var noticeId = modal.getAttribute('data-notice-id');
    if (!noticeId) {
        return;
    }

    var seenKey = 'karuna_latest_notice_seen';
    var visitKey = 'karuna_has_visited';
    var shouldOpen = false;

    try {
        var lastSeen = localStorage.getItem(seenKey);
        var hasVisited = localStorage.getItem(visitKey) === '1';
        shouldOpen = !hasVisited || lastSeen !== noticeId;
    } catch (error) {
        shouldOpen = true;
    }

    if (!shouldOpen) {
        return;
    }

    openModal();

    modal.querySelectorAll('[data-notice-close]').forEach(function (button) {
        button.addEventListener('click', function () {
            markSeen();
            closeModal();
        });
    });

    modal.querySelectorAll('[data-notice-view]').forEach(function (button) {
        button.addEventListener('click', function () {
            markSeen();
        });
    });

    modal.addEventListener('click', function (event) {
        if (event.target === modal) {
            markSeen();
            closeModal();
        }
    });

    document.addEventListener('keydown', function (event) {
        if (event.key === 'Escape' && modal.classList.contains('open')) {
            markSeen();
            closeModal();
        }
    });

    function markSeen() {
        try {
            localStorage.setItem(seenKey, noticeId);
            localStorage.setItem(visitKey, '1');
        } catch (error) {
            // Ignore storage write errors.
        }
    }

    function openModal() {
        modal.classList.add('open');
        document.body.style.overflow = 'hidden';
    }

    function closeModal() {
        modal.classList.remove('open');
        document.body.style.overflow = '';
    }
}
