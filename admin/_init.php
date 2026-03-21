<?php
require_once __DIR__ . '/../config/config.php';
require_once __DIR__ . '/../includes/functions.php';

$db = DatabaseHelper::getInstance();
$admin = getCurrentAdmin();
