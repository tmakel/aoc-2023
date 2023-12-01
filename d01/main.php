<?php

// $f = fopen('example-input.txt', 'r');
$f = fopen('input.txt', 'r');

$total = 0;

while ($line = trim(fgets($f), "\n\r")) {
    if (!$digits = preg_filter("/[a-z]/", "", $line)) {
        $digits = $line;
    };

    if (strlen($digits) > 1) {
        $number = substr($digits, 0, 1) . substr($digits, -1);
    } else {
        $number = substr($digits, 0, 1) . substr($digits, 0, 1);
    }

    $total = $total + $number;

    echo "$line : $digits : $number : $total" . PHP_EOL;
}

echo PHP_EOL;
echo "Total = $total" . PHP_EOL;
