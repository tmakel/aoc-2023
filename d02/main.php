<?php

function readInput($file) {
    $f = fopen($file, 'r');

    while ($line = trim(fgets($f), "\n\r")) {
        $line = str_replace('Game ', '', $line);
        $lines[] = $line;
    }

    return $lines;
}

// $lines = readInput('example-input.txt');
$lines = readInput('input.txt');

$max = [
    'red' => 12,
    'green' => 13,
    'blue' => 14
];

$id_sum = 0;
foreach ($lines as $game) {
    $parts = explode(':', $game);

    $id = (int) $parts[0];
    $results = explode(';', $parts[1]);

    echo $id . PHP_EOL;

    $result_row = 0;
    $possible = true;
    foreach ($results as $result) {
        $result_parts = explode(',', $result);

        echo "--- $result_row" . PHP_EOL;

        foreach ($result_parts as $result_count) {
            $count = explode(' ', $result_count);

            echo "------ $count[2] : $count[1]";
            /*
            array(3) {
                [0]=>
                string(0) ""
                [1]=>
                string(1) "2"
                [2]=>
                string(5) "green"
            }
            */
            if ($max[$count[2]] < (int) $count[1]) {
                $possible = false;
                echo ' --> no' . PHP_EOL;
            } else {
                echo ' --> yes' . PHP_EOL;
            }
        }

        $result_row++;
    }

    if ($possible) {
        $id_sum = $id_sum + $id;
    }
}

echo PHP_EOL . "$id_sum" . PHP_EOL;
