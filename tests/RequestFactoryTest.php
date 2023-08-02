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

use LukasHron\ZboziCzRequestConversion\Order\Item;
use LukasHron\ZboziCzRequestConversion\Order\Order;
use LukasHron\ZboziCzRequestConversion\Request;
use LukasHron\ZboziCzRequestConversion\RequestFactory;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpClient\HttpClient;

final class RequestFactoryTest extends TestCase
{
    /**
     * @return Order
     * @throws \LukasHron\ZboziCzRequestConversion\Exception\InvalidValueException
     */
    private function makeOrder(): Order
    {
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

        return $order;
    }

    public function testMakeProductionRequest(): void
    {
        $requestFactory = new RequestFactory(123,  'secretKeys', false);

        $request = $requestFactory->make($this->makeOrder());

        $this->assertEquals(Request::headerMethodPost, $request->getMethod());
        $this->assertEquals(Request::headerContentTypeJson, $request->getContentType());
        $this->assertEquals('https://www.zbozi.cz/action/123/conversion/backend', $request->getUri());

        $this->assertEquals('{"PRIVATE_KEY":"secretKeys","sandbox":false,"orderId":"exampleTestOrderId","email":"example@email.com","cart":[{"itemId":"123","productName":"Example product","unitPrice":200,"quantity":1}],"deliveryType":"own-hands","deliveryPrice":100,"paymentType":"cash","otherCosts":-20}', $request->getBody());
    }

    /**
     * @return void
     */
    public function testMakeSandboxRequest(): void
    {
        $requestFactory = new RequestFactory(123,  'secretKeys', true);

        $request = $requestFactory->make($this->makeOrder());

        $this->assertEquals(Request::headerMethodPost, $request->getMethod());
        $this->assertEquals(Request::headerContentTypeJson, $request->getContentType());
        $this->assertEquals('https://sandbox.zbozi.cz/action/123/conversion/backend', $request->getUri());

        $this->assertEquals('{"PRIVATE_KEY":"secretKeys","sandbox":true,"orderId":"exampleTestOrderId","email":"example@email.com","cart":[{"itemId":"123","productName":"Example product","unitPrice":200,"quantity":1}],"deliveryType":"own-hands","deliveryPrice":100,"paymentType":"cash","otherCosts":-20}', $request->getBody());
    }

    /**
     * @return void
     * @throws \Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\DecodingExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface
     * @throws \Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface
     */
    public function testSendSandboxRequest(): void
    {
        $requestFactory = new RequestFactory(123,  'secretKeys', true);

        $request = $requestFactory->make($this->makeOrder());

        $client = HttpClient::create();
        $response = $client->request(
            $request->getMethod(),
            $request->getUri(),
            [
                'headers' => [
                    'User-Agent' => 'lukas-hron-php-zbozi-cz',
                    'Content-Type' => $request->getContentType(),
                ],
                'body' => $request->getBody()
            ]
        );

        $this->assertTrue($response->getStatusCode() === 200);

        $this->assertArrayHasKey('status', $response->toArray());
        $this->assertEquals(200, $response->toArray()['status']);

        $this->assertArrayHasKey('statusMessage', $response->toArray());
        $this->assertEquals('OK', $response->toArray()['statusMessage']);
    }
}