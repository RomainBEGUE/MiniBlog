<?php

namespace App\Form;

use App\Entity\Message;
use App\Entity\Topic;
use phpDocumentor\Reflection\Types\Boolean;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;
use function Sodium\add;

class TopicType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('isPrivate', ChoiceType::class,[
                'label' => 'Topic privé',
                'choices' => array(
                    'Vrai' => 1,
                    'Faux' => 0
                ),
                'multiple'=> false,
            ])
            ->add(
                $builder->create('messages', FormType::class, ['by_reference' => false, 'label' => 'Sujet du topic'])
                    ->add('content', TextType::class, [
                        'required' => true,
                        'label' => 'Sujet',
                    ])

            )
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => Topic::class,
        ]);
    }
}
