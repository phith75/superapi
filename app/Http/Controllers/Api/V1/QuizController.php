<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Quiz\StoreQuizRequest;
use App\Http\Requests\Quiz\UpdateQuizRequest;
use App\Http\Resources\Api\QuizResource;
use App\Services\QuizService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class QuizController extends Controller
{
    public function __construct(
        protected QuizService $quizService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): AnonymousResourceCollection
    {
        $filters = $request->only(['difficulty_level', 'active']);
        
        $quizzes = $this->quizService->list($filters);
        
        return QuizResource::collection($quizzes);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request): QuizResource
    {
        $quiz = $this->quizService->store($request->validated());
        
        return new QuizResource($quiz);
    }

    /**
     * Display the specified resource.
     */
    public function show(int $id): QuizResource
    {
        $quiz = $this->quizService->find($id);
        
        if (!$quiz) {
            abort(404, 'Quiz not found');
        }
        
        return new QuizResource($quiz);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, int $id): QuizResource
    {
        $quiz = $this->quizService->update($id, $request->validated());
        
        if (!$quiz) {
            abort(404, 'Quiz not found');
        }
        
        return new QuizResource($quiz);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(int $id): JsonResponse
    {
        $deleted = $this->quizService->delete($id);
        
        if (!$deleted) {
            abort(404, 'Quiz not found');
        }
        
        return response()->json(null, 204);
    }
}
