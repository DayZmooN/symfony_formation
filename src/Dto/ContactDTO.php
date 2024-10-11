<?php

namespace App\Dto;

use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Validator\Constraints\Email;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\NotBlank;

class ContactDTO
{
    #[NotBlank]
    #[Length(min: 5)]
    private ?string $name;

    #[NotBlank]
    #[Length(min: 10)]
    #[Assert\Email()]
    private ?string  $email;

    #[NotBlank]
    #[Length(min: 5)]
    private ?string  $message;

    private string $service='';

    public function __construct(){
    }


    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): void
    {
        $this->email = $email;
    }

    public function getMessage(): string
    {
        return $this->message;
    }

    public function setMessage(string $message): void
    {
        $this->message = $message;
    }

    public function getService(): string
    {
        return $this->service;
    }

    public function setService(string $service): void
    {
        $this->service = $service;
    }
}