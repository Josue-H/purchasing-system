<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    // Método para mostrar la vista de cliente
    public function shopIndex()
    {
        $productos = Producto::all();
        $cart = session('cart', []);

        return view('shop.index', compact('productos', 'cart'));
    }

    public function index()
    {
        $productos = Producto::all();
        return view('admin.productos.index', compact('productos'));
    }

    public function create()
    {
        return view('admin.productos.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombreProducto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('imagen')) {
            $fileName = time() . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $fileName);
            $validatedData['imagenUrl'] = 'images/' . $fileName;
        }

        $producto = Producto::create($validatedData);

        return redirect()->route('admin.products')->with('success', 'Producto creado exitosamente.');
    }


    public function edit($id)
    {
        $producto = Producto::findOrFail($id);
        return view('admin.productos.edit', compact('producto'));
    }
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombreProducto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'precio' => 'required|numeric',
            'stock' => 'required|integer',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Imagen opcional para mantener la actual
        ]);

        $producto = Producto::findOrFail($id);

        // Verificar si hay una nueva imagen
        if ($request->hasFile('imagen')) {
            // Eliminar la imagen anterior si existe
            if ($producto->imagenUrl && file_exists(public_path($producto->imagenUrl))) {
                unlink(public_path($producto->imagenUrl));
            }

            // Almacenar la nueva imagen
            $fileName = time() . '.' . $request->file('imagen')->getClientOriginalExtension();
            $request->file('imagen')->move(public_path('images'), $fileName);
            $validatedData['imagenUrl'] = 'images/' . $fileName;
        }

        // Actualizar el producto en la base de datos
        $producto->update($validatedData);

        return redirect()->route('admin.products')->with('success', 'Producto actualizado exitosamente.');
    }




    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);

        // Eliminar la imagen del producto si existe en la carpeta
        if ($producto->imagenUrl && file_exists(public_path($producto->imagenUrl))) {
            unlink(public_path($producto->imagenUrl));
        }

        // Eliminar el producto de la base de datos
        $producto->delete();

        return redirect()->route('admin.products')->with('success', 'Producto eliminado con éxito.');
    }

}
