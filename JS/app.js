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
});

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
