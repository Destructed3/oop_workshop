<?php

class Number {
    protected $number;
    
    public function gen_number() {
        $this->number = rand(1,100);
    }

    public function compare_number(int $num) {
        echo "Comparing $num vs $this->number";
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
        
        $line = readline();
        if(is_numeric($line)) {
            $p_num = intval($line);
            if($p_num <= 100 && $p_num > 0) {
                return $p_num;
            }
        }
        return $this->get_number();
    }
}

class Game {
    protected $number;
    protected $player;
    protected $guesses;

    public function __construct(Number $number, Player $player) {
        $this->number = $number;
        $this->player = $player;

        $this->start_game();
    }

    public function start_game() {
        $this->number->gen_number();
        $this->guesses = 0;

        $this->explain_rules();
        $this->game_loop();
    }

    protected function game_loop() {
        $this->guesses++;
        $p_num = $this->player->get_number();
        $compared_num = $this->number->compare_number($p_num);
        switch($compared_num) {
            case 1: 
                echo "\nMit $p_num hast du zu hoch geraten!\n\n";
                $this->game_loop();
                break;
            case 0:
                echo "\nDu hast gewonnen!\n";
                $this->afterword();
                break;
            case -1:
                echo "\nMit $p_num hast du zu tief geraten!\n\n";
                $this->game_loop();
                break;
        }
    }

    protected function explain_rules() {
        echo "Willkommen zum Zahlenrat-Spiel!\n";
        echo "\n";
        echo "Der Computer generiert eine Zahl zwischen 1 und 100.\n";
        echo "Du musst sie erraten!\n";
        echo "Nach jedem Versuch, sagt dir der Computer, ob du zu hoch oder zu tief geraten hast...\n";
        echo "Und jetzt: viel Erfolg!\n";
        echo "\n";
    }

    protected function afterword() {
        echo "UND: du hast $this->guesses mal für diesen Sieg geraten.\n\n";
        echo "Möchtest du noch einmal spielen? (yes/no)\n";
        $answer = readline();
        echo "\n";
        if($answer == "yes" || $answer == "y") {
            $this->start_game();
        } else {
            echo "See you soon!";
        }
    }
}

class Test extends Number {
    public function gen_number() {
        $this->number = 93;
    }
}

new Game(new Test(), new Player());
