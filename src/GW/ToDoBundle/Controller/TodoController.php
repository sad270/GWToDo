<?php

namespace GW\ToDoBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use GW\ToDoBundle\Entity\ToDo;
use GW\ToDoBundle\Form\ToDoType;

class TodoController extends Controller
{
    public function indexAction($page)
    {
        $results = false;
        $resultPerPage = 5;
        $nbPages = 0;
        if ($page == "" or $page == null) {
          $page = 1;
        }
        if ($page < 1) {
          throw new NotFoundHttpException('Page N°'.$page.' inexistante. Le numéro de page ne peux pas être inferieur à 1'); //TODO personaliser la page d'erreur
        }
          $results = $this->getDoctrine()->getRepository('GWToDoBundle:ToDo')
          ->viewAll($page, $resultPerPage);

          // On calcule le nombre total de pages grâce au count($listAdverts) qui retourne le nombre total d'annonces
          $nbPages = ceil(count($results)/$resultPerPage);
            // Si la page n'existe pas, on retourne une 404
            if($page > $nbPages && $nbPages != 0) {
              throw new NotFoundHttpException('Page N°'.$page.' inexistante.'); //TODO personaliser la page d'erreur
            }

        return $this->render('GWToDoBundle:Todo:index.html.twig', array(
          'results' => $results,
          'nbResults' => count($results),
          'nbPages' => $nbPages,
          'page'    => $page,
          'tab' => 'todo',
        ));
    }

    public function addAction(Request $request, $project = null)
    {
      if($project){
        $defaultProject = $this->getDoctrine()->getRepository('GWToDoBundle:Project')->find($project);
        if ($defaultProject === null) {
          throw new NotFoundHttpException('Projet N°'.$project.' inexistante.'); //TODO personaliser la page d'erreur
        }
        $todo = new ToDo;
        $todo->setProject($defaultProject);
      }
      else {
        $todo = new ToDo;
      }
      $form = $this->createForm(ToDoType::class, $todo);

      if ($form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($todo);
        $em->flush();

        $this->addFlash('success', 'ToDo ajouté avec succés :)');

        return $this->redirect($this->generateUrl('gw_to_do_view', array(
          'id' => $todo->getId(),
        )));
      }

      return $this->render('GWToDoBundle:Todo:add.html.twig', array(
        'form' => $form->createView(),
        'tab' => 'todo',
      ));
    }

    public function editAction(Request $request, $id = null)
    {
      $todo = $this->getDoctrine()->getRepository('GWToDoBundle:ToDo')->find($id);

      if ($todo === null) {
        throw new NotFoundHttpException('ToDo N°'.$id.' inexistante.'); //TODO personaliser la page d'erreur
      }

      $form = $this->createForm(ToDoType::class, $todo);

      if ($form->handleRequest($request)->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $em->persist($todo);
        $em->flush();

        $this->addFlash('success', 'ToDo modifié avec succés :)');

        return $this->redirect($this->generateUrl('gw_to_do_view', array(
          'id' => $todo->getId()
          )));
      }

      // À ce stade, le formulaire n'est pas valide car :
      // - Soit la requête est de type GET, donc le visiteur vient d'arriver sur la page et veut voir le formulaire
      // - Soit la requête est de type POST, mais le formulaire contient des valeurs invalides, donc on l'affiche de nouveau

      return $this->render('GWToDoBundle:Todo:edit.html.twig', array(
        'form' => $form->createView(),
        'tab' => 'todo',
      ));
    }

    public function viewAction($id)
    {
      $todo = $this->getDoctrine()->getRepository('GWToDoBundle:ToDo')->find($id);

      if ($todo === null) {
        throw new NotFoundHttpException('ToDo N°'.$id.' inexistante.'); //TODO personaliser la page d'erreur
      }

      return $this->render('GWToDoBundle:Todo:view.html.twig', array(
        'todo' => $todo,
        'tab' => 'todo',
      ));
    }

    public function deleteAction($id)
    {
      $todo = $this->getDoctrine()->getRepository('GWToDoBundle:ToDo')->find($id);

      if ($todo === null) {
        throw new NotFoundHttpException('ToDo N°'.$id.' inexistante.'); //TODO personaliser la page d'erreur
      }
      $em = $this->getDoctrine()->getManager();
      $em->remove($todo);
      $em->flush();
      $this->addFlash('info', 'ToDo supprimé');
      return $this->render('GWToDoBundle:Todo:delete.html.twig', array(
        'id' => $id,
        'tab' => 'todo',
      ));
    }
}
