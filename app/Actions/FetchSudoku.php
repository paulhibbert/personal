<?php

namespace App\Actions;

class FetchSudoku
{
    public function fetch(): array
    {
        $fileName = storage_path('app/private/sudoku.txt');
        $sudokuFile = fopen($fileName, 'r');
        if ($sudokuFile === false) {
            return [];
        }
        $sudoku = [];
        $buffer = fgets($sudokuFile , 164);                         // first one is different length, missing opening [ so we discard it
        $random_sudoku = mt_rand (1,999999);                        // there are a million sudokus minus the first one we discarded
        fseek ( $sudokuFile , $random_sudoku*164 , SEEK_CUR);       // set the pointer to the start of random sudoku
        $buffer = fgets($sudokuFile , 165);                         // get the sudoku clues [3; ; ;4; ;....]
        $clues = explode(";",substr($buffer,1,162));                // get the blanks or numbers from inside the array like string
        $row = 0;
        $col = 0;
        for ($idx = 0; $idx <= 80; $idx++) {                        // loop through 81 entries of array
            if ($clues[$idx] == " ") {                              // blank so it is not a clue
                continue;
            }
            $col = match (true) {                                   // get the row and column for the clue
                    $idx < 9 => $idx,                               // first row, the index into array is the column
                    default => $idx % 9,                            // otherwise get the remainder after divide by 9 
            };
            $row = match ($idx) {                                   // get the row and column for the clue
                     0 => 0,                                        // first cell avoid divide by zero
                     default => floor($idx / 9),                    // otherwise get the index divided by 9, no remainder
            };
            $sudoku[] = ['num' => $clues[$idx], 'row' => $row, 'column' => $col];
		}

        fclose($sudokuFile);
        return $sudoku;
    }
}
