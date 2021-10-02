<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends BaseController
{
    public function index(): JsonResponse
    {
        $categories = Category::all();

        return $this->return($categories);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        Category::create($request);

        return $this->return(['success' => 'You have successfully created a Category!'], Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, Category $category): JsonResponse
    {
        $category = Category::find($category);
        $category->update($request);

        return $this->return(['success' => 'You have successfully edited a Category!'], Response::HTTP_ACCEPTED);
    }

    public function destroy($category): JsonResponse
    {
        $category = Category::find($category);
        $category->delete();

        return $this->return(['success' => 'You have successfully removed a Category!']);
    }
}
