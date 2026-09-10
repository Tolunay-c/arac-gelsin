<?php

declare(strict_types=1);

/**
 * Every admin/*.php entry point requires this first. Boots the app,
 * enforces authentication, and makes the logged-in admin available.
 */

require_once __DIR__ . '/../../config/bootstrap.php';

use App\Support\Auth;

Auth::requireLogin();

$currentAdmin = Auth::user();
$currentPage = basename($_SERVER['SCRIPT_NAME']);
