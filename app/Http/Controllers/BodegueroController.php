<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BodegueroController extends Controller
{

    public function bodegueroDashboard()
     {
        return redirect()->route('bodeguero.pedidos.index');
     }

}
