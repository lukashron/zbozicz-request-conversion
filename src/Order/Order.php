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

use LukasHron\ZboziCzRequestConversion\Exception\InvalidValueException;

final class Order implements OrderInterface
{
    /**
     * Číslo objednávky vygenerované e-shopem. Je třeba, aby se shodovalo u dat
     * zaslaných z frontendu i backendu, aby mohlo dojít k jejich spojení.
     * (maximum 255 znaků)
     */
    private string $orderId;

    /**
     * E-mail zákazníka. Může být využit pro ověření spokojenosti s nákupem a k žádosti o ohodnocení zakoupeného produktu.
     * Nezasílat v případě, kdy zákazník neudělil souhlas s jeho poskytnutím.
     * (maximum 100 znaků)
     */
    private ?string $email;

    /**
     * Obsah nákupního košíku.
     */
    private array $card;

    /**
     * Způsob dopravy, pokud možno DELIVERY_ID z feedu
     * (maximum 100 znaků)
     */
    private ?string $deliveryType;

    /**
     * Cena dopravy v Kč včetně DPH. (Znaménkový 32bitový integer, 0 – (231-1)/100.)
     */
    private ?int $deliveryPrice;

    /**
     * Další náklady či slevy na objednávku, platbu kartou, instalace, množstevní sleva apod.
     * Slevy jsou uvedeny jako záporné číslo. (Znaménkový 32bitový integer, -231/100 – (231-1)/100.)
     */
    private ?int $otherCosts;

    /**
     * Způsob platby. Může být libovolný řetězec (např. kartou, hotovost apod.).
     * (maximum 100 znaků)
     */
    private ?string $paymentType;

    public function __construct()
    {
        $this->email = null;
        $this->deliveryType = null;
        $this->deliveryPrice = null;
        $this->otherCosts = null;
        $this->paymentType = null;
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @throws InvalidValueException
     */
    public function setOrderId(string $orderId): void
    {
        if (strlen($orderId) > 255) {
            throw new InvalidValueException('Order id must be maximum length 255 char.');
        }

        $this->orderId = $orderId;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @throws InvalidValueException
     */
    public function setEmail(?string $email): void
    {
        if (strlen($email) > 100) {
            throw new InvalidValueException('Email must be maximum length 100 char.');
        }

        $this->email = $email;
    }

    public function addItem(Item $item): void
    {
        $this->card[] = $item;
    }

    public function getCard(): array
    {
        return $this->card;
    }

    public function getDeliveryType(): ?string
    {
        return $this->deliveryType;
    }

    /**
     * @throws InvalidValueException
     */
    public function setDeliveryType(?string $deliveryType): void
    {
        if (strlen($deliveryType) > 100) {
            throw new InvalidValueException('Delivery type must be maximum length 100 char.');
        }

        $this->deliveryType = $deliveryType;
    }

    public function getDeliveryPrice(): ?int
    {
        return $this->deliveryPrice;
    }

    public function setDeliveryPrice(?int $deliveryPrice): void
    {
        $this->deliveryPrice = $deliveryPrice;
    }

    public function getOtherCosts(): ?int
    {
        return $this->otherCosts;
    }

    /**
     * @throws InvalidValueException
     */
    public function setOtherCosts(?int $otherCosts): void
    {
        if ($otherCosts > 0) {
            throw new InvalidValueException('Other cost must be negative number.');
        }

        $this->otherCosts = $otherCosts;
    }

    public function getPaymentType(): ?string
    {
        return $this->paymentType;
    }

    /**
     * @throws InvalidValueException
     */
    public function setPaymentType(?string $paymentType): void
    {
        if (strlen($paymentType) > 100) {
            throw new InvalidValueException('Payment type must be maximum length 100 char.');
        }

        $this->paymentType = $paymentType;
    }
}