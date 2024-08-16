<?php

use App\Models\User\SessionDB;

require("vendor/autoload.php");
(new SessionDB($pdo))->deleteSession();

header("Location: /");
