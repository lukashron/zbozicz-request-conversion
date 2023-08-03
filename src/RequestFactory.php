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

use LukasHron\ZboziCzRequestConversion\Order\OrderInterface;

final class RequestFactory
{
    /**
     * @var string
     */
    const apiEndpointPattern = 'https://%s/action/%s/conversion/backend';

    private int $shopId;

    private string $privateKey;

    private bool $sandboxMode;

    public function __construct(
        int    $shopId,
        string $privateKey,
        bool   $sandboxMode = false
    )
    {
        $this->shopId = $shopId;
        $this->privateKey = $privateKey;
        $this->sandboxMode = $sandboxMode;
    }

    public function make(OrderInterface $order): Request
    {
        return new Request(
            sprintf(
                self::apiEndpointPattern,
                $this->sandboxMode ? 'sandbox.zbozi.cz' : 'www.zbozi.cz',
                $this->shopId
            ),
            $this->privateKey,
            $order,
            $this->sandboxMode
        );
    }
}
