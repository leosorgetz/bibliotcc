<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Project;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;

/**
 * Project controller.
 *
 * @Route("project")
 */
class ProjectController extends Controller
{
    /**
     * Lists all project entities.
     *
     * @Route("/", name="project_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $boards = $em->getRepository('AppBundle:Project')->findByBoardFinalizedAndGrade();

        return $this->render('project/index.html.twig', array(
            'boards' => $boards,
        ));
    }

    /**
     * Finds and displays a project entity.
     *
     * @Route("/{id}", name="project_show")
     * @Method("GET")
     */
//    public function showAction(Project $project)
//    {
//        return $this->render('project/show.html.twig', array(
//            'project' => $project,
//        ));
//    }

    /**
     * Displays a form to edit an existing project entity.
     *
     * @Route("/{id}/edit", name="project_edit")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_PROFESSOR')")
     */
    public function editAction(Request $request, Project $project)
    {
        if (!$this->isGranted('ROLE_ADMIN')) {
            if ($project->getAdvisor()->getId() != $this->getUser()->getId()) {
                throw $this->createAccessDeniedException('Você não é o orientador deste projeto.');
            }
        }

        $editForm = $this->createForm('AppBundle\Form\ProjectType', $project);
        $editForm->remove('advisor');
        $editForm->remove('student');

        $article = null;
        if ($project->getArticle()) {
            $article = $project->getArticle();
        }

        $code = null;
        if ($project->getCode()) {
            $code = $project->getCode();
        }

        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {

            if (!is_null($project->getArticle())) {
                $project->setArticle($this->saveArticle($project));
            } else {
                $project->setArticle($article);
            }

            if (!is_null($project->getCode())) {
                $project->setCode($this->saveCode($project));
            } else {
                $project->setCode($code);
            }

            $this->getDoctrine()->getManager()->flush();

            // Usado sem ajax.
            // return $this->redirectToRoute('project_edit', array('id' => $project->getId()));

            return new JsonResponse(
                $this->generateUrl('board_show', [
                    'id' => $project->getBoard()->getId()
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            );
        }

        return $this->render('project/edit.html.twig', array(
            'project' => $project,
            'edit_form' => $editForm->createView(),
        ));
    }

    /**
     * @Route("/first-post/{id}", name="project_first_post")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_STUDENT')")
     */
    public function firstPostAction(Request $request, Project $project)
    {
        // Caso não seja o usuario responsavel pelo projeto.
        if ($project->getStudent()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException();
        }

        // Caso tenha passado da data inicial.
        if (date('Y-m-d', strtotime('now')) > date('Y-m-d', $project->getFirstPostDate()->getTimestamp())) {
            throw $this->createAccessDeniedException();
        }

        $form = $this->createForm('AppBundle\Form\ProjectType', $project);
        $form->remove('student');
        $form->remove('advisor');

        $article = null;
        if ($project->getArticle()) {
            $article = $project->getArticle();
        }

        $code = null;
        if ($project->getCode()) {
            $code = $project->getCode();
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!is_null($project->getArticle())) {
                $project->setArticle($this->saveArticle($project));
            } else {
                $project->setArticle($article);
            }

            if (!is_null($project->getCode())) {
                $project->setCode($this->saveCode($project));
            } else {
                $project->setCode($code);
            }

            $project->setFirstPost(true);
            $this->getDoctrine()->getManager()->flush();

            // Usado sem ajax.
            // return $this->redirectToRoute('board_show', array('id' => $project->getBoard()->getId()));

            return new JsonResponse(
                $this->generateUrl('board_show', [
                    'id' => $project->getBoard()->getId()
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            );
        }

        return $this->render('project/first-post.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * @Route("/last-post/{id}", name="project_last_post")
     * @Method({"GET", "POST"})
     * @Security("has_role('ROLE_STUDENT')")
     */
    public function secondPostAction(Request $request, Project $project)
    {

        // Caso não seja o usuario responsavel pelo projeto.
        if ($project->getStudent()->getId() != $this->getUser()->getId()) {
            throw $this->createAccessDeniedException('Você não é responsavel por este projeto.');
        }

        // Caso não tenha feito a primeira postagem.
        if (!$project->getFirstPost()) {
            throw $this->createAccessDeniedException('Não foi realizado uma primeira postagem.');
        }

        // Caso não tenha sido apresentada.
        if (!$project->getBoard()->getIsPresented()) {
            throw $this->createAccessDeniedException('A banca ainda não foi apresentada.');
        }

        // Caso tenha passado a data final de entrega.
        if (date('Y-m-d', strtotime('now')) > date('Y-m-d', $project->getLastPostDate()->getTimestamp())) {
            throw $this->createAccessDeniedException('A data final de entrega já passou.');
        }

        if ($project->getBoard()->getIsFinalized()) {
            throw $this->createAccessDeniedException('A banca ja foi finalizada.');
        }

        $form = $this->createForm('AppBundle\Form\ProjectType', $project);
        $form->remove('student');
        $form->remove('advisor');

        $article = null;
        if ($project->getArticle()) {
            $article = $project->getArticle();
        }

        $code = null;
        if ($project->getCode()) {
            $code = $project->getCode();
        }

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            if (!is_null($project->getArticle())) {
                $project->setArticle($this->saveArticle($project));
            } else {
                $project->setArticle($article);
            }

            if (!is_null($project->getCode())) {
                $project->setCode($this->saveCode($project));
            } else {
                $project->setCode($code);
            }

            $project->setLastPost(true);
            $this->getDoctrine()->getManager()->flush();

            // Usado sem Ajax
            //return $this->redirectToRoute('board_show', array('id' => $project->getBoard()->getId()));

            return new JsonResponse(
                $this->generateUrl('board_show', [
                    'id' => $project->getBoard()->getId()
                ], UrlGeneratorInterface::ABSOLUTE_URL)
            );
        }

        return $this->render('project/last-post.html.twig', array(
            'project' => $project,
            'form' => $form->createView(),
        ));
    }

    /**
     * Download Article by POST.
     * @Route("/download-article/{id}", name="article_download")
     * @Method({"POST"})
     * @param Project $project
     */
    public function downloadArticleAction(Project $project)
    {
        $path = $this->getParameter('articles_directory') . '/' . $project->getArticle();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        flush();
        readfile($path);
    }

    /**
     * Download Code by POST.
     * @Route("/download-code/{id}", name="code_download")
     * @Method({"POST"})
     * @param Project $project
     */
    public function downloadCodeAction(Project $project)
    {
        $path = $this->getParameter('codes_directory') . '/' . $project->getCode();
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="' . basename($path) . '"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        flush();
        readfile($path);
    }

    /**
     * Creates a form to delete a project entity.
     *
     * @param Project $project The project entity
     *
     * @return \Symfony\Component\Form\FormInterface
     */
    private function createDeleteForm(Project $project)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('project_delete', array('id' => $project->getId())))
            ->setMethod('DELETE')
            ->getForm();
    }

    /**
     * @return string
     */
    private function generateUniqueFileName()
    {
        return md5(uniqid());
    }

    private function saveArticle(Project $project)
    {
        $file = $project->getArticle();

        $fileName = 'Artigo' . $project->getStudent()->getId() . '.' . $file->guessExtension();

        $file->move(
            $this->getParameter('articles_directory'),
            $fileName
        );

        return $fileName;
    }

    private function saveCode(Project $project)
    {
        $file = $project->getCode();

        $fileName = 'CodigoFonte' . $project->getStudent()->getId() . '.' . $file->guessExtension();

        $file->move(
            $this->getParameter('codes_directory'),
            $fileName
        );

        return $fileName;
    }

}
