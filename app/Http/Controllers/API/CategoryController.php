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
        $category = Category::create($request->toArray());

        return $this->return(compact('category'), Response::HTTP_CREATED);
    }

    public function update(CategoryRequest $request, $id): JsonResponse
    {
        $category = Category::find($id);
        if (!$category) {
            return $this->return(['error' => 'This category does not exist!'], Response::HTTP_BAD_REQUEST);
        }

        $category->update($request->toArray());

        return $this->return(compact('category'), Response::HTTP_ACCEPTED);
    }

    public function destroy($category): JsonResponse
    {
        $category = Category::find($category);
        if (!$category) {
            return $this->return(['errors' => 'This category does not exist'], Response::HTTP_NOT_FOUND);
        }

        $category->delete();

        return $this->return(['success' => 'You have successfully removed a Category!'], Response::HTTP_NO_CONTENT);
    }

    public function show($category): JsonResponse
    {
        $category = Category::find($category);
        if (!$category) {
            return $this->return(['errors' => 'This category does not exist'], Response::HTTP_BAD_REQUEST);
        }

        return $this->return($category->toArray());
    }
}
