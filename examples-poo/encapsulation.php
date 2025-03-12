<?php

class Oiseau
{
    private $nom;
    protected $age;

    private const bouh = "j'ai peur";

    public function __construct($nom, $age)
    {
        $this->nom = $nom;
        $this->age = $age;
    }

    public function getAge()
    {
        return $this->age;
    }

    public function setAge(int $age)
    {
        if ($age <= 0) {
            echo "Pas possible";
            return;
        }
        $this->age = $age;
    }
}

class Pigeon extends Oiseau
{
    public function voler()
    {
        echo "Je vole, alors que j'ai que " . $this->age . " ans";
    }
}

// $oiseau = new Oiseau('Pigeon', 2);
// echo $oiseau->nom . ' a ' . $oiseau->age . ' ans';

$pigeon = new Pigeon('Pigeon', 2);
$pigeon->setAge(-3);
$pigeon->voler();
