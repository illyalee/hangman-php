<?php
class Main
{
private array $hangmanASCII = ["
  +---+
  |   |
      |
      |
      |
      |
=========", "
  +---+
  |   |
  O   |
      |
      |
      |
=========", "
  +---+
  |   |
  O   |
  |   |
      |
      |
=========", "
  +---+
  |   |
  O   |
 /|   |
      |
      |
=========", "
  +---+
  |   |
  O   |
 /|\  |
      |
      |
=========", "
  +---+
  |   |
  O   |
 /|\  |
 /    |
      |
=========", "
  +---+
  |   |
  O   |
 /|\  |
 / \  |
      |
========="];
private array $word = [];
private int $mistakes = 0;
private array $enteredLetters = [];
    function main() {
        $start = $this->joinGame();
        do {
            if($start) {
                $this->gameLoop();
                $this->clearGameData();
            }
            $start = $this->joinGame();
        } while ($start);
    }
    function joinGame(): bool
    {
        $userInput = (string)readline("Wanna play?: (y/n)");
        if ($userInput === 'y' || $userInput === 'yes') {
            return true;
        } else {
            return false;
        }
    }
    function gameLoop(): void
    {
        $this->setRandomWord();
        do {
           $gameEnd = $this->startRound();
           if($gameEnd) {
               return;
           }
        } while ($this->mistakes < 6);
        echo "Упс..Вы проиграли!" . "\n";
    }
    function getFile($name): false|array
    {
        return file($name,0, null);
    }
    function getMBLetter($str, $index): string
    {
        return mb_substr($str, $index, 1);
    }
    function setRandomWord(): void
    {
        $words = $this->getFile('words.txt');
        $randomNumber = $this->getRandomNumberBySize(0, sizeof($words));
        $word = mb_strtolower($words[$randomNumber]);
        echo "Для тестирования))" . $word;
        for ($i = 0; $i < mb_strlen($word) - 1; $i++) {
            $value = [
                "letter" => $this->getMBLetter($word, $i),
                "show" => false
            ];
            $this->word[] = $value;
        }
    }
    function getRandomNumberBySize($minNum, $maxNum): int
    {
        return rand($minNum, $maxNum);
    }
    function startRound(): false|string
    {
        $this->showGameStatus();
        $letter = $this->getUserLetter();
        if(!$letter) {
            echo 'Ошибка валидации. Принимаются маленькие буквы кириллицы. Не повторяйте уже загаданные буквы.' . "\n";
            return false;
        }
        $hasFound = $this->findLetterInWord($letter);
        $win = $this->checkWin();
        if($win) {
            $this->showGameStatus();
            echo 'Поздравляю! Вы победили!' . "\n";
            return true;
        }
        if (!$hasFound) {
            $this->showHangman($letter);
        }
        return false;
    }
    function getUserLetter(): string
    {
        $letter = (string)readline("Введите букву: ");
        return $this->validateLetter($letter);
    }
    function validateLetter($str): string
    {
        $isNotCyrillic = preg_match( "/[а-я]/", $str ) != true;
        $isTooBig = mb_strlen($str) > 1;
        $wasEntered = in_array($str, $this->enteredLetters);
        if($isNotCyrillic || $isTooBig || $wasEntered) {
            return false;
        }
       return $str;
    }
    function findLetterInWord($letter): bool
    {
        $hasFound = false;
        for ($i = 0; $i <  count($this->word); $i++) {
            if($letter == $this->word[$i]['letter']) {
                $this->word[$i]["show"] = true;
                $hasFound = true;
            }
        }
        return $hasFound;
    }
    function showWord(): void
    {
        foreach ($this->word as $value) {
           if($value["show"]) {
               echo $value["letter"];
           } else {
               echo "*";
           }
        }
    }
    function showHangman($char): void
    {
        $this->mistakes += 1;
        $this->enteredLetters[] = $char;
        echo $this->hangmanASCII[$this->mistakes];
        echo "\n";
    }
    function showGameStatus(): void
    {
        echo "\n";
        $this->showWord();
        echo "\n";
        $mistakesLetter = '';
        foreach ($this->enteredLetters as $value) {
            $mistakesLetter .= $value . ",";
        }
        echo "Ошибок: " . $this->mistakes . " - " . "[" . rtrim($mistakesLetter, ",") . "]";
        echo "\n";
    }
    function checkWin() {
        $win = true;
        for ($i = 0; $i < count($this->word); $i++) {
            if(!$this->word[$i]["show"]) {
                $win = false;
            }
        }
        return $win;
    }
    function clearGameData(): string
    {
        $this->word = [];
        $this->mistakes = 0;
        $this->enteredLetters = [];
        return '';
    }
}