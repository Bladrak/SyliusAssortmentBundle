<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AssortmentBundle\EventDispatcher\Event;

use Sylius\Bundle\AssortmentBundle\Model\Property\PropertyInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Filter property event.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class FilterPropertyEvent extends Event
{
    /**
     * Property object.
     *
     * @var PropertyInterface
     */
    private $property;

    /**
     * Constructor.
     *
     * @param PropertyInterface $property
     */
    public function __construct(PropertyInterface $property)
    {
        $this->property = $property;
    }

    /**
     * Get property.
     *
     * @return PropertyInterface
     */
    public function getProperty()
    {
        return $this->property;
    }
}
