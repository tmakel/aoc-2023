<?php

function readInput($file) {
    $f = fopen($file, 'r');

    while ($line = trim(fgets($f), "\n\r")) {
        $lines[] = $line;
    }

    return $lines;
}

// $input = readInput('example-input.txt');
$input = readInput('input.txt');

$symbol_positions = [];
$number_positions = [];
$line_count = 0;
foreach ($input as $line) {
    // First get symbol positions
    if (!$line_symbol = preg_filter('/[0-9]/', '.', $line)) {
        $line_symbol = $line;
    }

    // var_dump($line_symbol);

    for ($i = 0; $i < strlen($line_symbol); $i++) {
        if ($line_symbol[$i] !== '.') {
            $symbol_positions[$line_count][$i] = true;
        }
    }

    // Then get the numbers for each line and determine their position
    if (!$line_numbers = preg_filter("/\D/", '.', $line)) {
        $line_numbers = $line;
    }

    // var_dump($line_numbers);

    $numbers = array_filter(explode('.', $line_numbers));
    $start_pos = 0;
    foreach ($numbers as $num) {
        $len = strlen($num);
        $pos = strpos($line_numbers, $num, $start_pos);

        $number_lines[$line_count][] = [
            'num' => $num,
            'pos' => $pos,
            'len' => $len,
        ];

        $start_pos = $pos + $len;
    }

    $line_count++;
}

// var_dump($symbol_positions);
// var_dump(array_key_last($symbol_positions));
// var_dump($max_symbol_line);
// var_dump($number_lines);
// var_dump($max_symbol_line);
// die();

$max_symbol_line = array_key_last($symbol_positions);

$part_number_sum = 0;
foreach ($number_lines as $line => $numbers) {
    echo $line . PHP_EOL;

    foreach ($numbers as $number_details) {
        $number = $number_details['num'];
        $length = $number_details['len'];
        $pos_front = $number_details['pos'];
        $pos_rear = $pos_front + $length - 1;

        $is_part_number = false;

        // First check positions on same line
        if (array_key_exists($line, $symbol_positions)) {
            $current_line_symbols = $symbol_positions[$line];

            //  oxxxo
            $is_part_number = array_key_exists($pos_front - 1, $current_line_symbols) || array_key_exists($pos_rear + 1, $current_line_symbols);
        }

        // Check positions one line below
        if (!$is_part_number && ($line < $max_symbol_line)) {
            $line_below = $line + 1;
            if (array_key_exists($line_below, $symbol_positions)) {
                $line_below_symbols = $symbol_positions[$line_below];

                //  xxx
                // o   o
                $is_part_number = array_key_exists($pos_front - 1, $line_below_symbols) || array_key_exists($pos_rear + 1, $line_below_symbols);
                //  xxx
                //  o o
                $is_part_number = $is_part_number || (array_key_exists($pos_front, $line_below_symbols) || array_key_exists($pos_rear, $line_below_symbols));
                //  xxx
                //   o
                $is_part_number = $is_part_number || (array_key_exists($pos_front + 1, $line_below_symbols) || array_key_exists($pos_rear - 1, $line_below_symbols));
            }
        }

        // Check positions one line above
        if (!$is_part_number && ($line > 0)) {
            $line_above = $line - 1;
            if (array_key_exists($line_above, $symbol_positions)) {
                $line_above_symbols = $symbol_positions[$line_above];

                // o   o
                //  xxx
                $is_part_number = array_key_exists($pos_front - 1, $line_above_symbols) || array_key_exists($pos_rear + 1, $line_above_symbols);
                //  o o
                //  xxx
                $is_part_number = $is_part_number || (array_key_exists($pos_front, $line_above_symbols) || array_key_exists($pos_rear, $line_above_symbols));
                //   o
                //  xxx
                $is_part_number = $is_part_number || (array_key_exists($pos_front + 1, $line_above_symbols) || array_key_exists($pos_rear - 1, $line_above_symbols));
            }
        }

        if ($is_part_number) {
            $part_number_sum = $part_number_sum + $number;
        }

        echo "--- $number : $pos_front : $pos_rear : " . (int) $is_part_number . " ($part_number_sum)". PHP_EOL;
    }
}

echo PHP_EOL;
echo "Part number sum: $part_number_sum";
echo PHP_EOL;
