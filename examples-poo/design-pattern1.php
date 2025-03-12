<?php

class ConnexionDB
{
    private static ?self $instance;

    private function __construct(private string $dbName) {}

    public static function getInstance(string $dbName): self
    {
        if (self::$instance === null) {
            self::$instance = new self($dbName);
        }

        return self::$instance;
    }

    public function connect(): void
    {
        echo "Connected!";
    }
}

$co1 = ConnexionDB::getInstance('db1');
