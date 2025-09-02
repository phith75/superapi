<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Recipe\StoreRecipeRequest;
use App\Http\Requests\Recipe\UpdateRecipeRequest;
use App\Http\Resources\Api\RecipeResource;
use App\Services\RecipeService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class RecipeController extends Controller
{
    public function __construct(
        protected RecipeService $recipeService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['max_calories']);
        
        $recipes = $this->recipeService->list($filters);
        
        return RecipeResource::collection($recipes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRecipeRequest $request): RecipeResource
    {
        $recipe = $this->recipeService->store($request->validated());
        
        return new RecipeResource($recipe);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): RecipeResource
    {
        $recipe = $this->recipeService->find($id);
        
        if (!$recipe) {
            abort(404, 'Recipe not found');
        }
        
        return new RecipeResource($recipe);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateRecipeRequest $request, int $id): RecipeResource
    {
        $recipe = $this->recipeService->update($id, $request->validated());
        
        if (!$recipe) {
            abort(404, 'Recipe not found');
        }
        
        return new RecipeResource($recipe);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->recipeService->delete($id);
        
        if (!$deleted) {
            abort(404, 'Recipe not found');
        }
        
        return response()->json(null, 204);
    }
}
