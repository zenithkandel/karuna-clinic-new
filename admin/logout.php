<?php
require_once __DIR__ . '/_init.php';
unset($_SESSION['admin_user']);
setFlashMessage('success', 'You have been logged out successfully.');
redirect('login.php');
