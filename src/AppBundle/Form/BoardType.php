<?php

namespace AppBundle\Form;

use AppBundle\Entity\Board;
use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use Doctrine\DBAL\Types\FloatType;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\DateType;
use Symfony\Component\Form\Extension\Core\Type\NumberType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class BoardType extends AbstractType
{
    public $semester;

    /**
     * {@inheritdoc}
     */
    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $this->board = $builder->getData();

        $builder->add('scheduledTime', DateTimeType::Class, array(

            'data' => is_null($builder->getData()->getScheduledTime()) ? new \DateTime('now') : $builder->getData()->getScheduledTime(),
            'years' => range(
                $this->board->getSemester()->getStart()->format('Y'),
                $this->board->getSemester()->getEnd()->format('Y')
            ),
            'months' => range(
                $this->board->getSemester()->getStart()->format('m'),
                $this->board->getSemester()->getEnd()->format('m')
            ),
            'days' => range(
                $this->board->getSemester()->getStart()->format('d'),
                $this->board->getSemester()->getEnd()->format('d')
            ),
            'hours' => range(
                8,
                22
            ),
            'label' => 'Data da Banca'
        ));
        $builder->add('firstPostDate', DateType::class, [
            'data' => is_null($builder->getData()->getProject())
                ? new \DateTime('now')
                : $builder->getData()->getProject()->getFirstPostDate(),
            'years' => range(
                $this->board->getSemester()->getStart()->format('Y'),
                $this->board->getSemester()->getEnd()->format('Y')
            ),
            'months' => range(
                $this->board->getSemester()->getStart()->format('m'),
                $this->board->getSemester()->getEnd()->format('m')
            ),
            'days' => range(
                $this->board->getSemester()->getStart()->format('d'),
                $this->board->getSemester()->getEnd()->format('d')
            ),
            'label' => 'Data da Primeira Postagem do Projeto'
        ])->setRequired(true);
        /*var_dump($this->board->getSemester());
        die();*/
        if (is_null($builder->getData()->getProject())) {
            $builder->add('student', EntityType::class, array(
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->leftJoin('AppBundle:Project', 'p', 'WITH', 'u.id = p.student')
                        ->leftJoin('AppBundle:Board', 'b', 'WITH', 'p.id = b.project')
                        ->where('u.roles LIKE :role')
                        ->andWhere('b.semester <> :semester or b.semester is null')
                        ->orderBy('u.name', 'ASC')
                        ->setParameter('role', '%' . User::ROLE_STUDENT . '%')
                        ->setParameter('semester', $this->board->getSemester());
                },
                'label' => 'Aluno'
            ))->setRequired(true);
        } else {
            $builder->add('student', EntityType::class, array(
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->leftJoin('AppBundle:Project', 'p', 'WITH', 'u.id = p.student')
                        ->leftJoin('AppBundle:Board', 'b', 'WITH', 'p.id = b.project')
                        ->where('u.roles LIKE :role')
                        ->andWhere('b.semester <> :semester or b.semester is null or p.student = :student')
//                        ->andWhere('')
                        ->setParameter('role', '%' . User::ROLE_STUDENT . '%')
                        ->setParameter('semester', $this->board->getSemester())
                        ->setParameter('student', $this->board->getProject()->getStudent());
                },
                'label' => 'Aluno'
            ))->setRequired(true);
        }


        $builder->add('advisor', EntityType::class, [
            'class' => 'AppBundle:User',
            'query_builder' => function (EntityRepository $er) {
                return $er->createQueryBuilder('u')
                    ->where('u.roles LIKE :roleProfessor')
                    ->orWhere('u.roles LIKE :roleRoleAdmin')
                    ->setParameter('roleProfessor', '%' . User::ROLE_PROFESSOR . '%')
                    ->setParameter('roleRoleAdmin', '%' . User::ROLE_ADMIN . '%');
            },
            'label' => 'Orientador'
        ])->setRequired(true)
            ->add('evaluatorOne', EntityType::class, [
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :roleProfessor')
                        ->orWhere('u.roles LIKE :roleRoleAdmin')
                        ->setParameter('roleProfessor', '%' . User::ROLE_PROFESSOR . '%')
                        ->setParameter('roleRoleAdmin', '%' . User::ROLE_ADMIN . '%');
                },
                'label' => 'Avaliador 1'
            ])->setRequired(true)
            ->add('evaluatorTwo', EntityType::class, [
                'class' => 'AppBundle:User',
                'query_builder' => function (EntityRepository $er) {
                    return $er->createQueryBuilder('u')
                        ->where('u.roles LIKE :roleProfessor')
                        ->orWhere('u.roles LIKE :roleRoleAdmin')
                        ->setParameter('roleProfessor', '%' . User::ROLE_PROFESSOR . '%')
                        ->setParameter('roleRoleAdmin', '%' . User::ROLE_ADMIN . '%');
                },
                'label' => 'Avaliador 2'
            ])->setRequired(true)
            ->add('observations', null, [
                'label' => 'Considerações dos Avaliadores',
                'attr' => [
                    'rows' => '10'
                ]
            ])->setRequired(true)
            ->add('advisorGrade', NumberType::class, [
                'label' => 'Nota do Orientador'
            ])->setRequired(true)
            ->add('evaluatorOneGrade', NumberType::class, [
                'label' => 'Nota do Avaliador 1'
            ])->setRequired(true)
            ->add('evaluatorTwoGrade', NumberType::class, [
                'label' => 'Nota do Avaliador 2'
            ])->setRequired(true)
            ->add('semester', null, [
                'label' => 'Semestre'
            ])->setRequired(true)
            ->add('lastPostDate', DateType::class, [
                'data' => is_null($builder->getData()->getLastPostDate()) ? new \DateTime('now') : $builder->getData()->getLastPostDate(),
//                'data' => new \DateTime('now'),
                'label' => 'Data da Postagem Final do Projeto'
            ])->setRequired(true);


    }

    /**
     * {@inheritdoc}
     */
    public function configureOptions(OptionsResolver $resolver)
    {
        $resolver->setDefaults(array(
            'data_class' => 'AppBundle\Entity\Board'
        ));
    }

    /**
     * {@inheritdoc}
     */
    public function getBlockPrefix()
    {
        return 'appbundle_board';
    }


}
