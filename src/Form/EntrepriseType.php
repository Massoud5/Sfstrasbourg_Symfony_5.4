<?php

namespace App\Form;

use App\Entity\Entreprise;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;

class EntrepriseType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('raisonSociale', TextType::class, [
                    'attr' => ['class' => 'input inputRaisonSociale'] // créer une class css pour changer le design
                ])
            ->add('dateCreation', DateType::class,[
                    'widget' => "single_text", // option format de date dans formulaire affiché(calandrier)
                    'attr' => ['class' => 'input inputDate']
                ])
            ->add('addresse', TextType::class, [
                    'attr' => ['class' => 'input inputAdresse'] // créer une class css pour changer le design
                ])
            ->add('cp', TextType::class, [
                    'attr' => ['class' => 'input inputcp'] // créer une class css pour changer le design
                ])
            ->add('ville', TextType::class, [
                    'attr' => ['class' => 'input inputville'] // créer une class css pour changer le design
                ])
            ->add('siret', TextType::class, [
                    'attr' => ['class' => 'input inputSiret'] // créer une class css pour changer le design
                ])
            ->add('submit', SubmitType::class, [
                    'attr' => ['class' => 'btn btn_submit'] // créer une class css pour changer le design
                ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Entreprise::class,
        ]);
    }
}
