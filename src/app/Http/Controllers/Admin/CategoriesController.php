<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoriesController extends Controller {

    public function __construct() {
        $this->middleware('auth:admin');
    }

    public function index() {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }

    public function show($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories.show', compact('category'));
    }

    public function create() {
        return view('admin.categories.create');
    }

    public function store(Request $request) {

        $rules = [
            'name'              => 'required',
            'slug'              => 'required',
            'color'             => 'required',
            'image'             => 'required'
        ];
        $attributes = [
            'name'              => __('admin.name'),
            'slug'              => __('admin.slug'),
            'color'             => __('admin.color'),
            'image'             => __('admin.image')
        ];
        $this->validate($request, $rules, [], $attributes);

        $user = new Category();
        $user->name = $request->name;
        $user->slug = $request->slug;
        $user->description = $request->description;
        $user->color = $request->color;
        $user->image = $request->image;
        $user->save();
        if ($request->has('create_another'))
            return redirect()->route('categories.create')->with('success', __('lang.success'));

        return redirect()->route('categories.index')->with('success', __('lang.success'));
    }

    public function edit($id) {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    public function update(Request $request, $id) {

        $rules = [
            'name'              => 'required',
            'slug'              => 'required',
            'color'             => 'required',
            'image'             => 'required'
        ];
        $attributes = [
            'name'              => __('admin.name'),
            'slug'              => __('admin.slug'),
            'color'             => __('admin.color'),
            'image'             => __('admin.image')
        ];
        $this->validate($request, $rules, [], $attributes);

        $category = Category::findOrFail($id);
        $category->name = $request->name;
        $category->slug = $request->slug;
        $category->description = $request->description;
        $category->save();

        return redirect()->route('categories.index')->with('success', __('lang.success'));
    }

    public function destroy($id) {
        $category = Category::findOrFail($id);
        $category->delete();
        return redirect()->route('categories.index')->with('success', __('lang.success'));
    }

}
