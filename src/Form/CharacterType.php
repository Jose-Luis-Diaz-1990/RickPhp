<?php

namespace App\Form;

use App\Entity\Character;
use App\Entity\Location;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;


class CharacterType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('nombre', TextType::class, [
                'label'=> 'Nombre del personaje',
                'attr'=> ['placeholder' => 'Ej: Rick el auténtico']
            ])
            ->add('estado')
            ->add('imagenCharacter', FileType::class, [ 'mapped'=> false ])
            ->add('codigo')
            ->add('localizaciones', EntityType::class, [
                'class' => Location::class,
                'choice_label' => 'localizacion',
                'multiple' => true,
                'expanded' => true,])
            ->add('Enviar', SubmitType::class)
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Character::class,
        ]);
    }
}
