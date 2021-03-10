<?php

namespace App\Repositories;

use App\Models\truck;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class truckRepository
 * @package App\Repositories
 * @version March 23, 2018, 2:28 am UTC
 *
 * @method truck findWithoutFail($id, $columns = ['*'])
 * @method truck find($id, $columns = ['*'])
 * @method truck first($columns = ['*'])
*/
class truckRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'seats',
        'weight_capacity',
        'gas_mileage',
        'make',
        'model',
        'year'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return truck::class;
    }
}
