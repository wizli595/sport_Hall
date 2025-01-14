<?php

namespace App\Controller;

use App\Entity\Creneau;
use App\Form\CreneauType;
use App\Repository\CreneauRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Exception\AccessDeniedException;
use App\Entity\User;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/creneau')]
final class CreneauController extends AbstractController
{
    #[Route(name: 'app_creneau_index', methods: ['GET'])]
    public function index(CreneauRepository $creneauRepository): Response
    {
        $creaneux = $creneauRepository->findAll();

        // If the user is not an admin, show only their reservations
        $authUser = $this->getUser();
        if ($authUser instanceof User && !in_array('ROLE_ADMIN', $authUser->getRoles())) {
            $creaneux = $creneauRepository->findByUser($authUser);
        }

        return $this->render('creneau/index.html.twig', [
            'creneaus' => $creaneux,
        ]);
    }

    #[Route('/new', name: 'app_creneau_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $creneau = new Creneau();
        $form = $this->createForm(CreneauType::class, $creneau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($creneau);
            $entityManager->flush();

            return $this->redirectToRoute('app_creneau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('creneau/new.html.twig', [
            'creneau' => $creneau,
            'form' => $form,
        ]);
    }
    #[Route('/{id}', name: 'app_creneau_show', methods: ['GET'])]
    public function show(Creneau $creneau): Response
    {
        return $this->render('creneau/show.html.twig', [
            'creneau' => $creneau,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_creneau_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Creneau $creneau, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CreneauType::class, $creneau);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_creneau_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('creneau/edit.html.twig', [
            'creneau' => $creneau,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_creneau_delete', methods: ['POST'])]
    public function delete(Request $request, Creneau $creneau, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$creneau->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($creneau);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_creneau_index', [], Response::HTTP_SEE_OTHER);
    }
    #[Route('/{id}/reserve', name: 'creneau_reserve', methods: ['POST'])]
    public function reserve(Creneau $creneau, EntityManagerInterface $entityManager): Response
    {
        $user = $this->getUser();
        if (!$user instanceof User) {
            throw new AccessDeniedException('Vous devez être connecté pour réserver un créneau');
        }

        // Add the user to the time slot
        $creneau->addUser($user);
        $entityManager->flush();

        return $this->redirectToRoute('app_creneau_index', [], Response::HTTP_SEE_OTHER);
    }

    #[Route('/{id}/assign-user', name: 'creneau_assign_user', methods: ['GET', 'POST'])]
public function assignUser(Request $request, Creneau $creneau, EntityManagerInterface $entityManager): Response
{
    $users = $entityManager->getRepository(User::class)->findAll();

    if ($request->isMethod('POST')) {
        $userId = $request->request->get('user_id');
        $user = $entityManager->getRepository(User::class)->find($userId);

        if ($user instanceof User) {
            $creneau->addUser($user);
            $entityManager->flush();

            $this->addFlash('success', 'User assigned successfully.');
        } else {
            $this->addFlash('error', 'Invalid user selected.');
        }

        return $this->redirectToRoute('app_creneau_index', [], Response::HTTP_SEE_OTHER);
    }

    return $this->render('creneau/assign_user.html.twig', [
        'creneau' => $creneau,
        'users' => $users,
    ]);


   

}

    

}