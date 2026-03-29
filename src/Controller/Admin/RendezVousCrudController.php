<?php

namespace App\Controller\Admin;

use App\Entity\RendezVous;
use App\Form\RendezVousType;
use App\Repository\RendezVousRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/admin/rendezvous')]
class RendezVousCrudController extends AbstractController
{
    #[Route('/', name: 'admin_rendezvous_index', methods: ['GET'])]
    public function index(RendezVousRepository $rendezVousRepository): Response
    {
        return $this->render('admin/rendezvous/index.html.twig', [
            'rendez_vous' => $rendezVousRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'admin_rendezvous_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $rendezVous = new RendezVous();
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($rendezVous);
            $entityManager->flush();

            return $this->redirectToRoute('admin_rendezvous_index');
        }

        return $this->render('admin/rendezvous/new.html.twig', [
            'rendez_vou' => $rendezVous,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_rendezvous_show', methods: ['GET'])]
    public function show(RendezVous $rendezVous): Response
    {
        return $this->render('admin/rendezvous/show.html.twig', [
            'rendez_vou' => $rendezVous,
        ]);
    }

    #[Route('/{id}/edit', name: 'admin_rendezvous_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, RendezVous $rendezVous, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(RendezVousType::class, $rendezVous);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('admin_rendezvous_index');
        }

        return $this->render('admin/rendezvous/edit.html.twig', [
            'rendez_vou' => $rendezVous,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'admin_rendezvous_delete', methods: ['POST'])]
    public function delete(Request $request, RendezVous $rendezVous, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rendezVous->getId(), $request->request->get('_token'))) {
            $entityManager->remove($rendezVous);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_rendezvous_index');
    }
}
