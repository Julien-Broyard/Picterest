<?php

namespace App\Controller;

use App\Repository\PinRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/', name: 'app_', methods: ['GET'])]
class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function home(PaginatorInterface $paginator, PinRepository $pinRepository, Request $request): Response
    {
        $pagination = $paginator->paginate(
            $pinRepository->getPaginatorQuery(),
            $request->query->getInt('page', 1),
            6,
        );

        return $this->render('home.html.twig', compact('pagination'));
    }
}
