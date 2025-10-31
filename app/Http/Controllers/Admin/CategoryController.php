<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function uniqueSlug($text, $model, $id = 0): string
    {
        $slug = Str::slug($text);
        $count = 1;
        while (true) {
            if ($model == "categories") {
                if ($id != 0) {

                    if (!category::where('slug', $slug)->where('id', '!=', $id)->first()) {
                        break;
                    }
                } else {
                    if (!category::where('slug', $slug)->first()) {
                        break;
                    }
                }
            }
            $slug = $slug . '-' . 0 . $count;
            $count++;
        }
        return $slug;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $categories = category::all();
        return view('Admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('Admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        $data = $request->validate(['name' => ['required', 'string', 'max:225']]);
        $categories = new category();
        $categories->name = $data['name'];
        $categories->slug = $this->uniqueSlug($data['name'], 'categories');

        $categories->save();
        // return redirect()->route('categories');
        return to_route('admin.categories.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $slug)
    {
        //
        $categories = category::where('slug', $slug)->firstOrFail();
        return view('Admin.categories.edit', compact('categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        $categories = category::findOrFail($id);
        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
        ]);
        $categories->name = $data['name'];
        $categories->slug = $this->uniqueSlug($data['name'], 'categori$categories', $id = $categories->id);
        $categories->update();
        return to_route('admin.categories.index')->with('message', 'catégorie modifier avec succées !');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
