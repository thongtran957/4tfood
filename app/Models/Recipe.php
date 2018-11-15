<?php

namespace App\Models;

use Eloquent as Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Recipe
 * @package App\Models
 * @version November 7, 2018, 3:42 am UTC
 *
 * @property string name
 * @property integer category_id
 * @property integer cost
 * @property integer prep_time
 * @property integer cook_time
 * @property string description
 * @property string ingredient
 * @property string instruction
 * @property integer active
 * @property string suitable_for
 * @property string link_img
 * @property string link_youtube
 */
class Recipe extends Model
{
    public $table = 'recipes';
    
    public $timestamps = false;

    public $fillable = [
        'name',
        'category_id',
        'cost',
        'prep_time',
        'cook_time',
        'description',
        'ingredient',
        'instruction',
        'active',
        'suitable_for',
        'name_img',
        'link_img',
        'link_youtube'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'name' => 'string',
        'category_id' => 'integer',
        'cost' => 'integer',
        'prep_time' => 'integer',
        'cook_time' => 'integer',
        'description' => 'string',
        'ingredient' => 'string',
        'instruction' => 'string',
        'active' => 'integer',
        'suitable_for' => 'string',
        'name_img' => 'string',
        'link_img' => 'string',
        'link_youtube' => 'string'
    ];

    /**
     * Validation rules
     *
     * @var array
     */
    public static $rules = [
        
    ];

    public function category(){
        return $this->belongsTo('App\Models\Category','category_id','id');
    }

    
}
