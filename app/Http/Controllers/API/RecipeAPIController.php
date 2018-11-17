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
        $recipes = $this->recipeRepository->getRecipes();          
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
        $recipe = $this->recipeRepository->findWithoutFail($id);

        if (empty($recipe)) {
            return $this->sendError('Recipe not found');
        }

        $recipe->delete();

        return $this->sendResponse($id, 'Recipe deleted successfully');
    }

    public function addRecipe(Request $request){
        $image = $request->file('file_name');
        $a = $image->getClientOriginalName();
        // dd($a);
       
        $filePath = $a;
        $fileData = \File::get($filePath);
        \Storage::cloud()->put('image1asd-------------------------123456
            ', $fileData);
        return 'File was saved to Google Drive';

    }
}
