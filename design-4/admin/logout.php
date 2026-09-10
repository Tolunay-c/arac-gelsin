<?php

declare(strict_types=1);

require_once __DIR__ . '/../config/bootstrap.php';

use App\Support\Auth;

Auth::logout();
redirect('login.php');
