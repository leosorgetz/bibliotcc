<?php

namespace AppBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class SemesterType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $startDate = new \DateTime();
        $endDate = new \DateTime();

        if (date('m') > 6) {
            $startDate->setDate(date('Y'), 8, 1);
            $endDate->setDate(date('Y'), 12, 31);
        } else {
            $startDate->setDate(date('Y'), 1, 1);
            $endDate->setDate(date('Y'), 7, 31);
        }

        $builder->add('start', DateType::class, [
            'data' => $startDate,
        ])->add('end', DateType::class, [
            'data' => $endDate,
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Semester'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_semester';
    }


}
