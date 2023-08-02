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

interface OrderInterface
{
    public function getOrderId(): string;

    public function getEmail(): ?string;

    public function getCard(): array;

    public function getDeliveryType(): ?string;

    public function getDeliveryPrice(): ?int;

    public function getOtherCosts(): ?int;

    public function getPaymentType(): ?string;
}