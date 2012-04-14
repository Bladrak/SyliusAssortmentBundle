<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AssortmentBundle\Form\EventListener;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\Form\Event\DataEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Form\FormFactoryInterface;

/**
 * Form event listener that builds variant form dynamically based on
 * product data.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class BuildVariantSubscriber implements EventSubscriberInterface
{
    /**
     * Form factory.
     *
     * @var FormFactoryInterface
     */
    private $factory;

    /**
     * Constructor.
     *
     * @param FormFactoryInterface $factory
     */
    public function __construct(FormFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return array(FormEvens::PRE_SET_DATA => 'preSetData');
    }

    /**
     * Builds proper variant form after setting the product.
     *
     * @param DataEvent $event
     */
    public function preSetData(DataEvent $event)
    {
        $variant = $event->getData();
        $form = $event->getForm();

        if (null === $variant) {
            throw new \RuntimeException('You can not use VariantType form without setting the proper variant model with related product set');
        }

        // Get related product.
        $product = $variant->getProduct();

        // Add value choice field for each configured option.
        foreach ($product->getOptions() as $option) {
            $form->add(
                $this->factory->create('sylius_assortment_option_value_choice', null, array(
                    'option' => $option
                ))
            );
        }
    }
}
