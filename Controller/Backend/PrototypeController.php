<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AssortmentBundle\Controller\Backend;

use Sylius\Bundle\AssortmentBundle\EventDispatcher\Event\FilterPrototypeEvent;
use Sylius\Bundle\AssortmentBundle\EventDispatcher\SyliusAssortmentEvents;
use Symfony\Component\DependencyInjection\ContainerAware;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Product prototype backend controller.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class PrototypeController extends ContainerAware
{
    /**
     * Lists all properties.
     *
     * @return Reponse
     */
    public function listAction(Request $request)
    {
        $properties = $this->container->get('sylius_assortment.manager.prototype')->findProperties();

        return $this->container->get('templating')->renderResponse('SyliusAssortmentBundle:Backend/Prototype:list.html.'.$this->getEngine(), array(
            'properties'  => $properties
        ));
    }

    /**
     * Creates a new prototype.
     *
     * @param Request $request
     *
     * @return Reponse
     */
    public function createAction(Request $request)
    {
        $prototype = $this->container->get('sylius_assortment.manager.prototype')->createPrototype();

        $form = $this->container->get('form.factory')->create('sylius_assortment_prototype');
        $form->setData($prototype);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusAssortmentEvents::PROTOTYPE_CREATE, new FilterPrototypeEvent($prototype));
                $this->container->get('sylius_assortment.manipulator.prototype')->create($prototype);

                return new RedirectResponse($this->container->get('router')->generate('sylius_assortment_backend_prototype_show', array(
                    'id' => $prototype->getId()
                )));
            }
        }

        return $this->container->get('templating')->renderResponse('SyliusAssortmentBundle:Backend/Prototype:create.html.'.$this->getEngine(), array(
            'form' => $form->createView()
        ));
    }

    /**
     * Updates a prototype.
     *
     * @param Request $request
     * @param integer $id      The prototype id
     *
     * @return Response
     */
    public function updateAction(Request $request, $id)
    {
        $prototype = $this->findPrototypeOr404($id);

        $form = $this->container->get('form.factory')->create('sylius_assortment_prototype');
        $form->setData($prototype);

        if ('POST' === $request->getMethod()) {
            $form->bindRequest($request);

            if ($form->isValid()) {
                $this->container->get('event_dispatcher')->dispatch(SyliusAssortmentEvents::PROTOTYPE_UPDATE, new FilterPrototypeEvent($prototype));
                $this->container->get('sylius_assortment.manipulator.prototype')->update($prototype);

                return new RedirectResponse($this->container->get('router')->generate('sylius_assortment_backend_prototype_show', array(
                    'id' => $prototype->getId()
                )));
            }
        }

        return $this->container->get('templating')->renderResponse('SyliusAssortmentBundle:Backend/Prototype:update.html.'.$this->getEngine(), array(
            'form'     => $form->createView(),
            'prototype' => $prototype
        ));
    }

    /**
     * Deletes prototype.
     *
     * @param integer $id The prototype id
     *
     * @return Response
     */
    public function deleteAction($id)
    {
        $prototype = $this->findPrototypeOr404($id);

        $this->container->get('event_dispatcher')->dispatch(SyliusAssortmentEvents::PROTOTYPE_DELETE, new FilterPrototypeEvent($prototype));
        $this->container->get('sylius_assortment.manipulator.prototype')->delete($prototype);

        return new RedirectResponse($this->container->get('request')->headers->get('referer'));
    }

    /**
     * Tries to find prototype with given id.
     * Throws a special http exception with code 404 if unsuccessful.
     *
     * @param integer $id The prototype id
     *
     * @return PrototypeInterface
     *
     * @throws NotFoundHttpException
     */
    protected function findPrototypeOr404($id)
    {
        if (!$prototype = $this->container->get('sylius_assortment.manager.prototype')->findPrototype($id)) {
            throw new NotFoundHttpException('Requested prototype does not exist');
        }

        return $prototype;
    }

    /**
     * Returns templating engine name.
     *
     * @return string
     */
    protected function getEngine()
    {
        return $this->container->getParameter('sylius_assortment.engine');
    }
}