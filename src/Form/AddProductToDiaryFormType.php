<?php

namespace App\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use App\Service\Product\GetProductChoices;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Range;
use Symfony\Component\Validator\Constraints\Positive;

class AddProductToDiaryFormType extends AbstractType
{
    public function __construct(private GetProductChoices $getProductChoices)
    {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('productId', ChoiceType::class, [
                'choices'  => $this->getProductChoices->get(),
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    ]
                ]
            )
            ->add('quantity', NumberType::class, [
                'scale' => 2,
                'constraints' => [
                    new NotBlank(),
                    new NotNull(),
                    new Positive(),
                    new Range(max: 1000),
                    ]
                ]
            )
            ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            // Configure your form options here
        ]);
    }
}
