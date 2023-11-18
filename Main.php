<?php

class Main
{
    public $word;
    public $roundWord;
    public $mistakeCounter = 0;
    function startGame() {
        $userInput = (string)readline("Wanna play?: (y/n)");
        $answer = $this->checkStartGameAnswer($userInput);
        if($answer === true) {
            print "game started!\n";
            $this->word = $this->getRandomWord();
            $this->startRound();
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
        return $words[$randomNumber];
    }

    function getFile($name) {
        return $words = file($name,0, null);
    }
    function normalizeChar($str, $index) {
        $char = mb_substr($str, $index, 1, 'UTF-8');
        return $char;
    }

    function convertWord($str, $letter = '') {
        if(empty($letter)) {
            $this->roundWord = '';
            for ($i = 0; $i <=  mb_strlen($str) - 1; $i++) {
                $char = $this->normalizeChar($str, $i);
                $this->roundWord .= '*';
            }

        }
    }
    function startRound() {
    if(empty($this->roundWord)) {
        $this->convertWord($this->word);
    }
}
//    function
}