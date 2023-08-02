<?php
/*
 * This file is part of the zbozicz-request-conversion.
 *
 * (c) Lukas Hron <info@lukashron.cz>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

use LukasHron\ZboziCzRequestConversion\Exception\InvalidValueException;
use LukasHron\ZboziCzRequestConversion\Order\Order;
use PHPUnit\Framework\TestCase;

final class OrderTest extends TestCase
{
    public function testOrderIdLength(): void
    {
        $order = new Order();
        $this->expectException(InvalidValueException::class);
        $order->setOrderId('0101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101');
    }

    public function testEmailLength(): void
    {
        $order = new Order();
        $this->expectException(InvalidValueException::class);
        $order->setEmail('01010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010');
    }

    public function testOtherCostsNegativeValue(): void
    {
        $order = new Order();
        $this->expectException(InvalidValueException::class);
        $order->setOtherCosts(100);
    }
}