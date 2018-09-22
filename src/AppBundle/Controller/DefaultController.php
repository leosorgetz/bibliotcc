<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Board;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request, \Swift_Mailer $mailer)
    {
        /*$message = (new \Swift_Message('Hello Email'))
            ->setFrom(array('bibliotecadetcc@gmail.com' => 'BiblioTCC'))
            ->setTo('leosorgetz123@gmail.com')
            ->setBody('Teste Default');
        $mailer->send($message);*/

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', [
            'base_dir' => realpath($this->getParameter('kernel.project_dir')) . DIRECTORY_SEPARATOR,
        ]);
    }

    /**
     * @Route("/dashboard", name="dashboard")
     */
    public function dashboardAction()
    {
        if ($this->isGranted('ROLE_PROFESSOR')) {
            $boards = $this->getDoctrine()
                ->getRepository(Board::class)
                ->getProfessorBoards($this->getUser()->getId());
        } else {
            $boards = $this->getDoctrine()
                ->getRepository(Board::class)
                ->getStudentBoards($this->getUser()->getId());
        }

        return $this->render('default/dashboard.html.twig', array(
            'boards' => $boards,
        ));
    }

}
