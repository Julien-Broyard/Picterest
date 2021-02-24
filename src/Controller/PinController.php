<?php

namespace App\Controller;

use App\Entity\Pin;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pin', name: 'pin_')]
class PinController extends AbstractController
{
    #[Route('/{id<[\da-fA-F]{8}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{12}>}', name: 'show')]
    public function show(Pin $pin): Response
    {
        return $this->render('pin/show.html.twig', compact('pin'));
    }
}
