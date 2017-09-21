<?php

/*namespace Biblioteca\Filmes;*/

use Phalcon\Mvc\Model;
use Phalcon\Mvc\Model\Message;
use Phalcon\Mvc\Model\Validator\PresenceOf;
use Phalcon\Mvc\Model\Validator\Uniqueness;
use Phalcon\Mvc\Model\Validator\Regex;
use Phalcon\Mvc\Collection;

class Filmes extends Collection {
    /*public $titulo;
    public $dta_estreia;
    public $diretor;
    public $genero;
    public $clas_indic;*/

    public function initialize()
    {
        $this->setConnectionService('mongo');
    }

    public function getSource()
    {
        return "filmes";
    }

    public function validation(){
        $this->validate(
            new PresenceOf(
                array(
                    "field"     =>  "titulo",
                    "message"   =>  "O titulo do filmes é necessario."
                )
            )
        );

        $this->validate(
            new PresenceOf(
                array(
                    "field"     =>  "dta_estreia",
                    "message"   =>  "A data de estreia é necessaria."
                )
            )
        );

        $this->validate(
            new PresenceOf(
                array(
                    "field"     =>  "diretor",
                    "message"   =>  "O diretor é necessario."
                )
            )
        );

        $this->validate(
            new PresenceOf(
                array(
                    "field"     =>  "genero",
                    "message"   =>  "O genero é necessario."
                )
            )
        );

        // Validação da dta_estreia
        
        /*if($this->car_model_year < 0){
            $this->appendMessage(new Message("Car's model year can not be zero."));
        }
        if ($this->validationHasFailed() == true) {
            return false;
        }*/
    }

}