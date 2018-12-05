<?php

namespace App\Repositories;

use App\Models\Recipe;
use App\Models\Category;
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

    public function getRecipes($sortBy, $filter, $perPage){

        $listRecipes = Recipe::join('categories', 'recipes.category_id', '=', 'categories.id')->select('categories.name as cname','recipes.*');

        if($sortBy[0] =='id')
            $listRecipes = $listRecipes->orderBy('id', $sortBy[1]);
        if($sortBy[0] =='cost')
            $listRecipes = $listRecipes->orderBy('cost', $sortBy[1]);
        if($sortBy[0] =='prep_time')
            $listRecipes = $listRecipes->orderBy('prep_time', $sortBy[1]);
        if($sortBy[0] =='cook_time')
            $listRecipes = $listRecipes->orderBy('cook_time', $sortBy[1]);

        if(!empty($filter)){
            if($filter && $filter->cname){
                $category_id = Category::select('id')->where('name',$filter->cname)->first()->toArray();
                $category_id = $category_id['id']; 

                $listRecipes = $listRecipes->where('category_id', $category_id);              
            }

            if($filter && $filter->name){
                $listRecipes = $listRecipes->where('recipes.name', 'like', '%'.$filter->name.'%');              
            }
        }

        $listRecipes = $listRecipes->paginate($perPage);

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

    public function add($name_img, $link_img, $input){
        $category_id = Category::select('id')->where('name',$input['cname'])->first()->toArray();
        $category_id = $category_id['id'];
        
        if($input['active'] != null){
            $active = 1;
        }else{
            $active = 0;
        }

        $array = [
            'name' => $input['name'],
            'category_id' => $category_id,
            'cost' => $input['cost'],
            'prep_time' => $input['prep_time'],
            'cook_time' => $input['cook_time'],
            'description' => $input['description'],
            'ingredient' => $input['ingredient'],
            'instruction' => $input['instruction'],
            'active' => $active,
            'suitable_for' => $input['suitable_for'],
            'name_img' => $name_img,
            'link_img' => $link_img,

        ];

        $result = Recipe::create($array);
        return $result;
    }

    public function edit($name_img, $link_img, $input){
        $category_id = Category::select('id')->where('name',$input['cname'])->first()->toArray();
        $category_id = $category_id['id'];
        dd($input['active']);
        if($input['active'] != null){
            $active = 1;
        }else{
            $active = 0;
        }

        $array = [
            'name' => $input['name'],
            'category_id' => $category_id,
            'cost' => $input['cost'],
            'prep_time' => $input['prep_time'],
            'cook_time' => $input['cook_time'],
            'description' => $input['description'],
            'ingredient' => $input['ingredient'],
            'instruction' => $input['instruction'],
            'active' => $active,
            'suitable_for' => $input['suitable_for'],
            'name_img' => $name_img,
            'link_img' => $link_img,

        ];

        $result = Recipe::where('id',$input['id'])->update($array);
        return $result;

    }
}
