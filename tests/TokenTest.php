<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenTest extends WebTestCase
{
    public function testTokenLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('participer')->form([
            'token[token]' => 'JeanCode'
        ]);

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect();

        $this->assertSelectorTextContains('html body', 'Poll is not currently running.');
    }

    public function testWithWrongToken()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('participer')->form([
            'token[token]' => '70K3N'
        ]);

        $crawler = $client->submit($form);
        $crawler = $client->followRedirects();

        $this->assertSelectorTextContains('html body', 'The value "70K3N" is not valid.');
    }
}