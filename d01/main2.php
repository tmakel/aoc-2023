<?php

// $f = fopen('example-input.txt', 'r');
$f = fopen('input.txt', 'r');

$total = 0;

while ($line = trim(fgets($f), "\n\r")) {
    $line_org = $line;

    $search = ['/one/', '/two/', '/three/', '/four/', '/five/', '/six/', '/seven/', '/eight/', '/nine/'];
    $replace = ['o1e', 't2o', 'th3ee', 'f4r', 'f5e', 's6', 's7n', 'e8t', 'n9e'];
    $line = preg_replace($search, $replace, $line);

    // $search = ['one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
    // do {
    //     $score = [];
    //     for ($i = 0; $i < count($search); $i++) {
    //         $pos = strpos($line, $search[$i]);
    //         if ($pos !== false) {
    //             $score[$i] = $pos;
    //         }
    //     }

    //     asort($score);

    //     $found = count($score);
    //     if ($found > 0) {
    //         $key = array_key_first($score);
    //         $line = str_replace($search[$key], $replace[$key], $line);
    //     }
    // } while ($found > 0);

    $line_pass2 = $line;

    if (!$digits = preg_filter("/[a-z]/", "", $line)) {
        $digits = $line;
    };

    if (strlen($digits) > 1) {
        $number = substr($digits, 0, 1) . substr($digits, -1);
    } else {
        $number = substr($digits, 0, 1) . substr($digits, 0, 1);
    }

    $total = $total + $number;

    echo "$line_org : $line_pass2 : $digits : $number : $total" . PHP_EOL;
}

echo PHP_EOL;
echo "Total = $total" . PHP_EOL;
