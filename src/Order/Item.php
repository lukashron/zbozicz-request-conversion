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

final class Item implements ItemInterface
{
    /**
     * ID položky v e-shopu (ITEM_ID z feedu)
     * (maximum 255 znaků)
     */
    private string $itemId;

    /**
     * Název položky, ideálně PRODUCTNAME z feedu
     * (maximum 255 znaků)
     */
    private string $productName;

    /**
     * Jednotková cena položky v Kč včetně DPH. (0 – (231-1).)
     */
    private ?int $unitPrice;

    /**
     * Počet zakoupených kusů. (1 – (231-1).)
     */
    private ?int $quantity;

    public function __construct()
    {
        $this->unitPrice = null;
        $this->quantity = null;
    }

    public function getItemId(): string
    {
        return $this->itemId;
    }

    /**
     * @param string $itemId
     * @return $this
     * @throws InvalidValueException
     */
    public function setItemId(string $itemId): self
    {
        if (strlen($itemId) > 255) {
            throw new InvalidValueException('Item id must be maximum length 255 char.');
        }

        $this->itemId = $itemId;
        return $this;
    }

    public function getProductName(): string
    {
        return $this->productName;
    }

    /**
     * @param string $productName
     * @return $this
     * @throws InvalidValueException
     */
    public function setProductName(string $productName): self
    {
        if (strlen($productName) > 255) {
            throw new InvalidValueException('Item id must be maximum length 255 char.');
        }

        $this->productName = $productName;
        return $this;
    }

    public function getUnitPrice(): ?int
    {
        return $this->unitPrice;
    }

    public function setUnitPrice(?int $unitPrice): self
    {
        $this->unitPrice = $unitPrice;
        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): self
    {
        $this->quantity = $quantity;
        return $this;
    }
}