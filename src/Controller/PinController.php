<?php

namespace App\Controller;

use App\Entity\Pin;
use App\Form\PinFormType;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/pin', name: 'pin_', methods: ['GET'])]
class PinController extends AbstractController
{
    private EntityManagerInterface $entityManager;

    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/create', name: 'create', methods: ['POST'])]
    public function create(Request $request, string $imageDir): Response
    {
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');

        $pin = new Pin();

        $form = $this->createForm(PinFormType::class, $pin);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $imageName = \bin2hex(\random_bytes(6)).'.'.$image->guessExtension();

                try {
                    $image->move($imageDir, $imageName);
                } catch (FileException) {}

                $pin->setImageName($imageName);
            }

            $pin->setAuthor($this->getUser());

            $this->entityManager->persist($pin);
            $this->entityManager->flush();

            $this->addFlash('success', 'Pin successfully created.');

            return $this->redirectToRoute('app_home');
        }

        return $this->render('pin/create.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/delete/{id<[\da-fA-F]{8}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{12}>}', name: 'delete', methods: ['DELETE'])]
    public function delete(Pin $pin, Request $request): RedirectResponse
    {
        if ($this->getUser() !== $pin->getAuthor()) {
            $this->addFlash('danger', 'You can\'t delete this pin.');

            $this->redirectToRoute('pin_show', ['id' => $pin->getId()]);
        }

        if ($this->isCsrfTokenValid("pin_delete_".$pin->getId(), $request->request->get('_crsf_token'))) {
            $this->entityManager->remove($pin);
            $this->entityManager->flush();

            $this->addFlash('info', 'Pin successfully deleted.');
        }

        $this->addFlash('danger', 'Invalid CRSF Token.');

        return $this->redirectToRoute('app_home');

    }

    #[Route('/edit/{id<[\da-fA-F]{8}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{12}>}', name: 'edit', methods: ['PUT'])]
    public function edit(Pin $pin, Request $request, string $imageDir): Response
    {
        if ($this->getUser() !== $pin->getAuthor()) {
            $this->addFlash('danger', 'You can\'t edit this pin.');

            return $this->redirectToRoute('pin_show', ['id' => $pin->getId()]);
        }

        $form = $this->createForm(PinFormType::class, $pin, ['method' => 'PUT']);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            if ($image = $form['image']->getData()) {
                $imageName = \bin2hex(\random_bytes(6)).'.'.$image->guessExtension();

                try {
                    $image->move($imageDir, $imageName);
                } catch (FileException) {}

                $pin->setImageName($imageName);
            }

            $this->entityManager->persist($pin);
            $this->entityManager->flush();

            $this->addFlash('success', 'Pin successfully edited.');

            return $this->redirectToRoute('pin_show', ['id' => $pin->getId()]);
        }
        return $this->render('pin/edit.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    #[Route('/{id<[\da-fA-F]{8}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{4}\-[\da-fA-F]{12}>}', name: 'show')]
    public function show(Pin $pin): Response
    {
        return $this->render('pin/show.html.twig', compact('pin'));
    }
}
