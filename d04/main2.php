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

$winning_cards = [];
$card_copies = [];
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
    foreach ($my_numbers as $my_number) {
        if (in_array($my_number, $winning_numbers)) {
            $winning_collection[] = $my_number;
        }
    }
    // var_dump($card_points);
    // die();

    sort($winning_numbers);
    sort($winning_collection);
    $matching = count($winning_collection);
    // echo "--- winning numbers   : " . implode(',', $winning_numbers) . PHP_EOL;
    // echo "--- my winning numbers: " . implode(',', $winning_collection) . PHP_EOL;
    // echo "--- matching          : $matching" . PHP_EOL . PHP_EOL;

    $winning_cards[$card_count] = $matching;
    $card_copies[$card_count] = 1;

    $card_count++;
}

// var_dump($winning_cards);
// die();

foreach ($winning_cards as $card_number => $matching) {
    echo "$card_number : $matching" . PHP_EOL;

    if ($matching > 0 ) {
        for ($i = 1; $i <= $matching; $i++) {
            $next_card_number = $card_number + $i;

            echo "--- $next_card_number : $card_copies[$next_card_number]";

            if (array_key_exists($next_card_number, $winning_cards)) {
                $card_copies[$next_card_number] = $card_copies[$next_card_number] + $card_copies[$card_number];
            } else {
                echo "(nop)";
            }

            echo " --> $card_copies[$next_card_number]" . PHP_EOL;
            // var_dump($card_copies);
            // echo PHP_EOL;
            // die();
        }
    }
    // var_dump($card_copies);
    // die();
}

echo PHP_EOL;
var_dump($card_copies);

$total_copies = 0;
foreach ($card_copies as $copies) {
    $total_copies = $total_copies + $copies;
}

echo "Total copies: $total_copies";
echo PHP_EOL;
