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
use Banko\Bundle\CompteBundle\Form\CompteType;

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
     * @Route("/create/{compte_id}", name="mouvement_create")
     * @Method("POST")
     * @Template("BankoCompteBundle:Mouvement:new.html.twig")
     */
    public function createAction(Request $request, $compte_id)
    {
        $entity  = new Mouvement();
        $form = $this->createForm(new MouvementType(), $entity);
        
        if ($request->isMethod('POST'))
        {
            $form->bind($request);

            if ($form->isValid()) {
                                var_dump('coucou');exit;
                $em = $this->getDoctrine()->getManager();
                $compte = $em->getRepository('BankoCompteBundle:Compte')->find($compte_id);
                $compte->getMouvements()->addMouvement($entity);
                //$this->get('MouvementService')->create($entity, $compte);

                $this->get('session')->getFlashBag()->add('success', 'La création a été effectuée avec succès');

                return $this->redirect($this->generateUrl('banko_voir', array('id' => $compte_id)));
            }
        }
        return array(
            'entity' => $entity,
            'compte_id'   => $compte_id,
            'form'   => $form->createView(),
        );
    }

    /**
     * Displays a form to create a new Mouvement entity.
     *
     * @Route("/new/{compte_id}", name="mouvement_new")
     * @Template()
     */
    public function newAction(Request $request, $compte_id)
    {
        $em = $this->getDoctrine()->getManager();
        $compte = $em->getRepository('BankoCompteBundle:Compte')->find($compte_id);
        
        $form = $this->createForm(new CompteType());

        // analyse le formulaire quand on reçoit une requête POST
        if ($request->isMethod('POST'))
        {
            $form->bind($request);
            if ($form->isValid()) {
                $data = $request->request->get($form->getName());
                $mouvements = $data['mouvements'];

                foreach($mouvements as $key => $mvt)
                {             
                    $mouvement = new Mouvement();

                    if (count($mouvements[$key]) < 5)
                        $mouvement->setTraite(0);
                    else
                        $mouvement->setTraite($mvt['traite']);
                    $mouvement->setLibelle($mvt['libelle']);
                    $mouvement->setDate($mvt['date']);
                    $mouvement->setCredit($mvt['credit']);
                    $mouvement->setDebit($mvt['debit']);
                    $mouvement->setCompte($compte);
                    $em->persist($mouvement);
                }
                $em->flush();

                return $this->redirect($this->generateUrl('banko_voir', array('id' => $compte_id)));
            }
            else
            {
                $this->get('session')->getFlashBag()->add('danger', 'La création a échoué');
            }
        }
        
        return array(
            'form' => $form->createView(),
            'compte_id'   => $compte_id,
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
            //'delete_form' => $deleteForm->createView(),
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
     * @Route("/delete/{id}", name="mouvement_delete")
     */
    public function deleteAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $entity = $em->getRepository('BankoCompteBundle:Mouvement')->find($id);
        $compte_id = $entity->getCompte()->getId();

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Mouvement entity.');
        }

        $em->remove($entity);
        $em->flush();

        return $this->redirect($this->generateUrl('banko_voir', array('id' => $compte_id)));
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
        /*return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;*/
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
        else if($request->get('traite') == '0')
            $entity->setTraite('0');

        if ($request->get('libelle') != null)
            $entity->setLibelle($request->get('libelle'));
        
        if ($request->get('date') != null)
            $entity->setDate($request->get('date'));

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
