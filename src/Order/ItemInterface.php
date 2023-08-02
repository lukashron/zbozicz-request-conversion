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

namespace LukasHron\ZboziCzRequestConversion\Order;

interface ItemInterface
{
    public function getItemId(): string;

    public function getProductName(): string;

    public function getUnitPrice(): ?int;

    public function getQuantity(): ?int;
}