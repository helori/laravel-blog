<?php

namespace Helori\LaravelBlog\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Routing\Controller;
use Helori\LaravelBlog\Models\BlogCategory as Category;
use Helori\LaravelBlog\Requests\BlogCategoryCreate as CategoryCreateRequest;
use Helori\LaravelBlog\Requests\BlogCategoryUpdate as CategoryUpdateRequest;


class BlogCategoriesController extends Controller
{
    public function read(Request $request, $id = null)
    {
        $query = Category::with(['articles' => function($query){
            $query->select('id');
        }]);

        if(!is_null($id)){
            return $query->findOrFail($id);
        }else{
            return $query->orderBy('title', 'asc')->get();
        }
    }

    public function delete(Request $request, $id)
    {
        Category::destroy($id);
    }

    public function create(CategoryCreateRequest $request)
    {
        return Category::create($request->all());
    }

    public function update(CategoryUpdateRequest $request, $id)
    {
        $item = Category::findOrFail($id);
        $item->update($request->except(['articles']));
        $item->save();
        return $item;
    }
}
