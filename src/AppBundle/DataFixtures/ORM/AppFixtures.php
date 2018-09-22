<?php

namespace AppBundle\DataFixtures\ORM;

use AppBundle\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

//use Doctrine\Common\DataFixtures\FixtureInterface;
//use Doctrine\Common\Persistence\ObjectManager;

class AppFixtures extends Fixture
//class AppFixture implements FixtureInterface
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $superAdmin = new User();
        $superAdmin->setName('Leonardo Sorgetz');
        $superAdmin->setUsername('superadmin');
        $superAdmin->setEmail('leosorgetz123@gmail.com');
        $plainPassword = 'superadmin';
        $password = $this->encoder->encodePassword($superAdmin, $plainPassword);
        $superAdmin->setPassword($password);
        $superAdmin->addRole(User::ROLE_SUPER_ADMIN);
        $superAdmin->setEnabled(true);

        $admin = new User();
        $admin->setName('Admin');
        $admin->setUsername('admin');
        $admin->setEmail('admin@gmail.com');
        $plainPassword = 'admin';
        $password = $this->encoder->encodePassword($admin, $plainPassword);
        $admin->setPassword($password);
        $admin->addRole(User::ROLE_ADMIN);
        $admin->setEnabled(true);

        $professor = new User();
        $professor->setName('Avaliador 1');
        $professor->setUsername('advisor1');
        $professor->setEmail('advisor1@gmail.com');
        $plainPassword = 'advisor1';
        $password = $this->encoder->encodePassword($professor, $plainPassword);
        $professor->setPassword($password);
        $professor->addRole(User::ROLE_PROFESSOR);
        $professor->setEnabled(true);

        $professor2 = new User();
        $professor2->setName('Avaliador 2');
        $professor2->setUsername('advisor2');
        $professor2->setEmail('advisor2@gmail.com');
        $plainPassword = 'advisor2';
        $password = $this->encoder->encodePassword($professor2, $plainPassword);
        $professor2->setPassword($password);
        $professor2->addRole(User::ROLE_PROFESSOR);
        $professor2->setEnabled(true);

        $student = new User();
        $student->setName('Estudante 1');
        $student->setUsername('student');
        $student->setEmail('student@gmail.com');
        $plainPassword = 'student';
        $password = $this->encoder->encodePassword($student, $plainPassword);
        $student->setPassword($password);
        $student->addRole(User::ROLE_STUDENT);
        $student->setEnabled(true);

        $student2 = new User();
        $student2->setName('Estudante 2');
        $student2->setUsername('student2');
        $student2->setEmail('student2@gmail.com');
        $plainPassword = 'student2';
        $password = $this->encoder->encodePassword($student2, $plainPassword);
        $student2->setPassword($password);
        $student2->addRole(User::ROLE_STUDENT);
        $student2->setEnabled(true);


        $manager->persist($superAdmin);
        $manager->persist($admin);
        $manager->persist($professor);
        $manager->persist($professor2);
        $manager->persist($student);
        $manager->persist($student2);
        $manager->flush();
    }
}
