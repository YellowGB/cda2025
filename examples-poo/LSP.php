<?php

interface WriterInterface
{
    /**
     * Must echo something
     */
    public function write(): void;
}

class Tagada implements WriterInterface
{
    public function write(): void
    {
        echo 'Tsoin Tsoin';
    }
}

class Togodo implements WriterInterface
{
    public function write(): void
    {
        echo 'tsoutsou';
    }
}

class Tougoudou
{
    public function serviceAmazing(WriterInterface $writer): void
    {
        $writer->write();
    }
}

class Tigidi
{
    public function wow(): string
    {
        return 'nothing';
    }
}

$tougoudou = new Tougoudou();
$tougoudou->serviceAmazing(new Tagada());
$tougoudou->serviceAmazing(new Togodo());
