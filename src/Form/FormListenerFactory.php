<?php


namespace App\Form;

use App\Entity\Recipe;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PostSubmitEvent;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\String\Slugger\AsciiSlugger;


class FormListenerFactory
{
    public function autoSlug(string $field):callable
    {
        return function (FormEvent $event) use ($field) {
            $data = $event->getData();
            if (empty($data['slug']) && !empty($data[$field])) {
                $slugger = new AsciiSlugger();
                $data['slug'] = strtolower($slugger->slug($data[$field]));
                $event->setData($data);
            }
        };
    }

    public function timestamps():callable
    {
        return function (PostSubmitEvent $event) {
            $data=$event->getData();
            // si $data n'est pas une instance de recipe
//            if(!($data instanceof Recipe)){
//                return;
//            }
            // Vérifiez si l'objet a un ID
            if (!$data->getId()) {
                $data->setCreatedAt(new \DateTimeImmutable());
                $data->setUpdatedAt(new \DateTimeImmutable());
            }else{
                $data->setUpdatedAt(new \DateTimeImmutable());
            }
        };
    }
}
