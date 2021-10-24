<?php

namespace App\Http\Controllers;

use App\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * @codeCoverageIgnore
     */
    public function __construct()
    {
        $this->middleware(['auth', 'admin']);
    }

    /**
     * @codeCoverageIgnore
     */
    public function index()
    {

        $categories = Category::all();
        return view('categories.index',['categories'=>$categories]);
    }

    /**
     * @codeCoverageIgnore
     */
    public function store(Request $request)
    {
        $validatedData = $this->validate($request, [
            'name'      => 'required|min:3|max:255|string',
            'parent_id' => 'sometimes|nullable|numeric'
        ]);

        Category::create($validatedData);

        return redirect()->route('categories')->withSuccess('You have successfully created a Category!');
    }

    /**
     * @codeCoverageIgnore
     */
    public function update(Request $request, $category)
    {
        $validatedData = $this->validate($request, [
            'name'  => 'required|min:3|max:255|string'
        ]);
        $category = Category::find($category);
        $category->update($validatedData);

        return redirect()->route('categories')->withSuccess('You have successfully updated a Category!');
    }

    /**
     * @codeCoverageIgnore
     */
    public function destroy($category)
    {
        $category = Category::find($category);
        $category->delete();

        return redirect()->route('categories')->withSuccess('You have successfully deleted a Category!');
    }
}
