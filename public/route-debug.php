<?php
header('Content-Type: text/plain');

$urls = [
    'http://localhost/my-project/xdebug-check.php',
    'http://localhost/my-project/public/xdebug-check.php',
    'http://localhost/xdebug-check.php',
];

foreach ($urls as $u) {
    echo $u . "\n";
}

