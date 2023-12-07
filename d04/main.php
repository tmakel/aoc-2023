<?php

function readInput($file) {
    $f = fopen($file, 'r');

    while ($line = trim(fgets($f), "\n\r")) {
        $lines[] = $line;
    }

    return $lines;
}

$input = readInput('example-input.txt');
$input = readInput('input.txt');

$total_points = 0;
$card_count = 1;
foreach ($input as $card) {
    $split = explode ('|', $card);

    $my_numbers = array_filter(explode(' ', $split[1]));
    // var_dump($my_numbers);
    // die();

    $split_winning = explode(':', $split[0]);
    $winning_numbers = array_filter(explode(' ', $split_winning[1]));
    // var_dump($winning_numbers);
    // die();

    $winning_collection = [];
    $card_points = 0;
    echo "Card $card_count" . PHP_EOL;
    foreach ($my_numbers as $my_number) {
        if (in_array($my_number, $winning_numbers)) {
            $winning_collection[] = $my_number;

            switch (count($winning_collection)) {
                case 0:
                    $card_points = 0;
                    break;

                case 1:
                    $card_points = 1;
                    break;

                default:
                    $card_points = 2 * $card_points;
            }
        }
    }
    // var_dump($card_points);
    // die();

    sort($winning_numbers);
    sort($winning_collection);
    echo "--- winning numbers   : " . implode(',', $winning_numbers) . PHP_EOL;
    echo "--- my winning numbers: " . implode(',', $winning_collection) . PHP_EOL;
    echo "--- card points       : $card_points" . PHP_EOL . PHP_EOL;

    $total_points = $total_points + $card_points;

    $card_count++;
}

echo PHP_EOL;
echo "Total points: $total_points" . PHP_EOL;
