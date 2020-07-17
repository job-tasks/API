<?php

/**
 * @author Nikolay Nikolov
 */

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class ApiControllerTest extends WebTestCase
{
    /**
     * @dataProvider provideUrls
     * @param $url
     */
    public function testCheckUrlIsBlocked($url): void
    {
        $client = static::createClient();

        $client->request('GET', 'api/is-url-blocked-by-adblockers?url=' . $url);

        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
        $this->assertJson($client->getResponse()->getContent(), 'AssertJson');
        $this->assertResponseIsSuccessful();
        $this->assertResponseHeaderSame('content-type', 'application/json');
    }

    /**
     * @return array
     */
    public function provideUrls()
    {
        return [
            ['http://www.abv.bg/jgc-adblfockerr/sa'],
            ['http://www.abv.bg'],
            ['http://www.abv.bg/-ad-iframe.'],
            ['http://www.abv.bg/asda/sadsadad'],
        ];
    }
}