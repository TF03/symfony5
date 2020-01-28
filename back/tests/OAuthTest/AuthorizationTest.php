<?php

namespace App\Tests;

use OAuth2\OAuth2;
use Symfony\Bundle\FrameworkBundle\KernelBrowser;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouterInterface;

class AuthorizationTest extends WebTestCase
{
    /** @var RouterInterface */
    private $router;

    /** @var KernelBrowser */
    private $client;

    public function setUp()
    {
        $this->client = self::createClient();
        $this->router = self::$container->get(RouterInterface::class);
    }

    public function testAuthorization()
    {
        $parameters = [
            'client_id' => '1_19srr6w3qx5wws8cscg4w0s08sog8k44scgo0c8cks8cgkgkoc',
            'client_secret' => '300e8gd8rw8w08ww4kswog00gcw0kwk8sw8ocow0wo8s8o8ssk',
            'response_type' => OAuth2::RESPONSE_TYPE_ACCESS_TOKEN,
            'grant_type' => OAuth2::GRANT_TYPE_USER_CREDENTIALS,
            'username' => 'test',
            'password' => 'test',
        ];

        $url = $this->router->generate('fos_oauth_server_token');
        $this->client->request(Request::METHOD_POST, $url, $parameters);
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_OK, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);

        $url = $this->router->generate('get_test');
        $this->client->request(Request::METHOD_GET, $url, [], [], [
            'HTTP_AUTHORIZATION' => $content['access_token']
        ]);
        $response = $this->client->getResponse();
        $this->assertEquals(Response::HTTP_NO_CONTENT, $response->getStatusCode());
        $content = json_decode($response->getContent(), true);

        return;
    }
}