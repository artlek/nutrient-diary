<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use App\Service\Nutrient\GetUserNutrients;

class AddProductFormType extends AbstractType
{
    private $nutrients;

    public function __construct(GetUserNutrients $getUserNutrients)
    {
        $this->nutrients = $getUserNutrients->get();
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {

        $builder
            ->add('name', TextType::class, [
                'attr' => [
                    'minlength' => 2,
                    'maxlength' => 30,
                ],
                'constraints' => [
                    new NotNull(),
                    new NotBlank(),
                    new Regex('/^[\p{L}0-9\.)(,\s-]{2,30}$/u', message: 'Invalid data. Only digits, letters and dot, bracket, comma and dash mark allowed. Min. 2 and max. 30 characters.')]],
                )
            ;
        foreach($this->nutrients as $nutrient)
        {
            $builder
                ->add($nutrient->getName(), NumberType::class, [
                    'label' => $nutrient->getName() . ' content (in 100g)',
                    'scale' => 2,
                    'html5' => true,
                    'attr' => [
                        'minlength' => 2,
                        'maxlength' => 30,
                    ],
                    'constraints' => [
                        new Range(
                            min: 0,
                            max: 1000,
                            notInRangeMessage: 'Only numbers in range {{ min }} to {{ max }}',
                        ),
                        new NotNull(),
                        new NotBlank(),
                    ]
                ])
            ;
        }
        $builder
            ->add('add', SubmitType::class, [
                'label' => 'Add product',
                'attr' => [
                    'class' => 'btn btn-success mt-3 mb-3 d-grid gap-2 col-12 mx-auto',
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([]);
    }
}
