<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class truck
 * @package App\Models
 * @version March 23, 2018, 2:28 am UTC
 *
 * @property integer seats
 * @property float weight_capacity
 * @property float gas_mileage
 * @property string make
 * @property string model
 * @property integer year
 */
class truck extends Model
{
    use SoftDeletes;

    public $table = 'trucks';


    protected $dates = ['deleted_at'];


    public $fillable = [
        'seats',
        'weight_capacity',
        'gas_mileage',
        'make',
        'model',
        'year',
        'favorite',  ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'seats' => 'integer',
        'weight_capacity' => 'float',
        'gas_mileage' => 'float',
        'make' => 'string',
        'model' => 'string',
        'year' => 'integer',
        'favorite'=>'boolean',
    ];

    /**
     * Validation rules
     * @var array
     */
    public static $rules = [
        'seats' => 'required',
        'weight_capacity' => 'required',
        'make' => 'required',
        'model' => 'required',
        'year' => 'required'

        

    ];


}
