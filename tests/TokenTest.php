<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class TokenTest extends WebTestCase
{
    public function testTokenLogin()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Participer')->form([
            'token[token]' => 'JeanCode'
        ]);

        $client->submit($form);
        $client->followRedirects();

        $this->assertSelectorTextContains('html body', 'JeanCode');
    }

    public function testWithWrongToken()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $form = $crawler->selectButton('Participer')->form([
            'token[token]' => '70K3N'
        ]);

        $client->submit($form);
        $client->followRedirects();

        $this->assertSelectorTextContains('html body', 'Pas de sondage trouvé');
    }
}