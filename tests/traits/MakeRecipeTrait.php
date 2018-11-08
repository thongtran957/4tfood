<?php

use Faker\Factory as Faker;
use App\Models\Recipe;
use App\Repositories\RecipeRepository;

trait MakeRecipeTrait
{
    /**
     * Create fake instance of Recipe and save it in database
     *
     * @param array $recipeFields
     * @return Recipe
     */
    public function makeRecipe($recipeFields = [])
    {
        /** @var RecipeRepository $recipeRepo */
        $recipeRepo = App::make(RecipeRepository::class);
        $theme = $this->fakeRecipeData($recipeFields);
        return $recipeRepo->create($theme);
    }

    /**
     * Get fake instance of Recipe
     *
     * @param array $recipeFields
     * @return Recipe
     */
    public function fakeRecipe($recipeFields = [])
    {
        return new Recipe($this->fakeRecipeData($recipeFields));
    }

    /**
     * Get fake data of Recipe
     *
     * @param array $postFields
     * @return array
     */
    public function fakeRecipeData($recipeFields = [])
    {
        $fake = Faker::create();

        return array_merge([
            'name' => $fake->word,
            'category_id' => $fake->randomDigitNotNull,
            'cost' => $fake->randomDigitNotNull,
            'prep_time' => $fake->randomDigitNotNull,
            'cook_time' => $fake->randomDigitNotNull,
            'description' => $fake->text,
            'ingredient' => $fake->text,
            'instruction' => $fake->text,
            'active' => $fake->randomDigitNotNull,
            'suitable_for' => $fake->word,
            'link_img' => $fake->word,
            'link_youtube' => $fake->word,
            'created_at' => $fake->word,
            'updated_at' => $fake->word
        ], $recipeFields);
    }
}
