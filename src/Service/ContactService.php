<?php

namespace App\Service;

use App\Dto\ContactDTO;

class ContactService
{
public function createContact(ContactDTO $contactDTO)
{
    $contactDTO->setName($contactDTO->getName());
    $contactDTO->setEmail($contactDTO->getEmail());
    $contactDTO->setMessage($contactDTO->getMessage());

    return $contactDTO;
}
}