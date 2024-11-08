<?php

namespace App\Http\Controllers;

use App\Models\detallePedido;
use App\Models\Pedido;
use App\Models\Producto;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $producto = Producto::findOrFail($id);
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['cantidad']++;
        } else {
            $cart[$id] = [
                'nombreProducto' => $producto->nombreProducto,
                'precio' => $producto->precio,
                'imagenUrl' => $producto->imagenUrl,
                'cantidad' => 1,
            ];
        }

        session()->put('cart', $cart);

        // Retornar la respuesta JSON con el contenido del carrito actualizado
        return response()->json([
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'cartCount' => count($cart)
        ]);
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $cart[$id]['cantidad']--;

            if ($cart[$id]['cantidad'] <= 0) {
                unset($cart[$id]);
            }

            session()->put('cart', $cart);
        }

        return response()->json([
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'cartCount' => count($cart)
        ]);
    }

    public function delete($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return response()->json([
            'cart' => $cart,
            'total' => $this->calculateTotal($cart),
            'cartCount' => count($cart)
        ]);
    }

    private function calculateTotal($cart)
    {
        return array_sum(array_map(function ($item) {
            return $item['precio'] * $item['cantidad'];
        }, $cart));
    }

    public function checkout()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        return view('cart.checkout', compact('cart', 'total'));
    }

    public function getCart()
    {
        $cart = session()->get('cart', []);
        $total = $this->calculateTotal($cart);

        return response()->json(['cart' => $cart, 'total' => $total]);
    }

    public function confirmPurchase(Request $request)
    {

        // Verificar si el carrito no está vacío
        $cart = session('cart');
        if (!$cart || count($cart) === 0) {
            return redirect()->back()->with('error', 'El carrito está vacío.');
        }

        // Validar los datos recibidos
        $validated = $request->validate([
            'nombreEntrega' => 'required|string|max:255',
            'direccionEntrega' => 'required|string|max:255',
            'emailEntrega' => 'required|email',
            'telefonoEntrega' => 'required|string|max:20',
        ]);

        $idCliente =  Auth::check() && Auth::user()->cliente ? Auth::user()->cliente->idCliente :
                    (Auth::check() && Auth::user()->administrador ? 1 :
                    (Auth::check() && Auth::user()->bodeguero ? 1 : 1)); // Si el usuario está autenticado, usar su id; si no, el id genérico de invitado



        // Crear el pedido
        $pedido = Pedido::create([
            'idCliente' => $idCliente,
            'nombreEntrega' => $validated['nombreEntrega'],
            'direccionEntrega' => $validated['direccionEntrega'],
            'emailEntrega' => $validated['emailEntrega'],
            'fechaPedido' => now(),
            'estadoPedido' => 'Pendiente',
        ]);

        // Agregar los detalles del pedido para cada producto en el carrito
        foreach ($cart as $id => $producto) {
            detallePedido::create([
                'idPedido' => $pedido->idPedido,
                'idProducto' => $id,
                'cantidad' => $producto['cantidad'],
                'precioUnitario' => $producto['precio'],
                'descuentoAplicado' => 0, // Puedes agregar lógica para el descuento si es necesario
                'precioFinal' => $producto['precio'] * $producto['cantidad'],
            ]);

            // Actualizar el stock del producto
            $product = Producto::find($id);
            if ($product) {
                $product->stock -= $producto['cantidad'];
                $product->save();
            }
        }

        // Limpiar el carrito de la sesión después de confirmar el pedido
        session()->forget('cart');

        return redirect()->route('shop.index')->with('success', 'Compra confirmada con éxito.');
    }
}
