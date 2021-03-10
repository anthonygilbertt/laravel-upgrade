<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class truckApiTest extends TestCase
{
    use MaketruckTrait, ApiTestTrait, WithoutMiddleware, DatabaseTransactions;

    /**
     * @test
     */
    public function testCreatetruck()
    {
        $truck = $this->faketruckData();
        $this->json('POST', '/api/v1/trucks', $truck);

        $this->assertApiResponse($truck);
    }

    /**
     * @test
     */
    public function testReadtruck()
    {
        $truck = $this->maketruck();
        $this->json('GET', '/api/v1/trucks/'.$truck->id);

        $this->assertApiResponse($truck->toArray());
    }

    /**
     * @test
     */
    public function testUpdatetruck()
    {
        $truck = $this->maketruck();
        $editedtruck = $this->faketruckData();

        $this->json('PUT', '/api/v1/trucks/'.$truck->id, $editedtruck);

        $this->assertApiResponse($editedtruck);
    }

    /**
     * @test
     */
    public function testDeletetruck()
    {
        $truck = $this->maketruck();
        $this->json('DELETE', '/api/v1/trucks/'.$truck->id);

        $this->assertApiSuccess();
        $this->json('GET', '/api/v1/trucks/'.$truck->id);

        $this->assertResponseStatus(404);
    }
}
