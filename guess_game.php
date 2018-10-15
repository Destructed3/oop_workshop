<?php

class Number {
    private $number;
    
    public function gen_number() {
        $this->number = rand(1,100);
    }

    public function compare_number(int $num) {
        if($this->number < $num) {
            return 1;
        } else if($this->number > $num) {
            return -1;
        } else {
            return 0;
        }
    }
}

class Player {
    public function get_number() {
        echo "Bitte gib eine Zahl von 1-100 ein!\n";
        
        $line = $this->get_input();
        if(is_numeric($line)) {
            $p_num = intval($line);
            if($p_num <= 100 && $p_num > 0) {
                return $p_num;
            }
        }
        return $this->get_number();
    }

    public function get_input() {
        $handle = fopen("php://stdin", "r");
        $answer = trim(fgets($handle));
        fclose($handle);
        return $answer;
    }
}

class Game {
    private $number;
    private $player;

    public function __construct() {
        $this->number = new Number();
        $this->player = new Player();

        $this->start_game();
    }

    public function start_game() {
        $this->number->gen_number();

        $this->explain_rules();
        $this->game_loop();
        $this->afterword();
    }

    private function game_loop() {
        $p_num = $this->player->get_number();
        $return = $this->number->compare_number($p_num);
        switch($return) {
            case 1: 
                echo "\nMit $p_num hast du zu hoch geraten!\n\n";
                $this->game_loop();
                break;
            case 0:
                echo "\nDu hast gewonnen!\n\n";
                break;
            case -1:
                echo "\nMit $p_num hast du zu tief geraten!\n\n";
                $this->game_loop();
                break;
        }
    }

    private function explain_rules() {
        echo "Willkommen zum Zahlenrat-Spiel!\n";
        echo "\n";
        echo "Der Computer generiert eine Zahl zwischen 1 und 100.\n";
        echo "Du musst sie erraten!\n";
        echo "Nach jedem Versuch, sagt dir der Computer, ob du zu hoch oder zu tief geraten hast...\n";
        echo "Und jetzt: viel Erfolg!\n";
        echo "\n";
    }

    private function afterword() {
        echo "Möchtest du noch einmal spielen? (yes/no)\n";
        $answer = $this->player->get_input();
        echo "\n";
        if($answer == "yes" || $answer == "y") {
            $this->start_game();
        } else {
            echo "See you soon!";
        }
    }
}

new Game();