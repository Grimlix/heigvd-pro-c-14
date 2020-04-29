<?php


namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class RegisterTest extends WebTestCase
{
    public function testRegistration(){
        $client = static::createClient();

        $crawler = $client->request('GET','/register/');

        $form = $crawler->selectButton('Register')->form([
            'fos_user_registration_form[email]' => 'JeanTest@gmail.com',
            'fos_user_registration_form[username]' => 'JeanTest',
            'fos_user_registration_form[plainPassword][first]' => '123',
            'fos_user_registration_form[plainPassword][second]' => '123',
        ]);

        $crawler = $client->submit($form);
        $crawler = $client->followRedirect(true);

        $this->assertSelectorTextContains('html body','Logged in as JeanTest');
        $this->assertSelectorTextContains('html body','The user has been created successfully.');
        $this->assertSelectorTextContains('html body','Congrats JeanTest, your account is now activated.');


    }

    public function testSecondRegistrationWithSameEmail(){
        $client = static::createClient();

        $crawler = $client->request('GET','/register/');

        $form = $crawler->selectButton('Register')->form([
            'fos_user_registration_form[email]' => 'JeanTest@gmail.com',
            'fos_user_registration_form[username]' => 'JeanTest2',
            'fos_user_registration_form[plainPassword][first]' => '123',
            'fos_user_registration_form[plainPassword][second]' => '123',
        ]);

        $crawler = $client->submit($form);

        $this->assertSelectorTextContains('html body','The email is already used.');
    }

    public function testSecondRegistrationWithSameUsername(){
        $client = static::createClient();

        $crawler = $client->request('GET','/register/');

        $form = $crawler->selectButton('Register')->form([
            'fos_user_registration_form[email]' => 'JeanTest2@gmail.com',
            'fos_user_registration_form[username]' => 'JeanTest',
            'fos_user_registration_form[plainPassword][first]' => '123',
            'fos_user_registration_form[plainPassword][second]' => '123',
        ]);

        $crawler = $client->submit($form);

        $this->assertSelectorTextContains('html body','The username is already used.');
    }

}