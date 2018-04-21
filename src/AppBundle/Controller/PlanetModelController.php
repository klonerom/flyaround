<?php

namespace AppBundle\Controller;

use AppBundle\Entity\PlanetModel;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;use Symfony\Component\HttpFoundation\Request;

/**
 * Planetmodel controller.
 *
 * @Route("planetmodel")
 */
class PlanetModelController extends Controller
{
    /**
     * Lists all planetModel entities.
     *
     * @Route("/", name="planetmodel_index")
     * @Method("GET")
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $planetModels = $em->getRepository('AppBundle:PlanetModel')->findAll();

        return $this->render('planetmodel/index.html.twig', array(
            'planetModels' => $planetModels,
        ));
    }

    /**
     * Creates a new planetModel entity.
     *
     * @Route("/new", name="planetmodel_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $planetModel = new Planetmodel();
        $form = $this->createForm('AppBundle\Form\PlanetModelType', $planetModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($planetModel);
            $em->flush();

            return $this->redirectToRoute('planetmodel_show', array('id' => $planetModel->getId()));
        }

        return $this->render('planetmodel/new.html.twig', array(
            'planetModel' => $planetModel,
            'form' => $form->createView(),
        ));
    }

    /**
     * Finds and displays a planetModel entity.
     *
     * @Route("/{id}", name="planetmodel_show")
     * @Method("GET")
     */
    public function showAction(PlanetModel $planetModel)
    {
        $deleteForm = $this->createDeleteForm($planetModel);

        return $this->render('planetmodel/show.html.twig', array(
            'planetModel' => $planetModel,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing planetModel entity.
     *
     * @Route("/{id}/edit", name="planetmodel_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, PlanetModel $planetModel)
    {
        $deleteForm = $this->createDeleteForm($planetModel);
        $editForm = $this->createForm('AppBundle\Form\PlanetModelType', $planetModel);
        $editForm->handleRequest($request);

        if ($editForm->isSubmitted() && $editForm->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('planetmodel_edit', array('id' => $planetModel->getId()));
        }

        return $this->render('planetmodel/edit.html.twig', array(
            'planetModel' => $planetModel,
            'edit_form' => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Deletes a planetModel entity.
     *
     * @Route("/{id}", name="planetmodel_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, PlanetModel $planetModel)
    {
        $form = $this->createDeleteForm($planetModel);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->remove($planetModel);
            $em->flush();
        }

        return $this->redirectToRoute('planetmodel_index');
    }

    /**
     * Creates a form to delete a planetModel entity.
     *
     * @param PlanetModel $planetModel The planetModel entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm(PlanetModel $planetModel)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('planetmodel_delete', array('id' => $planetModel->getId())))
            ->setMethod('DELETE')
            ->getForm()
        ;
    }
}
