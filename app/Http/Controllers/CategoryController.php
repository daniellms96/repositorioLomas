<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{
    // Muestra todas las categorías.
    public function index()
    {
        // Obtiene todas las categorías.
        $categories = Category::all(); 
        
        // Retorna la vista con las categorías.
        return view('categories.index', compact('categories'));
    }

    // Muestra el formulario para crear una nueva categoría.
    public function create()
    {
        // Retorna la vista del formulario de creación.
        return view('categories.create');
    }

    // Almacena una nueva categoría en la base de datos.
    public function store(Request $request)
    {
        // Valida los datos de entrada.
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        // Crea una nueva categoría.
        Category::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'description' => $request->description,
        ]);

        // Redirige con mensaje de éxito.
        return redirect()->route('categories.index')->with('success', 'Categoría creada exitosamente.');
    }

    // Muestra una categoría específica.
    public function show(Category $category)
    {
        // Retorna la vista con la categoría.
        return view('categories.show', compact('category'));
    }

    // Muestra el formulario para editar una categoría.
    public function edit(Category $category)
    {
        // Retorna la vista de edición con la categoría.
        return view('categories.edit', compact('category'));
    }

    // Actualiza una categoría existente.
    public function update(Request $request, Category $category)
    {
        // Valida los datos, excluyendo el nombre actual para la unicidad.
        $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Actualiza la categoría.
        $category->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name), 
            'description' => $request->description,
        ]);

        // Redirige con mensaje de éxito.
        return redirect()->route('categories.index')->with('success', 'Categoría actualizada exitosamente.');
    }

    // Elimina una categoría.
    public function destroy(Category $category)
    {
        // Elimina la categoría.
        $category->delete();

        // Redirige con mensaje de éxito.
        return redirect()->route('categories.index')->with('success', 'Categoría eliminada exitosamente.');
    }
}