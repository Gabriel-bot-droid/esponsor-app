<template>
  <div class="flex flex-col items-center text-center px-4 mt-8 md:mt-12 pb-24 max-w-6xl mx-auto font-sans">
    
    <div class="bg-white py-2 px-6 rounded-full shadow-sm text-gray-600 font-medium text-sm mb-8 flex items-center gap-2 border border-orange-100">
      <span class="text-yellow-500 text-lg">★</span> 
      La plataforma #1 para creadores hispanohablantes
    </div>

    <h1 class="text-5xl md:text-7xl font-serif font-black text-brand-text leading-[1.1] mb-6 tracking-tight">
      Recibe apoyo de <br class="hidden md:block" />
      quienes 
      <span class="relative inline-block px-1 mx-1">
         <span class="relative z-10 text-brand-orange">aman</span>
         <span class="absolute bottom-2 left-0 w-full h-4 md:h-6 bg-orange-200/50 -z-0 rounded-sm"></span>
      </span> 
      tu <br class="hidden md:block" />
      contenido
    </h1>

    <p class="text-lg md:text-xl text-gray-600 max-w-2xl mb-10 leading-relaxed font-light">
      Crea tu página personalizada, compártela con tu audiencia y permite que te inviten un café. 
      <strong class="text-gray-900 font-bold block sm:inline mt-1 sm:mt-0">Sin complicaciones, sin cuotas mensuales.</strong>
    </p>

    <div class="flex flex-col sm:flex-row gap-4 w-full justify-center mb-16">
      <button class="bg-brand-orange hover:bg-brand-orange-hover text-gray-900 text-lg font-bold py-4 px-10 rounded-full shadow-lg transition transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
        Comenzar gratis 
        <span>→</span>
      </button>

      <button class="bg-white hover:bg-orange-50 text-gray-800 text-lg font-bold py-4 px-8 rounded-full shadow border border-gray-100 transition">
        Ver cómo funciona
      </button>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8 md:gap-16 items-center border-t border-gray-900/5 pt-8 w-full max-w-4xl">
      <div>
        <h3 class="text-4xl font-serif font-black text-brand-text">5,000+</h3>
        <p class="text-gray-500 font-medium">Creadores activos</p>
      </div>
      <div class="md:border-x md:border-gray-900/5 md:px-10">
        <h3 class="text-4xl font-serif font-black text-brand-text">$250K+</h3>
        <p class="text-gray-500 font-medium">Cafés enviados</p>
      </div>
      <div>
        <h3 class="text-4xl font-serif font-black text-brand-text flex items-center justify-center gap-1">
          4.9 <span class="text-brand-text text-2xl">★</span>
        </h3>
        <p class="text-gray-500 font-medium">Calificación</p>
      </div>
    </div>

  </div>
</template>