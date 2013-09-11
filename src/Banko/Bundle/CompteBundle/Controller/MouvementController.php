<?php

namespace Banko\Bundle\CompteBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Response; // ICI
use Banko\Bundle\CompteBundle\Entity\Mouvement;
use Banko\Bundle\CompteBundle\Form\MouvementType;

/**
 * Mouvement controller.
 *
 * @Route("/mouvement")
 */
class MouvementController extends Controller
{

    /**
     * Lists all Mouvement entities.
     *
     * @Route("/", name="mouvement")
     * @Method("GET")
     * @Template()
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('BankoCompteBundle:Mouvement')->findAll();

        return array(
            'entities' => $entities,
        );
    }
    /**
     * Creates a new Mouvement entity.
     *
     * @Route("/", name="mouvement_create")
     * @Method("POST")
     * @Template("BankoCompteBundle:Mouvement:new.html.twig")
     */
    public function createAction(Request $request)
    {
        $entity  = new Mouvement();
        $form = $this->createForm(new MouvementType(), $entity);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mouvement_show', array('id' => $entity->getId())));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Mouvement entity.
     *
     * @Route("/new", name="mouvement_new")
     * @Method("GET")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Mouvement();
        $form   = $this->createForm(new MouvementType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView(),
        );
    }

    /**
     * Finds and displays a Mouvement entity.
     *
     * @Route("/{id}", name="mouvement_show")
     * @Method("GET")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BankoCompteBundle:Mouvement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mouvement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Displays a form to edit an existing Mouvement entity.
     *
     * @Route("/{id}/edit", name="mouvement_edit")
     * @Method("GET")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('BankoCompteBundle:Mouvement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mouvement entity.');
        }

        $editForm = $this->createForm(new MouvementType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Mouvement entity.
     *
     * @Route("/{id}", name="mouvement_update")
     * @Method("PUT")
     * @Template("BankoCompteBundle:Mouvement:edit.html.twig")
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BankoCompteBundle:Mouvement')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mouvement entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createForm(new MouvementType(), $entity);
        $editForm->bind($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('mouvement_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }
    /**
     * Deletes a Mouvement entity.
     *
     * @Route("/{id}", name="mouvement_delete")
     * @Method("DELETE")
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->bind($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('BankoCompteBundle:Mouvement')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Mouvement entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('mouvement'));
    }

    /**
     * Creates a form to delete a Mouvement entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }
    
        
    /**
     * Edits an existing Mouvement entity.
     *
     * @Route("/{id}", name="mouvement_update2")
     * @Template()
     */
    public function update2Action(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BankoCompteBundle:Mouvement')->find($id);

        if (!$entity)
            throw $this->createNotFoundException('Unable to find Mouvement entity.');
        
        if ($request->get('traite') == '1')
            $entity->setTraite('1');
        else
            $entity->setTraite('0');

        if ($request->get('libelle') != null)
            $entity->setLibelle($request->get('libelle'));
        
        if ($request->get('date') != null)
            $entity->setDate(new \DateTime($request->get('date')));
        
        if ($request->get('credit') != null)
            $entity->setCredit($request->get('credit'));
        
        if ($request->get('debit') != null)
            $entity->setDebit($request->get('debit'));

        $em->persist($entity);
        $em->flush();

        $reponse = array('code' => 200, 'message' => 'OK !');
        return new Response(json_encode($reponse), 200, array('Content-Type', 'text/json'));
    }
}