<?php

namespace tests\AppBundle\Entity;
use PHPUnit\Framework\TestCase;
use App\Article\Domain\Entity\Article;

class ArticleTest extends TestCase
{
    public function testSettingTitle()
    {
        $article = new Article();
        $this->assertSame(0, $article->getId());

        $article->setTitle(1);

        $this->assertSame(1, $article->getTitle());
    }
}