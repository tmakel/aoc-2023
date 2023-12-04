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
$sum_power = 0;

foreach ($lines as $game) {
    $parts = explode(':', $game);

    $id = (int) $parts[0];
    $sets = explode(';', $parts[1]);

    echo $id . PHP_EOL;

    $set_row = 0;
    $game_min = [
        'red' => 0,
        'green' => 0,
        'blue' => 0
    ];
    $game_power = 0;
    foreach ($sets as $set) {
        $set_parts = explode(',', $set);

        echo "--- $set_row" . PHP_EOL;

        foreach ($set_parts as $set_count) {
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
            $count = explode(' ', $set_count);

            if ((int) $count[1] > $game_min[$count[2]]) {
                $game_min[$count[2]] = (int) $count[1];
            }
        }

        $set_row++;
    }

    var_dump($game_min);

    $game_power = $game_min['red'] * $game_min['green'] * $game_min['blue'];
    echo "Game power: $game_power" . PHP_EOL . PHP_EOL;
    $sum_power = $sum_power + $game_power;
}

echo "Sum power: $sum_power" . PHP_EOL;
