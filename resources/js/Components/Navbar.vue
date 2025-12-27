<template>
  <nav class="flex justify-between items-center py-6 px-6 md:px-10 max-w-7xl mx-auto">
    
    <div class="flex items-center">
       <span class="text-3xl font-black text-brand-text tracking-tight font-serif cursor-pointer">
          eSponsor
       </span>
    </div>

    <div class="flex items-center gap-4 md:gap-6">
      
      <Link href="/login" class="text-gray-700 font-medium hover:text-black transition text-sm md:text-base">
        Iniciar sesión
      </Link>
      
      <Link href="/register" class="bg-brand-orange hover:bg-brand-orange-hover text-gray-900 font-bold py-2 px-4 md:py-3 md:px-6 rounded-lg shadow-sm transition transform hover:-translate-y-0.5 flex items-center gap-2 text-sm md:text-base">
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="w-4 h-4">
          <path fill-rule="evenodd" d="M9 4.5a.75.75 0 0 1 .721.544l.813 2.846a3.75 3.75 0 0 0 2.576 2.576l2.846.813a.75.75 0 0 1 0 1.442l-2.846.813a3.75 3.75 0 0 0-2.576 2.576l-.813 2.846a.75.75 0 0 1-1.442 0l-.813-2.846a3.75 3.75 0 0 0-2.576-2.576l-2.846-.813a.75.75 0 0 1 0-1.442l2.846-.813A3.75 3.75 0 0 0 7.466 7.89l.813-2.846A.75.75 0 0 1 9 4.5ZM18 1.5a.75.75 0 0 1 .728.568l.258 1.036c.236.94.97 1.674 1.91 1.91l1.036.258a.75.75 0 0 1 0 1.456l-1.036.258c-.94.236-1.674.97-1.91 1.91l-.258 1.036a.75.75 0 0 1-1.456 0l-.258-1.036a2.625 2.625 0 0 0-1.91-1.91l-1.036-.258a.75.75 0 0 1 0-1.456l1.036-.258a2.625 2.625 0 0 0 1.91-1.91l.258-1.036A.75.75 0 0 1 18 1.5ZM16.5 15a.75.75 0 0 1 .712.513l.394 1.183c.15.447.5.799.948.948l1.183.394a.75.75 0 0 1 0 1.422l-1.183.394c-.447.15-.799.5-.948.948l-.394 1.183a.75.75 0 0 1-1.422 0l-.394-1.183a1.875 1.875 0 0 0-.948-.948l-1.183-.394a.75.75 0 0 1 0-1.422l1.183-.394c.447-.15.799-.5.948-.948l.394-1.183A.75.75 0 0 1 16.5 15Z" clip-rule="evenodd" />
        </svg>
        Crear cuenta
      </Link>
    </div>

  </nav>
</template>

<script setup>
//Importamos el componente Link para que funcione la navegación SPA
import { Link } from '@inertiajs/vue3';
</script>