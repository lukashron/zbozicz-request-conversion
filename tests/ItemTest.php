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
use LukasHron\ZboziCzRequestConversion\Order\Item;
use PHPUnit\Framework\TestCase;

final class ItemTest extends TestCase
{
    public function testItemIdLength(): void
    {
        $item = new Item();
        $this->expectException(InvalidValueException::class);
        $item->setItemId('0101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101');
    }

    public function testNameLength(): void
    {
        $item = new Item();
        $this->expectException(InvalidValueException::class);
        $item->setProductName('0101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101010101');
    }
}