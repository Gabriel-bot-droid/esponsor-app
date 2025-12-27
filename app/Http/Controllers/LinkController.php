<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    // Guardar un nuevo link
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url', // Debe ser una URL válida (https://...)
        ]);

        // Crear el link asociado al usuario actual
        // Gracias a la relación 'links()' que definimos en el Modelo User
        $request->user()->links()->create($validated);

        return back(); // Regresar al dashboard
    }

    // Actualizar un link existente
    public function update(Request $request, Link $link)
    {
        // Seguridad: Verificar que el link pertenece al usuario que intenta editarlo
        if ($link->user_id !== $request->user()->id) {
            abort(403);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $link->update($validated);

        return back();
    }

    // Borrar un link
    public function destroy(Link $link)
    {
        // Seguridad: Verificar dueño
        if ($link->user_id !== request()->user()->id) {
            abort(403);
        }

        $link->delete();

        return back();
    }
}