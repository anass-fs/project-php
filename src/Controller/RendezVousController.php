<?php

namespace App\Controller;

use App\Entity\Patient; // Import Patient entity
use App\Entity\RendezVous;
use App\Form\PublicRendezVousType; // Use PublicRendezVousType
use App\Repository\PatientRepository; // Import PatientRepository
use App\Repository\RendezVousRepository; // Import RendezVousRepository
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class RendezVousController extends AbstractController
{
    #[Route('/rendez-vous', name: 'app_rendezvous_new')]
    public function new(
        Request $request,
        EntityManagerInterface $entityManager,
        PatientRepository $patientRepository, // Inject PatientRepository
        RendezVousRepository $rendezVousRepository
    ): Response {
        $rendezVous = new RendezVous();
        $form = $this->createForm(PublicRendezVousType::class, $rendezVous); // Use PublicRendezVousType
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // The form now gives us a Patient object directly.
            // We check if this patient already exists in the database.
            $patientDataFromForm = $rendezVous->getPatient();
            $patient = $patientRepository->findOneBy(['email' => $patientDataFromForm->getEmail()]);

            if ($patient) {
                // An existing patient was found. Update their info from the form.
                $patient->setNom($patientDataFromForm->getNom());
                $patient->setPrenom($patientDataFromForm->getPrenom());
                $patient->setTelephone($patientDataFromForm->getTelephone());
                $patient->setAdresse($patientDataFromForm->getAdresse());
                // Associate the rendez-vous with the EXISTING patient.
                $rendezVous->setPatient($patient);
            } else {
                // No patient found, so the one from the form is a new one.
                $patient = $patientDataFromForm;
            }

            // 5. Prevent duplicate bookings
            $existing = $rendezVousRepository->findOneBy([
                'medecin' => $rendezVous->getMedecin(),
                'date' => $rendezVous->getDate(),
                'heure' => $rendezVous->getHeure(),
            ]);

            if ($existing) {
                $this->addFlash('error', 'Ce créneau est déjà réservé. Veuillez choisir une autre date ou heure.');
                return $this->render('rendezvous/new.html.twig', [
                    'form' => $form,
                ]);
            }

            // 6. Persist and flush
            $entityManager->persist($patient); // Persist patient (new or updated)
            $entityManager->persist($rendezVous);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Merci ' . $patient->getNom() . ' ' . $patient->getPrenom() .
                ', votre rendez-vous avec Dr. ' . $rendezVous->getMedecin()->getNom() .
                ' le ' . $rendezVous->getDate()->format('d/m/Y') .
                ' à ' . $rendezVous->getHeure()->format('H:i') .
                ' a été enregistré.'
            );

            return $this->redirectToRoute('app_rendezvous_new');
        }

        return $this->render('rendezvous/new.html.twig', [
            'form' => $form,
        ]);
    }
}
