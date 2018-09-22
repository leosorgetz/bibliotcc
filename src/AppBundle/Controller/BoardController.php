<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Board;
use AppBundle\Entity\Project;
use AppBundle\Entity\Semester;
use AppBundle\Entity\User;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Board controller.
 *
 * @Route("board")
 */
class BoardController extends Controller
{
    /**
     * @Route("/semester/{id}", name="board_by_semester", requirements={"id"="\d+"})
     * @Method("GET")
     */
    public function listBoardsBySemester(Semester $semester)
    {
        $em = $this->getDoctrine()->getManager();

        $boards = $em->getRepository('AppBundle:Board')->findBy([
            'semester' => $semester,
            'isCanceled' => false
        ]);

        return $this->render('board/board_by_semester.html.twig', array(
            'boards' => $boards,
            'semester' => $semester
        ));
    }

    /**
     * @Route("/canceled", name="boards_canceled")
     * @Method("GET")
     * @Security("has_role('ROLE_PROFESSOR')")
     */
    public function listBoardsCanceled()
    {
        $em = $this->getDoctrine()->getManager();

        $boards = $em->getRepository('AppBundle:Board')->findBy([
            'isCanceled' => true
        ]);

        return $this->render('board/boards_canceled.html.twig', array(
            'boards' => $boards,
        ));
    }

    /**
     * @Route("/new/{id}", name="board_new_by_semester", requirements={"id"="\d+"})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     *
     * @param Request $request
     * @param Semester $semester
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|\Symfony\Component\HttpFoundation\Response
     */
    public function newBySemester(Request $request, Semester $semester)
    {
        $board = new Board();
        $board->setSemester($semester);

        $form = $this->createForm('AppBundle\Form\BoardType', $board);
        $form->remove('advisorGrade');
        $form->remove('evaluatorOneGrade');
        $form->remove('evaluatorTwoGrade');
        $form->remove('advisorConsiderations');
        $form->remove('evaluatorOneConsiderations');
        $form->remove('evaluatorTwoConsiderations');
        $form->remove('finalGrade');
        $form->remove('semester');
        $form->remove('project');
        $form->remove('lastPostDate');
        $form->remove('observations');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $em = $this->getDoctrine()->getManager();

            //$project = $em->getRepository('AppBundle:Project')->findOneBy([
            //    'student' => $board->getStudent()
            //]);
            //var_dump(!$project);
            //die();

            $project = new Project();
            $project->setName('Projeto de ' . $board->getStudent());
            $project->setDescription('Insira uma descrição');
            $project->setStudent($board->getStudent());
            $project->setAdvisor($board->getAdvisor());
            $project->setFirstPostDate($board->getFirstPostDate());

            $lastDatePost = date_create($board->getScheduledTime()->format('Y-m-d H:i:s'));
            date_add($lastDatePost, date_interval_create_from_date_string('7 days'));

            $project->setLastPostDate($lastDatePost);

            $em->persist($project);
            $em->flush();

            $board->setProject($project);
            $em->persist($board);
            $em->flush();

            $project->setBoard($board);
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('board_by_semester', array('id' => $board->getSemester()->getId()));
        }

        return $this->render('board/new_by_semester.html.twig', array(
            'board' => $board,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a board entity.
     *
     * @Route("/{id}", name="board_show")
     * @Method("GET")
     */
    public function showAction(Board $board)
    {
        $cancelForm = $this->createCancelForm($board);
        $finalizeForm = $this->createFinalizeForm($board);
        $restForm = $this->createRestForm($board);

        return $this->render('board/show.html.twig', array(
            'board' => $board,
            'cancel_form' => $cancelForm->createView(),
            'finalize_form' => $finalizeForm->createView(),
            'rest_form' => $restForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing board entity.
     *
     * @Route("/{id}/edit", name="board_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Board $board)
    {
        /* Seta o campo auxiliar com as informações do objeto Projeto */
        $board->setAdvisor($board->getProject()->getAdvisor());
        $board->setStudent($board->getProject()->getStudent());

        if ($board->getIsCanceled()) {
            return $this->redirectToRoute('board_by_semester', [
                'id' => $board->getSemester()->getId()
            ]);
        }

        $editForm = $this->createForm('AppBundle\Form\BoardType', $board);

        $editForm->remove('lastPostDate');
        $editForm->remove('semester');

        if ($board->getisFinalized()) {
            $editForm->remove('firstPostDate');
        }

        if (!$board->getisFinalized()) {
            $editForm->remove('advisorGrade');
            $editForm->remove('evaluatorOneGrade');
            $editForm->remove('evaluatorTwoGrade');
            $editForm->remove('observations');
            $editForm->remove('finalGrade');
            $editForm->remove('project');
        }

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            /* Seta o corretamente o objeto Projeto com o campo auxiliar. */
            $board->getProject()->setAdvisor($board->getAdvisor());
            $board->getProject()->setFirstPostDate($board->getFirstPostDate());
            $board->getProject()->setStudent($board->getStudent());

            $average = ($board->getAdvisorGrade() + $board->getEvaluatorOneGrade() + $board->getEvaluatorTwoGrade()) / 3;
            $average = number_format($average, 2, '.', '');
            $board->setFinalGrade($average);

            $lastDatePost = date_create($board->getScheduledTime()->format('Y-m-d H:i:s'));
            date_add($lastDatePost, date_interval_create_from_date_string('7 days'));

            $board->getProject()->setLastPostDate($lastDatePost);

            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('board_show', array('id' => $board->getId()));
        }

        return $this->render('board/edit.html.twig', array(
            'board' => $board,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/init/{id}", name="board_init", requirements={"id"="\d+"})
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_PROFESSOR')")
     */
    public function initBoardAction(Request $request, Board $board)
    {
        if ($board->getisCanceled()) {
            return $this->redirectToRoute('board_by_semester', [
                'id' => $board->getSemester()->getId()
            ]);
        }

        if ($board->getisFinalized()) {
            return $this->redirectToRoute('board_by_semester', [
                'id' => $board->getSemester()->getId()
            ]);
        }

        $today = new \DateTime('now');

        /*
         * Se a data de hoje for menor que o dia da banca, veta.
         * */
        if (!
        (
            date_format($today, 'Y-m-d')
            <=
            date('Y-m-d', $board->getScheduledTime()->getTimestamp()))
        ) {
            throw $this->createAccessDeniedException('Não está entre as datas permitidas.');
        }

        // Caso não seja o professor orientador.
        if ($board->getProject()->getAdvisor()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException('Você não é o orientador deste projeto.');
        }

        $form = $this->createForm('AppBundle\Form\BoardType', $board);
        $form->remove('name');
        $form->remove('student');
        $form->remove('advisor');
        $form->remove('evaluatorOne');
        $form->remove('evaluatorTwo');
        $form->remove('finalGrade');
        $form->remove('semester');
        $form->remove('scheduledTime');
        $form->remove('firstPostDate');
        $form->remove('lastPostDate');
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $board->setIsPresented(true);
            $average = ($board->getAdvisorGrade() + $board->getEvaluatorOneGrade() + $board->getEvaluatorTwoGrade()) / 3;
            $average = number_format($average, 2, '.', '');
            $board->setFinalGrade($average);
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('board_show', array('id' => $board->getId()));
        }

        return $this->render('board/init.html.twig', array(
            'init_form' => $form->createView(),
            'board' => $board
        ));
    }

    /**
     * @Route("/report/{id}", name="board_report", requirements={"id"="\d+"})
     * @Method({"GET"})
     * @Security("has_role('ROLE_PROFESSOR')")
     */
    public function reportAction(Board $board)
    {
        // Caso não seja o professor orientador ou não seja ADMIN
        /*if ($board->getProject()->getAdvisor()->getId() != $this->getUser()->getId() or !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException('Você não é o orientador deste projeto.');
        }*/

        return $this->render('board/report.html.twig', array(
            'board' => $board
        ));
    }

    /**
     * Cancel a board entity.
     *
     * @Route("/{id}", name="board_cancel")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function cancelAction(Request $request, Board $board)
    {
        if ($board->getisFinalized()) {
            return $this->redirectToRoute('board_by_semester', [
                'id' => $board->getSemester()->getId()
            ]);
        }

        $form = $this->createCancelForm($board);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $board->setIsCanceled(true);
            $em->flush();
        }

        return $this->redirectToRoute('board_show', [
            'id' => $board->getId()
        ]);
    }

    /**
     * @Route("/rest/{id}", name="board_rest")
     * @Method("POST")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function restBoardAction(Request $request, Board $board)
    {
        if (!$board->getIsCanceled()) {
            return $this->redirectToRoute('board_by_semester', [
                'id' => $board->getSemester()->getId()
            ]);
        }

        $form = $this->createRestForm($board);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $board->setIsCanceled(false);
            $em->flush();
        }

        return $this->redirectToRoute('board_show', [
            'id' => $board->getId()
        ]);
    }

    /**
     * @Route("/finalize/{id}", name="board_finalize")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_PROFESSOR')")
     */
    public function finalizeAction(Request $request, Board $board)
    {
        // Caso não seja o professor orientador ou não seja ADMIN
        if ($board->getProject()->getAdvisor()->getId() != $this->getUser()->getId() or !$this->isGranted('ROLE_ADMIN')) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createFinalizeForm($board);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $em = $this->getDoctrine()->getManager();
            $board->setIsFinalized(true);
            $em->flush();

            return $this->redirectToRoute('board_show', [
                'id' => $board->getId()
            ]);
        }

        return $this->redirectToRoute('board_show', [
            'id' => $board->getId()
        ]);
    }

    private function createCancelForm(Board $board)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('board_cancel', array('id' => $board->getId())))
            ->setMethod('POST')
            ->getForm();
    }

    private function createFinalizeForm(Board $board)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('board_finalize', array('id' => $board->getId())))
            ->setMethod('POST')
            ->getForm();
    }

    private function createRestForm(Board $board)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('board_rest', array('id' => $board->getId())))
            ->setMethod('POST')
            ->getForm();
    }

}
