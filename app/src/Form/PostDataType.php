<?php

namespace App\Form;

use App\Entity\Post;
use App\Entity\PostData;
use App\Entity\SocialNetwork;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostDataType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('likes')
            ->add('engagement')
            ->add('cover')
            ->add('post', EntityType::class, [
                'class' => Post::class,
                'choice_label' => 'name'
            ])
            ->add('network', EntityType::class, [
                // looks for choices from this entity
                'class' => SocialNetwork::class,

                // uses the User.username property as the visible option string
                'choice_label' => 'name',

                // used to render a select box, check boxes or radios
                // 'multiple' => true,
                // 'expanded' => true,
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => PostData::class,
        ]);
    }
}
