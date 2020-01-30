<?php

namespace App\Form;

use App\Entity\Comment;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CommentType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('comment')
            //->add('created_at') // ->add('created_at') - supprimer car on a configurer de prendre en compte la date du jour. voir CommentController, ligne 37
            //->add('user') // ->add('user') - supprimer car on a lié l'utilisateur avec le commentaire. voir CommentController, ligne 48
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Comment::class,
        ]);
    }
}


           