<?php

namespace App\Tests\Unit\Entity;

use App\Entity\Article;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{
    /**
     * @dataProvider quantityGreaterThanZero
     */
    public function testQuantityGreaterOrEqualZero(float $quantity): void
    {
        $article = new Article();
        $article->setQuantity($quantity);

        self::assertGreaterThanOrEqual(0.0, $article->getQuantity());

    }

    public function quantityGreaterThanZero(): \Generator
    {
        yield 'Quantity 0' => [0];
        yield 'Quantity 1.5' => [1.5];
        yield 'Quantity 10' => [10];
        yield 'Quantity 50.50' => [50.50];
    }


}
