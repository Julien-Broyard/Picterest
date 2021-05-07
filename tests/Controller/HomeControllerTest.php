<?php

namespace App\Tests\Controller;

use Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    /** @dataProvider getPublicUrls */
    public function testPublicUrls(string $url): void
    {
        $client = static::createClient();
        $client->request('GET', $url);

        $this->assertResponseIsSuccessful(sprintf('The %s public URL loads correctly.', $url));
    }

    public function testHome(): void
    {
        $client = static::createClient();
        $client->request('GET', '/');

        $this->assertSelectorExists('h1');
    }

    public function getPublicUrls(): ?Generator
    {
        yield ['/'];
    }
}
