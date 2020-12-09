<?php

namespace App\Form;

use App\Entity\Category;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CategoryType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $submitLabel = $builder->getOption('on_update') ? 'Editer' : 'Ajouter';
        //$onEdit = $builder->getData()->getId() !== null;

        $builder
            ->add('wording', TextType::class, [
                'label' => 'Nom de la catégorie'
            ])
            ->add('submit', SubmitType::class, [
                'label' => $submitLabel
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Category::class,
            'on_update' => false,
        ]);
    }
}
