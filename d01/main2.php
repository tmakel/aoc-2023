<?php

// $f = fopen('example-input.txt', 'r');
$f = fopen('input.txt', 'r');

$total = 0;

while ($line = trim(fgets($f), "\n\r")) {
    $line_org = $line;

    $search = ['/one/', '/two/', '/three/', '/four/', '/five/', '/six/', '/seven/', '/eight/', '/nine/'];
    $replace = ['o1e', 't2o', 'th3ee', 'f4r', 'f5e', 's6', 's7n', 'e8t', 'n9e'];
    $line = preg_replace($search, $replace, $line);

    if (!$digits = preg_filter("/[a-z]/", "", $line)) {
        $digits = $line;
    };

    if (strlen($digits) > 1) {
        $number = substr($digits, 0, 1) . substr($digits, -1);
    } else {
        $number = substr($digits, 0, 1) . substr($digits, 0, 1);
    }

    $total = $total + $number;

    echo "$line_org : $digits : $number : $total" . PHP_EOL;
}

echo PHP_EOL;
echo "Total = $total" . PHP_EOL;
