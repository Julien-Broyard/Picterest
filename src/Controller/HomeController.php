<?php

namespace App\Controller;

use App\Repository\PinRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_', methods: ['GET'])]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(PinRepository $pinRepository): Response
    {
        $pins = $pinRepository->findBy([], ['createdAt' => 'DESC']);

        return $this->render('home.html.twig', compact('pins'));
    }
}
