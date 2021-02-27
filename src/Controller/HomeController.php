<?php

declare(strict_types=1);

/*
 * This file is part of the Picterest source code.
 *
 * (c) Julien Broyard <broyard.dev@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

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
