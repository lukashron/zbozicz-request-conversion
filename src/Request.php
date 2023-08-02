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

namespace LukasHron\ZboziCzRequestConversion;

use LukasHron\ZboziCzRequestConversion\Order\Item;
use LukasHron\ZboziCzRequestConversion\Order\Order;
use function json_encode;

final class Request
{
    /**
     * @var string
     */
    const headerMethodPost = 'POST';

    /**
     * @var string
     */
    const headerContentTypeJson = 'application/json';

    private string $uri;

    private string $privateKey;

    private Order $order;

    private bool $sandboxMode;

    public function __construct(
        string $uri,
        string $privateKey,
        Order  $order,
        bool   $sandboxMode
    )
    {
        $this->uri = $uri;
        $this->privateKey = $privateKey;
        $this->order = $order;
        $this->sandboxMode = $sandboxMode;
    }

    public function getMethod(): string
    {
        return self::headerMethodPost;
    }

    public function getContentType(): string
    {
        return self::headerContentTypeJson;
    }

    public function getUri(): string
    {
        return $this->uri;
    }

    public function getBody(): string
    {
        $dataArray = [
            'PRIVATE_KEY' => $this->privateKey,
            'sandbox' => $this->sandboxMode,
            'orderId' => $this->order->getOrderId(),
            'email' => $this->order->getEmail(),
            'cart' => []
        ];

        is_null($this->order->getDeliveryType())
            ?: $dataArray['deliveryType'] = $this->order->getDeliveryType();

        is_null($this->order->getDeliveryPrice())
            ?: $dataArray['deliveryPrice'] = $this->order->getDeliveryPrice();

        is_null($this->order->getPaymentType())
            ?: $dataArray['paymentType'] = $this->order->getPaymentType();

        is_null($this->order->getOtherCosts())
            ?: $dataArray['otherCosts'] = $this->order->getOtherCosts();

        /** @var Item $item */
        foreach ($this->order->getCard() as $item) {

            $cartItem = [
                'itemId' => $item->getItemId(),
                'productName' => $item->getProductName()
            ];

            is_null($item->getUnitPrice())
                ?: $cartItem['unitPrice'] = $item->getUnitPrice();

            is_null($item->getQuantity())
                ?: $cartItem['quantity'] = $item->getQuantity();

            $dataArray['cart'][] = $cartItem;
        }

        return json_encode($dataArray);
    }
}
