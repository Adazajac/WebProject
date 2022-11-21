<?php

namespace App\Tests\Unit\Entity;

use App\Service\GithubService;
use PHPUnit\Framework\TestCase;

class GithubServiceTest extends TestCase
{

    /**
     * @dataProvider quantityGreaterThanZero
     */
    public function testGetGoodQuantity(float $quantity): void
    {
        $service = new GithubService();

        self::assertGreaterThanOrEqual(0, $service->getQuantity($quantity));
    }

    public function quantityGreaterThanZero(): \Generator
    {
        yield 'Quantity 0' => [0];
        yield 'Quantity 1.5' => [1.5];
        yield 'Quantity 10' => [10];
        yield 'Quantity 50.50' => [50.50];
    }
}