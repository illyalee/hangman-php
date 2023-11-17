<?php

class Main
{
    public $word;

    function startGame() {
        $userInput = (string)readline("Wanna play?: (y/n)");
        $answer = $this->checkStartGameAnswer($userInput);
        if($answer === true) {
            print 'game started!';
            $this->getRandomWord();

        } else {
            print 'exit';
            die;
        }
 }
    function checkStartGameAnswer($answer) {
        if ($answer === 'y' || $answer === 'yes') {
            return true;
        } else {
            return false;
        }
    }

    function getRandomWord() {
        $words = $this->getFile('words.txt');
        $minNum = 0;
        $maxNum = sizeof($words);
        $randomNumber = rand($minNum, $maxNum);
        $word = $words[$randomNumber];
        return $word;
    }

    function getFile($name) {
        return $words = file($name,0, null);
    }
}