<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Link;
use Illuminate\Http\Request;
use Inertia\Inertia;

class PublicProfileController extends Controller
{
    // 1. Mostrar la página pública
    public function show($username)
    {
        // Buscamos al usuario que tenga ese username. 
        // Si no existe, lanza error 404 automáticamente (firstOrFail)
        $user = User::where('username', $username)
            ->with(['links' => function ($query) {
                $query->orderBy('sort_order'); // Links ordenados
            }])
            ->firstOrFail();

        return Inertia::render('PublicProfile', [
            'creator' => $user, // Pasamos los datos a la vista
            'links' => $user->links,
            'supports' => $user->supports,
        ]);
    }

    // 2. Procesar la donación 
    public function sendSupport(Request $request, $username)
    {
        $user = User::where('username', $username)->firstOrFail();

        // Validamos los datos
        $validated = $request->validate([
            'supporter_name' => 'nullable|string|max:255',
            'message' => 'nullable|string|max:500',
            'amount' => 'required|numeric|min:1|max:100', // Monto obligatorio
        ]);

        // Se guarda el apoyo en la base de datos
        $user->supports()->create([
            'supporter_name' => $validated['supporter_name'] ?? 'Anónimo', // Si no pone nombre, es Anónimo
            'message' => $validated['message'],
            'amount' => $validated['amount'],
        ]);

        // Regresamos con un mensaje de éxito (que mostraremos en el frontend)
        return back()->with('success', '¡Gracias por tu apoyo!');
    }
}
