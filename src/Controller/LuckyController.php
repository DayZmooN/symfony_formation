<?php

namespace App\Controller;

use Psr\Log\LoggerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\DependencyInjection\Attribute\Autowire;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class LuckyController extends AbstractController
{
    #[Route('/lucky/{id}', name: 'app_lucky')]
    public function index(int $id): Response
    {
        $product = $id;
    if (!$product) {
        throw $this->createNotFoundException('The product does not exist hhh');
    }
        return $this->render('lucky/index.html.twig', [
            'number' => $id,
        ]);
    }

    #[Route('/lucky/number', name: 'app_lucky_lucky')]
    public function lucky(
        #[Autowire(service: 'monolog.logger.request')]
        LoggerInterface $logger
    ): Response
    {
        $number= random_int(0, 100);
        $logger->info('Lucky number: ' . $number);
        return $this->render('lucky/index.html.twig', [
            'number' => $number,
        ]);
    }




}
