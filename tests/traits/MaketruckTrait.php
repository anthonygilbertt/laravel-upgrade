<?php

use Faker\Factory as Faker;
use App\Models\truck;
use App\Repositories\truckRepository;

trait MaketruckTrait
{
    /**
     * Create fake instance of truck and save it in database
     *
     * @param array $truckFields
     * @return truck
     */
    public function maketruck($truckFields = [])
    {
        /** @var truckRepository $truckRepo */
        $truckRepo = App::make(truckRepository::class);
        $theme = $this->faketruckData($truckFields);
        return $truckRepo->create($theme);
    }

    /**
     * Get fake instance of truck
     *
     * @param array $truckFields
     * @return truck
     */
    public function faketruck($truckFields = [])
    {
        return new truck($this->faketruckData($truckFields));
    }

    /**
     * Get fake data of truck
     *
     * @param array $postFields
     * @return array
     */
    public function faketruckData($truckFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'seats' => $fake->randomDigitNotNull,
            'weight_capacity' => $fake->randomDigitNotNull,
            'gas_mileage' => $fake->randomDigitNotNull,
            'make' => $fake->word,
            'model' => $fake->word,
            'year' => $fake->randomDigitNotNull,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $truckFields);
    }
}
