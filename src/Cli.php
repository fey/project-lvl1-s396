<?php

namespace BrainGames\Cli;

use function cli\line;
use function cli\prompt;
use function cli\menu as cliMenu;
const ROUNDS = 3;
function run($description = null, $game = null)
{
    line('Welcome to the Brain Games!');
    if ($game) {
        $playerName = prompt('May I have your name?');
        line(PHP_EOL . 'Hello, %s! ' . PHP_EOL, $playerName);
        line($description . PHP_EOL);

        for ($i = 1; $i <= ROUNDS; $i += 1) {
            ['question' => $question, 'answer' => $gameAnswer] = $game();
            line('Question: %s', $question);
            $playerAnswer = prompt('Your answer');

            if ($gameAnswer === $playerAnswer && $gameRound <= ROUNDS) {
                line('Correct!');
            } else {
                line("'%s' is wrong answer ;(. Correct answer was '%s'." . PHP_EOL, $playerAnswer, $gameAnswer);
                line("Let's try again, %s!" . PHP_EOL, $playerName);

                return menu();
            }
        }


        return menu();
    }
}
function menu()
{

    $games = require __DIR__ . '/Gameset.php';

    $game = cliMenu($games, $default = false, $title = 'Choose a game number');
    if (function_exists($game)) {
        return $game();
    }
    line("Wrong game number!");
    return menu();
}
