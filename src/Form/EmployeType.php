<?php

namespace App\Form;

use App\Entity\Employe;
use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EmployeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nom', TextType::class, [
                    'attr' => ['class' => 'input inputNom'] // créer une class css pour changer le design
                ])
            ->add('prenom', TextType::class, [
                    'attr' => ['class' => 'input inputPrenom'] // créer une class css pour changer le design
                ])
            ->add('dateNaissance', DateType::class,[
                    'widget' => "single_text",// option format de date dans formulaire affiché(calandrier)
                    'attr' => ['class' => 'input inputDate']
                ])
            ->add('dateEmbauche', DateType::class,[
                    'widget' => "single_text", // option format de date dans formulaire affiché(calandrier)
                    'attr' => ['class' => 'input inputDate']
                ])
            ->add('ville', TextType::class, [
                    'attr' => ['class' => 'input inputVille'] // créer une class css pour changer le design
                ])
            ->add('entreprise', EntityType::class, [
                    'class' => Entreprise::class,
                    'choice_label' => 'raisonSociale',
                    'attr' => ['class' => 'input inputSelect']
                ])
            ->add('submit', SubmitType::class, [
                'attr' => ['class' => 'btn btn_submit'] // créer une class css pour changer le design
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Employe::class,
        ]);
    }
}
