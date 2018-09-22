<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Semester;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * Semester controller.
 *
 * @Route("semester")
 */
class SemesterController extends Controller
{
    /**
     * Lists all semester entities.
     *
     * @Route("/", name="semester_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $semesters = $em->getRepository('AppBundle:Semester')->findAll();

        return $this->render('semester/index.html.twig', array(
            'semesters' => $semesters,
        ));
    }

    /**
     * Creates a new semester entity.
     *
     * @Route("/new", name="semester_new")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function newAction(Request $request)
    {
        $semester = new Semester();
        $form = $this->createForm('AppBundle\Form\SemesterType', $semester);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($semester);
            $em->flush();

            return $this->redirectToRoute('semester_show', array('id' => $semester->getId()));
        }

        return $this->render('semester/new.html.twig', array(
            'semester' => $semester,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a semester entity.
     *
     * @Route("/{id}", name="semester_show")
     * @Method("GET")
     */
    public function showAction(Semester $semester)
    {
        $deleteForm = $this->createDeleteForm($semester);
        $em = $this->getDoctrine()->getManager();
        $boards = $em->getRepository('AppBundle:Board')
            ->findBy([
                'semester' => $semester->getId()
            ]);

        return $this->render('semester/show.html.twig', array(
            'semester' => $semester,
            'delete_form' => $deleteForm->createView(),
            'boards' => $boards
        ));
    }

    /**
     * Displays a form to edit an existing semester entity.
     *
     * @Route("/{id}/edit", name="semester_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function editAction(Request $request, Semester $semester)
    {
        $deleteForm = $this->createDeleteForm($semester);
        $editForm = $this->createForm('AppBundle\Form\SemesterType', $semester);
        $editForm->handleRequest($request);


        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('semester_edit', array('id' => $semester->getId()));
        }

        return $this->render('semester/edit.html.twig', array(
            'semester' => $semester,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView()
        ));
    }

    /**
     * Deletes a semester entity.
     *
     * @Route("/{id}", name="semester_delete")
     * @Method("DELETE")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function deleteAction(Request $request, Semester $semester)
    {
        $form = $this->createDeleteForm($semester);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($semester);
            $em->flush();
        }

        return $this->redirectToRoute('semester_index');
    }

    /**
     * @Route("/{id}/calendar", name="calendar_boards_of_semester", requirements={"id"="\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function calendarSemesterBoardsAction(Semester $semester)
    {
        $em = $this->getDoctrine()->getManager();

        $boards = $em->getRepository('AppBundle:Board')->findBy([
            'semester' => $semester
        ], [
            'scheduledTime' => 'ASC'
        ]);

        return $this->render('semester/calendar_boards_of_semesters.html.twig', [
            'boards' => $boards,
            'semester' => $semester
        ]);
    }

    /**
     * @Route("/{id}/report", name="report_boards_of_semester", requirements={"id"="\d+"})
     * @Method("GET")
     * @Security("has_role('ROLE_ADMIN')")
     */
    public function reportSemesterBoardsAction(Semester $semester)
    {
        $em = $this->getDoctrine()->getManager();

        $boards = $em->getRepository('AppBundle:Board')->findBy([
            'semester' => $semester
        ]);

        return $this->render('semester/report_boards_of_semesters.html.twig', [
            'boards' => $boards,
            'semester' => $semester
        ]);
    }

    /**
     * Creates a form to delete a semester entity.
     *
     * @param Semester $semester The semester entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(Semester $semester)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('semester_delete', array('id' => $semester->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

}
