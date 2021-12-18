<?php

namespace EasyCorp\Bundle\EasyAdminBundle\Tests\Controller;

use Symfony\Bundle\FrameworkBundle\Console\Application;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\Console\Tester\CommandTester;

class DashboardControllerTest extends WebTestCase
{
    // The /admin page is not secured, but this test fails because
    // HTTP/1.1 401 Unauthorized
    // Cache-Control:    max-age=0, must-revalidate, private
    // Content-Type:     text/html; charset=UTF-8
    // Date:             Sat, 18 Dec 2021 15:39:09 GMT
    // Expires:          Sat, 18 Dec 2021 15:39:09 GMT
    // Set-Cookie:       MOCKSESSID=a04db0129b46237d1abc782f8686f57722d5db47edd6004238c0e745534b448e; path=/; httponly; samesite=lax
    // Www-Authenticate: Basic realm="Secured Area"
    public function testWelcomePage()
    {
        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/admin');

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.title', 'Welcome to EasyAdmin 4');
    }

    // The /secure_admin page exists, as demonstrated by the 'router:match' execution,
    // but anyways the test fails because of this: "No route found for "GET http://localhost/secure_admin""
    public function testWelcomePageAsLoggedUser()
    {
        $client = static::createClient();
        $application = new Application($client->getKernel());
        $commandTester = new CommandTester($application->find('router:match'));
        $commandTester->execute(['path_info' => '/secure_admin']);
        dump($commandTester->getDisplay());
        self::ensureKernelShutdown();

        $client = static::createClient();
        $client->followRedirects();
        $client->request('GET', '/secure_admin', [], [], ['PHP_AUTH_USER' => 'admin', 'PHP_AUTH_PW' => '1234']);

        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1.title', 'Welcome to EasyAdmin 4');
    }
}
