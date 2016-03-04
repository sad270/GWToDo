<?php

namespace GW\ToDoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GW\ToDoBundle\Entity\Project;
use GW\ToDoBundle\Form\ProjectType;

class ProjectController extends Controller
{
    public function indexAction($page)
    {
        $results = false;
        $resultPerPage = 20;
        $nbPages = 0;
        if ($page == "" or $page == null) {
          $page = 1;
        }
        if ($page < 1) {
          throw new NotFoundHttpException('Page N°'.$page.' inexistante. Le numéro de page ne peux pas être inferieur à 1'); //TODO personaliser la page d'erreur
        }
          $results = $this->getDoctrine()->getRepository('GWToDoBundle:Project')
          ->viewAll($page, $resultPerPage);

          // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
          $nbPages = ceil(count($results)/$resultPerPage);
            // Si la page n'existe pas, on retourne une 404
            if($page > $nbPages && $nbPages != 0) {
              throw new NotFoundHttpException('Page N°'.$page.' inexistante.'); //TODO personaliser la page d'erreur
            }

        return $this->render('GWToDoBundle:Project:index.html.twig', array(
          'results' => $results,
          'nbResults' => count($results),
          'nbPages' => $nbPages,
          'page'    => $page,
          'tab' => 'project',
        ));
    }

    public function addAction(Request $request)
    {

      $project = new Project;
      $form = $this->createForm(ProjectType::class, $project);

      if ($form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        $this->addFlash('success', 'Projet ajouté avec succés :)');

        return $this->redirect($this->generateUrl('gw_to_do_project_view', array(
          'id' => $project->getId(),
        )));
      }

      return $this->render('GWToDoBundle:Project:add.html.twig', array(
        'form' => $form->createView(),
        'tab' => 'project',
      ));
    }

    public function editAction(Request $request, $id = null)
    {
      $project = $this->getDoctrine()->getRepository('GWToDoBundle:Project')->find($id);

      if ($project === null) {
        throw new NotFoundHttpException('Projet N°'.$id.' inexistante.'); //TODO personaliser la page d'erreur
      }

      $form = $this->createForm(ProjectType::class, $project);

      if ($form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($project);
        $em->flush();

        $this->addFlash('success', 'Projet modifié avec succés :)');

        return $this->redirect($this->generateUrl('gw_to_do_project_homepa', array(
          'id' => $project->getId()
          )));
      }

      // À ce stade, le formulaire n'est pas valide car :
      // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
      // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

      return $this->render('GWToDoBundle:Project:edit.html.twig', array(
        'form' => $form->createView(),
        'tab' => 'project',
      ));
    }


    public function viewAction($id)
    {
      $project = $this->getDoctrine()->getRepository('GWToDoBundle:Project')->find($id);

      if ($project === null) {
        throw new NotFoundHttpException('Projet N°'.$id.' inexistante.'); //TODO personaliser la page d'erreur
      }

      return $this->render('GWToDoBundle:Project:view.html.twig', array(
        'project' => $project,
        'tab' => 'project',
      ));
    }

    public function deleteAction($id)
    {
      $project = $this->getDoctrine()->getRepository('GWToDoBundle:Project')->find($id);

      if ($project === null) {
        throw new NotFoundHttpException('Projet N°'.$id.' inexistante.'); //TODO personaliser la page d'erreur
      }
      $em = $this->getDoctrine()->getManager();
      $em->remove($project);
      $em->flush();
      $this->addFlash('info', 'Projet supprimé');
      return $this->render('GWToDoBundle:Project:delete.html.twig', array(
        'id' => $id,
        'tab' => 'project',
      ));
    }
}
