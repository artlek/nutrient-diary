<?php

namespace App\Form;

use App\Entity\Target;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;

class EditNutrientTargetFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('value', NumberType::class, [
                'label' => 'Target (g)',
                'scale' => 2,
                'html5' => true,
                'constraints' => [
                    new Range(
                        min: 0,
                        max: 10000,
                        notInRangeMessage: 'Only numbers in range {{ min }} to {{ max }}',
                    ),
                    new NotNull(),
                    new NotBlank(),
                ]
            ])
            ->add('edit', SubmitType::class, ['attr' => ['class' => 'btn btn-success mt-3 mb-3 d-grid gap-2 col-12 mx-auto']])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => Target::class,
        ]);
    }
}
