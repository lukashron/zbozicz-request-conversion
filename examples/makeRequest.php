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

namespace LukasHron\ZboziCzRequestConversion\Examples;

use LukasHron\ZboziCzRequestConversion\Exception\InvalidValueException;
use LukasHron\ZboziCzRequestConversion\Order\Item;
use LukasHron\ZboziCzRequestConversion\Order\Order;
use LukasHron\ZboziCzRequestConversion\RequestFactory;

require_once __DIR__ . '/../vendor/autoload.php';

try {
    $order = new Order();
    $order->setOrderId('exampleTestOrderId');
    $order->setEmail('example@email.com');
    $order->setDeliveryPrice(100);
    $order->setDeliveryType('own-hands');
    $order->setPaymentType('cash');
    $order->setOtherCosts(-20);
    $order->addItem(
        (new Item())
            ->setItemId('123')
            ->setProductName('Example product')
            ->setQuantity(1)
            ->setUnitPrice(200)
    );
} catch (InvalidValueException $exception) {
    var_dump($exception);
}

$requestFactory = new RequestFactory(123,  'secretKeys', false);

$request = $requestFactory->make($order);

var_dump($request);
var_dump($request->getBody());