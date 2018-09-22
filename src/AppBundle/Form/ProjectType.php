<?php

namespace AppBundle\Form;

use AppBundle\Entity\User;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProjectType extends AbstractType
{
    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder->add('name', null, [
            'label' => 'Nome'
        ])->add('description', null, [
            'label' => 'Descrição',
            'attr' => [
                'rows' => '10'
            ]
        ])->add('article', FileType::class, array(
            'data_class' => null,
            'label' => 'Artigo'
        ))->setRequired(false)
            ->add('code', FileType::class, array(
                'data_class' => null,
                'label' => 'Codigo Fonte'
            ))->setRequired(false)
            ->add('student', EntityType::class, array(
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :role')
                        ->setParameter('role', '%' . User::ROLE_STUDENT . '%');
                },
                'label' => 'Aluno'
            ))->add('advisor', EntityType::class, [
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :roleProfessor')
                        ->orWhere('u.roles LIKE :roleRoleAdmin')
                        ->setParameter('roleProfessor', '%' . User::ROLE_PROFESSOR . '%')
                        ->setParameter('roleRoleAdmin', '%' . User::ROLE_ADMIN . '%');
                },
                'label' => 'Orientador'
            ]);
    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Project'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_project';
    }


}
