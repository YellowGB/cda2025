<?php

abstract class Forme
{
    public function __construct(protected string $couleur) {}

    abstract public function surface(): int;

    public function afficher()
    {
        echo "Je suis une forme " . $this->couleur;
    }
}

class Carre extends Forme implements HasPerimeter
{
    public function __construct(
        protected string $couleur,
        private int $cote
    ) {}

    public function surface(): int
    {
        return $this->cote * $this->cote;
    }

    public function getPerimeter(): int
    {
        return $this->cote * 4;
    }
}

interface HasPerimeter
{
    public function getPerimeter(): int;
}

$carre = new Carre('rouge', 2);
$carre->afficher();
echo $carre->surface();
echo $carre->getPerimeter();
