<?php

namespace App\Repositories;

use App\Models\Recipe;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class RecipeRepository
 * @package App\Repositories
 * @version November 7, 2018, 3:42 am UTC
 *
 * @method Recipe findWithoutFail($id, $columns = ['*'])
 * @method Recipe find($id, $columns = ['*'])
 * @method Recipe first($columns = ['*'])
*/
class RecipeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
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
        'link_img',
        'link_youtube'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Recipe::class;
    }

    public function getRecipes(){
        $listRecipes = $this->with('category')->get();
        $listRecipes = $this->tranform($listRecipes);
        return $listRecipes;
    }

    public function tranform($results){
        foreach ($results as $key => $result) {
            if($result->category != null){
                $results[$key]->cname = $result->category->name;
            }else{
                $results[$key]->cname = '';
            }          
        }
        return $results;
    }
}
