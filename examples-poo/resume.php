<?php

class Person
{
    protected string $lastName;
    protected string $firstName;
    protected int $age;

    public function __construct(string $lastName, string $firstName, int $age)
    {
        $this->lastName = $lastName;
        $this->firstName = $firstName;
        $this->age = $age;
    }

    public function getLastName(): string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): void
    {
        $this->lastName = $lastName;
    }

    public function getFirstName(): string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function getAge(): int
    {
        return $this->age;
    }

    public function setAge(int $age): void
    {
        $this->age = $age;
    }
}

final class Student extends Person implements LogsIntoStudyNetwork
{
    private string $degree;

    public function __construct(string $lastName, string $firstName, int $age, string $degree)
    {
        parent::__construct($lastName, $firstName, $age);
        $this->degree = $degree;
    }

    public function getDegree(): string
    {
        return $this->degree;
    }

    public function setDegree(string $degree): void
    {
        $this->degree = $degree;
    }

    public function logIn(): void
    {
        echo 'Logging into Student Network, displaying classes and grades.';
    }
}

final class Teacher extends Person implements LogsIntoStudyNetwork
{
    private string $subject;

    public function __construct(string $lastName, string $firstName, int $age, string $subject)
    {
        parent::__construct($lastName, $firstName, $age);
        $this->subject = $subject;
    }

    public function getSubject(): string
    {
        return $this->subject;
    }

    public function setSubject(string $subject): void
    {
        $this->subject = $subject;
    }

    public function logIn(): void
    {
        echo 'Logs into Study Network, displaying classes and payrolls.';
    }
}

final class Janitor extends Person {}

interface LogsIntoStudyNetwork
{
    public function logIn(): void;
}
