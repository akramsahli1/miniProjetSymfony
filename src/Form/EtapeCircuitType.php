<?php

namespace App\Form;

use App\Entity\Circuit;
use App\Entity\EtapeCircuit;
use App\Entity\Ville;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class EtapeCircuitType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('duree_etape')
            ->add('ordre_etape')
            ->add('code_ville_etape',EntityType::class,[
                'class'=>Ville::class,
                'choice_label'=>'des_ville',
                'label'=>'Ville'
            ])
            ->add('code_circuit_etape',EntityType::class,[
                'class'=>Circuit::class,
                'choice_label'=>'des_circuit',
                'label'=>'Circuit'
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults([
            'data_class' => EtapeCircuit::class,
        ]);
    }
}
