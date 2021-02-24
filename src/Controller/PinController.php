<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pin', name: 'pin_', methods: ['GET'])]
class PinController extends AbstractController
{
    #[Route('/create', name: 'create', methods: ['GET', 'POST'])]
    public function create(EntityManagerInterface $entityManager, Request $request): Response
    {
        $pin = new Pin();

        $form = $this->createForm(PinType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($pin);
            $entityManager->flush();

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id<[\da-fA-F]{8}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{12}>}', name: 'show')]
    public function show(Pin $pin): Response
    {
        return $this->render('pin/show.html.twig', compact('pin'));
    }
}
