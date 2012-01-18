<?php

/*
 * This file is part of the Sylius package.
 *
 * (c) Paweł Jędrzejewski
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sylius\Bundle\AssortmentBundle\Tests\Model;

use Sylius\Bundle\AssortmentBundle\Model\Product;

class ProductTest extends \PHPUnit_Framework_TestCase
{
    public function testName()
    {
        $product = $this->getProduct();
        $this->assertNull($product->getName());

        $product->setName('testing product');
        $this->assertEquals('testing product', $product->getName());
    }

    public function testSlug()
    {
        $product = $this->getProduct();
        $this->assertNull($product->getSlug());

        $product->setSlug('testing-product');
        $this->assertEquals('testing-product', $product->getSlug());
    }

    public function testDescription()
    {
        $product = $this->getProduct();
        $this->assertNull($product->getDescription());

        $product->setDescription('testing product...');
        $this->assertEquals('testing product...', $product->getDescription());
    }

    public function testIncrementCreatedAt()
    {
        $product = $this->getProduct();
        $product->incrementCreatedAt();
        $this->assertEquals($product->getCreatedAt(), new \DateTime);
    }

    protected function getProduct()
    {
        return $this->getMockForAbstractClass('Sylius\Bundle\AssortmentBundle\Model\Product');
    }
}