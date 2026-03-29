<?php

namespace App\Form;

use App\Entity\Medecin;
use App\Entity\Patient;
use App\Entity\RendezVous;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TimeType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class RendezVousType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('date', DateType::class, [
                'label' => 'Date du Rendez-vous',
                'widget' => 'single_text',
            ])
            ->add('heure', TimeType::class, [
                'label' => 'Heure du Rendez-vous',
                'widget' => 'single_text',
            ])
            ->add('medecin', EntityType::class, [
                'class' => Medecin::class,
                'choice_label' => function (Medecin $medecin) {
                    return $medecin->getNom() . ' (' . $medecin->getSpecialite() . ')';
                },
                'label' => 'Médecin',
            ])
            ->add('patient', EntityType::class, [
                'class' => Patient::class,
                'choice_label' => function (Patient $patient) {
                    return $patient->getNom() . ' ' . $patient->getPrenom() . ' (' . $patient->getEmail() . ')';
                },
                'label' => 'Patient',
            ]);
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => RendezVous::class,
        ]);
    }
}
