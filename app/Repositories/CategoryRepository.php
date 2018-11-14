<?php

namespace App\Repositories;

use App\Models\Category;
use InfyOm\Generator\Common\BaseRepository;

/**
 * Class CategoryRepository
 * @package App\Repositories
 * @version November 7, 2018, 2:54 am UTC
 *
 * @method Category findWithoutFail($id, $columns = ['*'])
 * @method Category find($id, $columns = ['*'])
 * @method Category first($columns = ['*'])
*/
class CategoryRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name'
    ];

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Category::class;
    }

    public function getCategories($sortBy, $perPage, $filter){
        $listCategories = $this->model;
        if($sortBy[0] =='id')
            $listCategories = $this->model->orderBy('id', $sortBy[1]);
        if($sortBy[0] =='name')
            $listCategories = $this->model->orderBy('name', $sortBy[1]);
        if(!empty($filter)){
            if($filter && $filter->name){
                $listCategories = $listCategories->where('name','like','%'.$filter->name.'%');
            }
        }

        $listCategories = $listCategories->paginate($perPage);

        return $listCategories;

    }
}
