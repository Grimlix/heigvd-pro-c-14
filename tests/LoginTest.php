<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class LoginTest extends WebTestCase
{
    #################################################################
    ## LANCER REGISTER TEST EN PREMIER AFIN QUE JEANTEST SOIT CREE ##
    #################################################################
    public function testLogin(){
        $client = static::createClient();

        $crawler = $client->request('GET','/login');

        $form = $crawler->selectButton('Log in')->form([
            '_username' => 'JeanTest',
            '_password' => '123',
        ]);

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect(true);

        $crawler = $client->request('GET','/admin/?entity=User');


        $this->assertSelectorTextContains('html body','JeanTest');
        $this->assertSelectorTextContains('html body','JeanTest@gmail.com');
    }

    public function testLoginWithWrongCredential(){
        $client = static::createClient();

        $crawler = $client->request('GET','/login');

        $form = $crawler->selectButton('Log in')->form([
            '_username' => 'JeanTest',
            '_password' => '1234',
        ]);

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect(true);

        $this->assertSelectorTextContains('html body','Invalid credentials.');
    }
}