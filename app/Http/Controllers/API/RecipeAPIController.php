<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateRecipeAPIRequest;
use App\Http\Requests\API\UpdateRecipeAPIRequest;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use InfyOm\Generator\Criteria\LimitOffsetCriteria;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;
use App\Http\Controllers\API\File;

/**
 * Class RecipeController
 * @package App\Http\Controllers\API
 */

class RecipeAPIController extends AppBaseController
{
    /** @var  RecipeRepository */
    private $recipeRepository;

    public function __construct(RecipeRepository $recipeRepo)
    {
        $this->recipeRepository = $recipeRepo;
    }

    /**
     * Display a listing of the Recipe.
     * GET|HEAD /recipes
     *
     * @param Request $request
     * @return Response
     */
    public function index(Request $request)
    {
        $this->recipeRepository->pushCriteria(new RequestCriteria($request));
        $this->recipeRepository->pushCriteria(new LimitOffsetCriteria($request));

        $perPage = $request->input('per_page',10);
        if($request->has('sort') && $request->input('sort'))
            $sortBy = explode('|', $request->input('sort'));
        else
            $sortBy = explode('|', 'id|desc');

        $filter = '';
        if($request->has('filter') && $request->input('filter'))
            $filter = json_decode($request->input('filter'));
       

        $recipes = $this->recipeRepository->getRecipes($sortBy, $filter, $perPage); 

        return $this->sendResponse($recipes->toArray(), 'Recipes retrieved successfully');
    }

    /**
     * Store a newly created Recipe in storage.
     * POST /recipes
     *
     * @param CreateRecipeAPIRequest $request
     *
     * @return Response
     */
    public function store(CreateRecipeAPIRequest $request)
    {
        $input = $request->all();

        $recipes = $this->recipeRepository->create($input);

        return $this->sendResponse($recipes->toArray(), 'Recipe saved successfully');
    }

    /**
     * Display the specified Recipe.
     * GET|HEAD /recipes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Recipe $recipe */
        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            return $this->sendError('Recipe not found');
        }

        return $this->sendResponse($recipe->toArray(), 'Recipe retrieved successfully');
    }

    /**
     * Update the specified Recipe in storage.
     * PUT/PATCH /recipes/{id}
     *
     * @param  int $id
     * @param UpdateRecipeAPIRequest $request
     *
     * @return Response
     */
    public function update($id, UpdateRecipeAPIRequest $request)
    {
        $input = $request->all();

        /** @var Recipe $recipe */
        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            return $this->sendError('Recipe not found');
        }

        $recipe = $this->recipeRepository->update($input, $id);

        return $this->sendResponse($recipe->toArray(), 'Recipe updated successfully');
    }

    /**
     * Remove the specified Recipe from storage.
     * DELETE /recipes/{id}
     *
     * @param  int $id
     *
     * @return Response
     */
    public function destroy($id)
    {
        /** @var Recipe $recipe */
        $pathPublic = public_path().'/files/';
        $fileOld = Recipe::select('link_img','name_img')->where('id', $id)->get()->toArray();

        $nameOld = $fileOld[0]['name_img'];
        $linkOld = $fileOld[0]['link_img'];

        $dir = '/';
        $recursive = false; 
        $contents = collect(\Storage::cloud()->listContents($dir, $recursive));
        $link_img = $contents
            ->where('type', '=', 'file')
            ->where('filename', '=', pathinfo($nameOld, PATHINFO_FILENAME))
            ->where('extension', '=', pathinfo($nameOld, PATHINFO_EXTENSION))
            ->first();
        \Storage::cloud()->delete($link_img['path']);

        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            return $this->sendError('Recipe not found');
        }

        $recipe->delete();

        return $this->sendResponse($id, 'Recipe deleted successfully');
    }

    public function addRecipe(Request $request){
        $input = $request->all();
        if($request->file_name != "undefined"){
            $file = $request->file_name;
         
            if(!empty($file)) {
                $name = $file->getClientOriginalName();
                $arrayName = explode('.', $name);
                $filename = $arrayName[0].'-'.time().'.'.$arrayName[1];
              
                $pathPublic = public_path().'/files/';
                if(\File::exists($pathPublic.$filename)){
                    unlink($pathPublic.$filename);
                }
                if(!\File::exists($pathPublic)) {
                    \File::makeDirectory($pathPublic, $mode = 0777, true, true);
                }
                $file->move($pathPublic, $filename);
                $fileData = \File::get($pathPublic.$filename);
                \Storage::cloud()->put($filename, $fileData);
               
                $dir = '/';
                $recursive = false; 
                $contents = collect(\Storage::cloud()->listContents($dir, $recursive));
                $link_img = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first(); 

               
                $link_img = 'https://drive.google.com/uc?id='.$link_img['path'];
                $name_img = $filename;

                unlink($pathPublic.$filename);

                $result = $this->recipeRepository->add($name_img, $link_img, $input);


                return $this->sendResponse($result->toArray(), 'Recipe saved successfully');
                
            }
        }
        
    }

    public function editRecipe(Request $request){

        $input = $request->all();
        $fileOld = Recipe::select('link_img','name_img')->where('id', $input['id'])->get()->toArray();

        $nameOld = $fileOld[0]['name_img'];
        $linkOld = $fileOld[0]['link_img'];


        $input = $request->all();
        if($request->file_name != "undefined"){
            $file = $request->file_name;
         
            if(!empty($file)) {
                $fileOldName = Recipe::select('link_img')->where('id', $input['id'])->get()->toArray();

                $name = $file->getClientOriginalName();
                $arrayName = explode('.', $name);
                $filename = $arrayName[0].'-'.time().'.'.$arrayName[1];
              
                $pathPublic = public_path().'/files/';
                if(\File::exists($pathPublic.$filename)){
                    unlink($pathPublic.$filename);
                }
                if(!\File::exists($pathPublic)) {
                    \File::makeDirectory($pathPublic, $mode = 0777, true, true);
                }
                $file->move($pathPublic, $filename);
                $fileData = \File::get($pathPublic.$filename);
                \Storage::cloud()->put($filename, $fileData);
               

                $dir = '/';
                $recursive = false; 
                $contents = collect(\Storage::cloud()->listContents($dir, $recursive));
                $link_img = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($filename, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($filename, PATHINFO_EXTENSION))
                    ->first(); 

               
                $link_img = 'https://drive.google.com/uc?id='.$link_img['path'];
                $name_img = $filename;

                unlink($pathPublic.$filename);

                $fileDelete = $contents
                    ->where('type', '=', 'file')
                    ->where('filename', '=', pathinfo($nameOld, PATHINFO_FILENAME))
                    ->where('extension', '=', pathinfo($nameOld, PATHINFO_EXTENSION))
                    ->first(); 
                \Storage::cloud()->delete($fileDelete['path']);

                $result = $this->recipeRepository->edit($name_img, $link_img, $input);

                return $this->sendResponse($result, 'Recipe saved successfully');

            }
        }else{
            $link_img = $linkOld;
            $name_img = $nameOld;
            $result = $this->recipeRepository->edit($name_img, $link_img, $input);

            return $this->sendResponse($result, 'Recipe saved successfully');
        }
    
    }

    public function getRecipes(Request $request){
        $listRecipes = Recipe::join('categories', 'recipes.category_id', '=', 'categories.id')->select('categories.name as cname','recipes.*');
        if($request->has('sort') && $request->input('sort'))
            $sortBy = explode('|', $request->input('sort'));
        else
            $sortBy = explode('|', 'id|desc');

        if($sortBy[0] =='id')
            $listRecipes = $listRecipes->orderBy('id', $sortBy[1]);
        if($sortBy[0] =='cost')
            $listRecipes = $listRecipes->orderBy('cost', $sortBy[1]);
        if($sortBy[0] =='prep_time')
            $listRecipes = $listRecipes->orderBy('prep_time', $sortBy[1]);
        if($sortBy[0] =='cook_time')
            $listRecipes = $listRecipes->orderBy('cook_time', $sortBy[1]);

        $filter = '';
        if($request->has('filter') && $request->input('filter'))
            $filter = json_decode($request->input('filter'));

        if(!empty($filter)){
            if($filter && $filter->name){
                $listRecipes = $listRecipes->where('recipes.name', 'like', '%'.$filter->name.'%');              
            }
            if($filter && $filter->category_id){
                $listRecipes = $listRecipes->where('recipes.category_id',$filter->category_id);
            }
        }


        $listRecipes = $listRecipes->get()->toArray();
        return $listRecipes;
    }

}
