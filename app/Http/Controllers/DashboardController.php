<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Inertia\Inertia; // Importamos Inertia para conectar con Vue
use Illuminate\Support\Facades\Storage; // Para manejar la subida de fotos
use Illuminate\Validation\Rule; // Para reglas de validación avanzadas

class DashboardController extends Controller
{
    // Muestra la vista del Dashboard
    public function index()
    {
        /** @var \App\Models\User $user */
        $user = auth()->user(); // Obtenemos al usuario logueado
        
        // Cargamos sus links ordenados por el campo 'sort_order'
        // (Esto servirá cuando agreguemos la función de crear links)
        $user->load([
            'links' => function ($query) {
                $query->orderBy('sort_order');
            },
            'supports' => function ($query) {
                $query->latest(); // Ordenar por fecha descendente
            }
        ]);

        // Renderizamos la vista "Dashboard" de Vue
        // y le entregamos los datos del usuario y sus links
        return Inertia::render('Dashboard', [
            'user' => $user,
            'links' => $user->links,
            'supports' => $user->supports,
        ]);
    }

    // Procesa el formulario de "Editar Perfil"
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        // 1. Validamos los datos recibidos
        $validated = $request->validate([
            // Username: requerido, letras/guiones, único en la tabla users (excepto para mí mismo)
            'username' => [
                'required', 
                'alpha_dash', 
                Rule::unique('users')->ignore($user->id)
            ],
            'public_name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:500',
            'avatar' => 'nullable|image|max:1024', // Imagen máx 1MB
        ]);

        // 2. Actualizamos los textos
        $user->username = $validated['username'];
        $user->public_name = $validated['public_name'];
        $user->bio = $validated['bio'];

        // 3. Si subieron una nueva foto...
        if ($request->hasFile('avatar')) {
            // Borrar foto vieja si existe para no llenar el disco
            if ($user->avatar) {
                Storage::disk('public')->delete($user->avatar);
            }
            // Guardar nueva en carpeta 'avatars' dentro de storage/app/public
            $path = $request->file('avatar')->store('avatars', 'public');
            $user->avatar = $path;
        }

        $user->save(); // Guardar cambios en BD

        // Redirigimos de vuelta a la misma página
        return back();
    }
}