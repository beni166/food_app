<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProduitRequest;
use App\Models\category;
use App\Models\products;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class ProductController extends Controller
{
    //  use UniqueSlugTrait;

    public function uniqueSlug($text, $model, $id = 0): string
    {
        $slug = Str::slug($text);
        $count = 1;
        while (true) {
            if ($model == "category") {
                if ($id != 0) {

                    if (!category::where('slug', $slug)->where('id', '!=', $id)->first()) {
                        break;
                    }
                } else {
                    if (!category::where('slug', $slug)->first()) {
                        break;
                    }
                }
            } else {
                if ($id != 0) {

                    if (!products::where('slug', $slug)->where('id', '!=', $id)->first()) {
                        break;
                    }
                } else {
                    if (!products::where('slug', $slug)->first()) {
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
        $produits = products::orderByDesc('created_at')->paginate(2);
        return view('Admin.produits.index', compact('produits'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        $categories = category::orderByDesc('created_at')->get();
        return view('Admin.produits.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProduitRequest $request)
    {
        //
        $data = $request->validated();
        $produits = new products();
        $produits->name = $data['name'];
        $produits->prix = $data['prix'];
        $produits->description = $data['description'];
        $produits->category_id = $data['category'] ?? 1;
        $produits->slug = $this->uniqueSlug($data['name'], 'produits');
        //upload de l'image
        if (isset($data['image'])) {
            $file = $data['image'];
            $fileName = "media_" . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move("assets/produits/", $fileName);
            $produits->image = "assets/produits/" . $fileName;
        }
        $produits->image_url = $produits->image
            ? url('assets/produits/' . $produits->image)
            : null;
        $produits->save();
        return to_route('admin.Produits.index')->with('message', 'Produits ajouter avec succès');
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
        $produits = products::where('slug', $slug)->firstOrFail();
        $categories = Category::whereNot('id')->orderByDesc('created_at')->get();
        return view('Admin.produits.edit', compact('categories', 'produits'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProduitRequest $request, string $id)
    {
        //
        $data = $request->validated();
        $produits =  products::findOrFail($id);
        $produits->name = $data['name'];
        $produits->prix = $data['prix'];
        $produits->description = $data['description'];
        $produits->category_id = $data['category_id'] ?? 1;
        $produits->slug = $this->uniqueSlug($data['name'], 'produits');
        //upload de l'image
        if (isset($data['image'])) {
            if (file_exists($produits->image)) {
                unlink($produits->image);
            }
            $file = $data['image'];
            $fileName = "media_" . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move("assets/produits/", $fileName);
            $produits->image = "assets/produits/" . $fileName;
        }
        $produits->update();
        return to_route('admin.Produits.index')->with('message', 'Produits Modifier avec succès');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
        $produits = products::findOrFail($id);
        if (file_exists($produits->image)) {
            unlink($produits->image);
        }
        $produits->delete();
        return to_route('admin.Produits.index')->with('message', 'produit supprimer avec succées');
    }
}
