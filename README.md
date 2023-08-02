# Request generátor pro Zboží.cz konverze

Install
-------
```
$ composer require lukashron/zbozicz-request-conversion
```

Use
---
```php
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
    ...
}

$requestFactory = new RequestFactory(123,  'secretKeys', false);

$request = $requestFactory->make($order);
```

Code
----
```bash
$ docker compose exec app php ./vendor/bin/phpunit
$ docker compose exec app php vendor/bin/rector process
```

www.lukashron.cz