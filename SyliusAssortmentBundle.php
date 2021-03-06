<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AssortmentBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

/**
 * Product management bundle with highly flexible architecture.
 * It handles basic product actions like CRUD and displaying.
 * Splitted into two areas, backend and frontend.
 *
 * Suitable only for ORM based stores.
 *
 * @author Paweł Jędrzejewski <pjedrzejewski@diweb.pl>
 */
class SyliusAssortmentBundle extends Bundle
{
    // Bundle driver list.
    const DRIVER_DOCTRINE_ORM = 'doctrine/orm';
    const DRIVER_PROPEL2      = 'propel2';

    /**
     * Return array with currently supported drivers.
     *
     * @return array
     */
    static public function getSupportedDrivers()
    {
        return array(
            self::DRIVER_DOCTRINE_ORM
        );
    }
}
