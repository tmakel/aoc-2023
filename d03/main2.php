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
        if ($line_symbol[$i] === '*') {
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
            'num' => (int) $num,
            'head' => (int) $pos,
            'tail' => (int) ($pos + $len - 1),
            'len' => (int) $len,
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

$gear_ratio_sum = 0;
foreach ($symbol_positions as $line => $line_symbols) {
    echo "- $line" . PHP_EOL;

    foreach ($line_symbols as $pos => $void) {
        $gears = [];

        // First check gears on same line as symbol
        if (array_key_exists($line, $number_lines)) {
            $numbers = $number_lines[$line];

            foreach ($numbers as $number) {
                // var_dump($number);
                // var_dump($pos);
                // die();

                // xxx*
                if (($pos - 1) == $number['tail']) {
                    $gears[] = $number['num'];
                }

                // *xxx
                if (($pos + 1) == $number['head']) {
                    $gears[] = $number['num'];
                }
            }
            // var_dump($gears);
        }

        // Check gears on the line above
        if (array_key_exists($line - 1, $number_lines)) {
            $numbers = $number_lines[$line - 1];

            foreach ($numbers as $number) {
                // var_dump($number);
                // var_dump($pos);
                // die();

                //    xxx
                //    *
                // (between head and tail)
                if (($pos + 1 >= $number['head']) && ($pos - 1 <= $number['tail'])) {
                    $gears[] = $number['num'];
                }
            }
        }

        // Check gears on the line below
        if (array_key_exists($line + 1, $number_lines)) {
            $numbers = $number_lines[$line + 1];

            foreach ($numbers as $number) {
                // var_dump($number);
                // var_dump($pos);
                // die();

                //    *
                //    xxx
                // (between head and tail)
                if (($pos + 1 >= $number['head']) && ($pos - 1 <= $number['tail'])) {
                    $gears[] = $number['num'];
                }
            }

            var_dump($gears);
            if (count($gears) === 2) {
                $gear_ratio_sum = $gear_ratio_sum + ($gears[0] * $gears[1]);
            }
        }
    }
}

echo PHP_EOL;
echo "Gear ration sum: $gear_ratio_sum";
echo PHP_EOL;
