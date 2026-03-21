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
});
