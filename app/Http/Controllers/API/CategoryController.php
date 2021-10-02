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
        $categories = Category::all()->toArray();

        return $this->return($categories);
    }

    public function store(CategoryRequest $request): JsonResponse
    {
        Category::create($request->toArray());

        return $this->return(['success' => 'You have successfully created a Category!'], Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->return(['error' => 'This category does not exist!'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->update($request->toArray());

        return $this->return(['success' => 'You have successfully edited a Category!'], Response::HTTP_ACCEPTED);
    }

    public function destroy($category): JsonResponse
    {
        $category = Category::find($category);
        if (!$category) {
            return $this->return(['errors' => 'This category does not exist'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        $category->delete();

        return $this->return(['success' => 'You have successfully removed a Category!']);
    }

    public function show($category): JsonResponse
    {
        $category = Category::find($category);
        if (!$category) {
            return $this->return(['errors' => 'This category does not exist'], Response::HTTP_UNPROCESSABLE_ENTITY);
        }

        return $this->return($category->toArray());
    }
}
