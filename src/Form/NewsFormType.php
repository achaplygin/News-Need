<?php

namespace App\Form;

use App\Service\YandexNewsService;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class NewsFormType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $newsService = new YandexNewsService('', '');

        $builder
            ->add('source', ChoiceType::class,
                [
                    'choices' => $newsService->getLinks(),
                    'placeholder' => 'Select news source'
                ]
            )
            ->add('submit', SubmitType::class);
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => NewsForm::class,
        ]);
    }
}
