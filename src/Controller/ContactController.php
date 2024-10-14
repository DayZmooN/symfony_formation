<?php

namespace App\Controller;

use App\Dto\ContactDTO;
use App\Form\ContactType;
use App\Service\ContactService;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Mime\Email;
use Symfony\Component\Routing\Attribute\Route;

class ContactController extends AbstractController
{

    #[Route('/contact', name: 'contact.index')]
    public function index(Request $request,ContactService $contactService,MailerInterface $mailer ): Response
    {
        $form = $this->createForm(ContactType::class);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            try {
            //je récuperer le donné dans le formulare en object
            $formData = $form->getData();

            //je rajoute c'est donné dans $contactDTO
            $contactDTO = $contactService->createContact($formData);
            $email = (new TemplatedEmail())
                ->to(new Address($contactDTO->getService()))
                ->from($contactDTO->getEmail())
                ->subject($contactDTO->getMessage())
                ->htmlTemplate('emails/contact.html.twig')
                ->context([
                    'contact' => $contactDTO,
                ]);


                $mailer->send($email);
                $this->addFlash('success','email envoyer avec succes');
                return $this->redirectToRoute('app_contact');
            }catch (\Exception $e){
                $this->addFlash('danger', "Impossible d'envoyer votre email");
            }
        }

        return $this->render('contact/index.html.twig', [
            'form' => $form,

        ]);
    }
}
