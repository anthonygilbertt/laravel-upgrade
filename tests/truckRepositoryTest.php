<?php

use App\Models\truck;
use App\Repositories\truckRepository;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class truckRepositoryTest extends TestCase
{
    use MaketruckTrait, ApiTestTrait, DatabaseTransactions;

    /**
     * @var truckRepository
     */
    protected $truckRepo;

    public function setUp()
    {
        parent::setUp();
        $this->truckRepo = App::make(truckRepository::class);
    }

    /**
     * @test create
     */
    public function testCreatetruck()
    {
        $truck = $this->faketruckData();
        $createdtruck = $this->truckRepo->create($truck);
        $createdtruck = $createdtruck->toArray();
        $this->assertArrayHasKey('id', $createdtruck);
        $this->assertNotNull($createdtruck['id'], 'Created truck must have id specified');
        $this->assertNotNull(truck::find($createdtruck['id']), 'truck with given id must be in DB');
        $this->assertModelData($truck, $createdtruck);
    }

    /**
     * @test read
     */
    public function testReadtruck()
    {
        $truck = $this->maketruck();
        $dbtruck = $this->truckRepo->find($truck->id);
        $dbtruck = $dbtruck->toArray();
        $this->assertModelData($truck->toArray(), $dbtruck);
    }

    /**
     * @test update
     */
    public function testUpdatetruck()
    {
        $truck = $this->maketruck();
        $faketruck = $this->faketruckData();
        $updatedtruck = $this->truckRepo->update($faketruck, $truck->id);
        $this->assertModelData($faketruck, $updatedtruck->toArray());
        $dbtruck = $this->truckRepo->find($truck->id);
        $this->assertModelData($faketruck, $dbtruck->toArray());
    }

    /**
     * @test delete
     */
    public function testDeletetruck()
    {
        $truck = $this->maketruck();
        $resp = $this->truckRepo->delete($truck->id);
        $this->assertTrue($resp);
        $this->assertNull(truck::find($truck->id), 'truck should not exist in DB');
    }
}
