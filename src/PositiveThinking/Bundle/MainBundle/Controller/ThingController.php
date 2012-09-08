<?php

namespace PositiveThinking\Bundle\MainBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use PositiveThinking\Bundle\MainBundle\Entity\Thing;
use PositiveThinking\Bundle\MainBundle\Form\ThingType;

/**
 * Thing controller.
 *
 * @Route("/thing")
 */
class ThingController extends Controller
{
    /**
     * Lists all Thing entities.
     *
     * @Route("/", name="thing")
     * @Template("PositiveThinkingMainBundle:Thing:range.html.twig")
     */
    public function indexAction()
    {
        $helper = $this->get('positivethinking.helper.thing');
        $things = $helper->getThings('week');

        return array('entities' => $things);
    }

    /**
     * Finds and displays a Thing entity.
     *
     * @Route("/{id}/show", name="thing_show")
     * @Template()
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PositiveThinkingMainBundle:Thing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thing entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),        );
    }

    /**
     * Displays a form to create a new Thing entity.
     *
     * @Route("/new", name="thing_new")
     * @Template()
     */
    public function newAction()
    {
        $entity = new Thing();
        $form   = $this->createForm(new ThingType(), $entity);

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Creates a new Thing entity.
     *
     * @Route("/create", name="thing_create")
     * @Method("post")
     * @Template("PositiveThinkingMainBundle:Thing:new.html.twig")
     */
    public function createAction()
    {
        $entity  = new Thing();
        $request = $this->getRequest();
        $form    = $this->createForm(new ThingType(), $entity);
        $form->bindRequest($request);

        if ($form->isValid()) 
        {
            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('thing'));
        }

        return array(
            'entity' => $entity,
            'form'   => $form->createView()
        );
    }

    /**
     * Displays a form to edit an existing Thing entity.
     *
     * @Route("/{id}/edit", name="thing_edit")
     * @Template()
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PositiveThinkingMainBundle:Thing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thing entity.');
        }

        $editForm = $this->createForm(new ThingType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Edits an existing Thing entity.
     *
     * @Route("/{id}/update", name="thing_update")
     * @Method("post")
     * @Template("PositiveThinkingMainBundle:Thing:edit.html.twig")
     */
    public function updateAction($id)
    {
        $em = $this->getDoctrine()->getEntityManager();

        $entity = $em->getRepository('PositiveThinkingMainBundle:Thing')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Thing entity.');
        }

        $editForm   = $this->createForm(new ThingType(), $entity);
        $deleteForm = $this->createDeleteForm($id);

        $request = $this->getRequest();

        $editForm->bindRequest($request);

        if ($editForm->isValid()) {
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('thing_edit', array('id' => $id)));
        }

        return array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        );
    }

    /**
     * Deletes a Thing entity.
     *
     * @Route("/{id}/delete", name="thing_delete")
     * @Method("post")
     */
    public function deleteAction($id)
    {
        $form = $this->createDeleteForm($id);
        $request = $this->getRequest();

        $form->bindRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getEntityManager();
            $entity = $em->getRepository('PositiveThinkingMainBundle:Thing')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Thing entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('thing'));
    }

    private function createDeleteForm($id)
    {
        return $this->createFormBuilder(array('id' => $id))
            ->add('id', 'hidden')
            ->getForm()
        ;
    }

    /**
     * Things of the day
     *
     * @Route("/day/{date}", name="thing_day", defaults={"date" = ""})
     * @Template("PositiveThinkingMainBundle:Thing:range.html.twig")
     */
    public function dayAction($date)
    {
        $helper = $this->get('positivethinking.helper.thing');
        $things = $helper->getThings('day', $date);

        return array('entities' => $things);
    }

    /**
     * Things of the week
     *
     * @Route("/week/{date}", name="thing_week", defaults={"date" = ""})
     * @Template("PositiveThinkingMainBundle:Thing:range.html.twig")
     */
    public function weekAction($date)
    {
        $helper = $this->get('positivethinking.helper.thing');
        $things = $helper->getThings('week', $date);

        return array('entities' => $things);
    }

    /**
     * Things of the month
     *
     * @Route("/month/{date}", name="thing_month", defaults={"date" = ""})
     * @Template("PositiveThinkingMainBundle:Thing:range.html.twig")
     */
    public function monthAction($date)
    {
        $helper = $this->get('positivethinking.helper.thing');
        $things = $helper->getThings('month', $date);

        return array('entities' => $things);
    }

    /**
     * Things of the year
     *
     * @Route("/year/{date}", name="thing_year", defaults={"date" = ""})
     * @Template("PositiveThinkingMainBundle:Thing:range.html.twig")
     */
    public function yearAction($date)
    {
        $helper = $this->get('positivethinking.helper.thing');
        $things = $helper->getThings('year', $date);

        return array('entities' => $things);
    }

    /**
     * Favorite/Unfavorite a thing
     *
     * @Route("/favorite/{id}/{type}", name="thing_favorite")
     */
    public function favoriteAction ($id, $type)
    {
        $em     = $this->getDoctrine()->getEntityManager();
        $entity = $em->getRepository('PositiveThinkingMainBundle:Thing')->find($id);

        if ($entity) 
        {
            $entity->setFavorite($type);
            $em->persist($entity);
            $em->flush();
        }

        return new Response();
    }

    /**
     * Favorites things of the week/month/year
     *
     * @Route("/favorites/{type}", name="thing_favorites")
     * @Template("PositiveThinkingMainBundle:Thing:range.html.twig")
     */
    public function favoritesAction ($type)
    {
        $helper = $this->get('positivethinking.helper.thing');
        $things = $helper->getFavoriteThings($type);

        return array('entities' => $things);
    }
}
