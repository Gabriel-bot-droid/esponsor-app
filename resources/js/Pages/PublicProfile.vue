<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import { ref, watch } from 'vue';

// Si tienes sweetalert2 instalado:
// import Swal from 'sweetalert2';

const props = defineProps({
    creator: { type: Object, default: () => ({}) },
    links: { type: Array, default: () => [] },
    supports: { type: Array, default: () => [] },
});

// REACTIVIDAD DEL MURO
const currentSupports = ref([...props.supports]);

watch(() => props.supports, (newSupports) => {
    currentSupports.value = [...newSupports];
});

// LÓGICA DE DINERO
const presetAmounts = [5, 10, 25]; 

const form = useForm({
    amount: 5, // Monto inicial
    supporter_name: '',
    message: '',
    is_anonymous: false
});

// Función para los botones rápidos
const selectAmount = (value) => {
    form.amount = value;
};

//ENVIAR DONACIÓN 
const submitSupport = () => {
    if (!props.creator?.username) return;
    
    // Validación básica para no enviar 0 o negativos
    if (form.amount <= 0) {
        alert("El monto debe ser mayor a 0");
        return;
    }

    form.post(route('public.support', props.creator.username), {
        preserveScroll: true,
        onSuccess: () => {
            form.reset(); 

            form.amount = 5; 

        },
    });
};

const avatarUrl = props.creator?.avatar 
    ? `/storage/${props.creator.avatar}` 
    : `https://ui-avatars.com/api/?name=${props.creator?.public_name || 'User'}&background=FFEDD5&color=C2410C`;

</script>

<template>
    <div v-if="creator" class="min-h-screen bg-[#fffbf0] font-sans py-10 px-4">
        <Head :title="`${creator.public_name || 'Perfil'} en eSponsor`" />
        
        <div class="max-w-5xl mx-auto grid grid-cols-1 md:grid-cols-12 gap-8">
            
            <div class="md:col-span-5 space-y-6">
                <div class="bg-white rounded-3xl p-8 shadow-sm border border-orange-100 text-center relative overflow-hidden">
                    <div class="absolute top-0 left-0 w-full h-24 bg-gradient-to-b from-orange-50 to-white -z-0"></div>
                    <div class="relative z-10">
                        <div class="w-32 h-32 mx-auto mb-4 rounded-full p-1 bg-white ring-4 ring-orange-100 shadow-lg">
                            <img :src="avatarUrl" class="w-full h-full object-cover rounded-full" />
                        </div>
                        <h1 class="text-3xl font-serif font-black text-gray-900 mb-2 tracking-tight">
                            {{ creator.public_name || 'Usuario' }}
                        </h1>
                        <p class="text-orange-600 font-medium text-sm bg-orange-50 inline-block px-3 py-1 rounded-full mb-4">
                            @{{ creator.username }}
                        </p>
                        <p class="text-gray-600 text-base leading-relaxed mb-6 font-light">
                            {{ creator.bio || "Creando contenido increíble." }}
                        </p>
                        
                        <div class="flex justify-center items-center gap-3 text-xs font-bold text-gray-400 uppercase tracking-widest border-t border-gray-100 pt-4">
                            <div class="flex flex-col">
                                <span class="text-lg text-gray-900 font-serif">{{ currentSupports.length }}</span>
                                <span>Donaciones</span>
                            </div>
                            <div class="h-8 w-px bg-gray-200"></div>
                            <div class="flex flex-col">
                                <span class="text-lg text-gray-900 font-serif">{{ links?.length || 0 }}</span>
                                <span>Links</span>
                            </div>
                        </div>
                    </div>
                </div>

                <div v-if="links && links.length > 0" class="space-y-3">
                    <a v-for="link in links" :key="link.id" :href="link.url" target="_blank" class="block w-full bg-white hover:bg-orange-50 border border-orange-100 hover:border-brand-orange text-gray-800 font-bold py-4 px-6 rounded-2xl shadow-sm transition-all transform hover:-translate-y-0.5 text-center flex justify-between items-center group">
                        <span class="pl-2">{{ link.title }}</span>
                        <svg class="w-5 h-5 text-gray-300 group-hover:text-brand-orange transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                    </a>
                </div>
            </div>

            <div class="md:col-span-7 space-y-6">
                <div class="bg-white rounded-3xl p-8 shadow-xl border border-orange-100 relative overflow-hidden">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="bg-brand-orange text-white p-2 rounded-lg shadow-md">
                            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" /></svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-900 font-serif">Realizar Donación</h2>
                    </div>

                    <form @submit.prevent="submitSupport">
                        <div class="bg-orange-50/60 p-5 rounded-2xl mb-6 border border-orange-100/50">
                            
                            <div class="flex gap-3 mb-4">
                                <button 
                                    v-for="amount in presetAmounts" 
                                    :key="amount"
                                    type="button" 
                                    @click="selectAmount(amount)" 
                                    :class="form.amount === amount ? 'bg-brand-orange text-gray-900 ring-2 ring-brand-orange ring-offset-2' : 'bg-white text-gray-500 hover:bg-orange-100 border border-orange-100'" 
                                    class="flex-1 py-2 rounded-xl font-black shadow-sm transition-all text-lg"
                                >
                                    ${{ amount }}
                                </button>
                            </div>

                            <div class="relative">
                                <span class="absolute left-4 top-1/2 -translate-y-1/2 text-lg font-bold text-gray-500">$</span>
                                <input 
                                    type="number" 
                                    v-model="form.amount" 
                                    min="1"
                                    step="1"
                                    class="w-full border-gray-200 rounded-xl pl-8 pr-4 py-3 focus:ring-brand-orange focus:border-brand-orange text-left font-bold text-gray-900 text-lg bg-white"
                                    placeholder="Ingresa otro monto..."
                                >
                            </div>
                        </div>

                        <div class="space-y-4 mb-6">
                            <input 
                                v-model="form.supporter_name" 
                                type="text" 
                                placeholder="Tu nombre (opcional)" 
                                class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-brand-orange focus:border-brand-orange transition"
                            >
                            <textarea 
                                v-model="form.message" 
                                rows="3" 
                                placeholder="Deja un mensaje de apoyo..." 
                                class="w-full bg-gray-50 border-gray-200 rounded-xl px-4 py-3 focus:bg-white focus:ring-2 focus:ring-brand-orange focus:border-brand-orange transition"
                            ></textarea>
                        </div>

                        <button 
                            type="submit" 
                            :disabled="form.processing"
                            class="w-full bg-gray-900 hover:bg-black text-white font-bold py-4 rounded-xl shadow-lg hover:shadow-xl transition-all transform hover:-translate-y-0.5 disabled:opacity-50 flex justify-center px-6 items-center group"
                        >
                            <span class="text-lg">Donar ${{ form.amount || 0 }}</span>
                        </button>
                    </form>
                </div>

                <div class="bg-white rounded-3xl p-8 shadow-sm border border-orange-100">
                    <h3 class="font-bold text-gray-900 mb-6 font-serif text-lg border-b border-gray-100 pb-4">
                        Muro de agradecimiento
                    </h3>
                    
                    <div v-if="currentSupports.length > 0" class="space-y-6">
                        <transition-group 
                            enter-active-class="transition duration-500 ease-out" 
                            enter-from-class="opacity-0 -translate-y-4" 
                            enter-to-class="opacity-100 translate-y-0"
                        >
                            <div v-for="support in currentSupports" :key="support.id" class="flex gap-4">
                                <div class="flex-shrink-0 w-12 h-12 bg-green-50 rounded-full flex items-center justify-center text-xl shadow-inner border border-green-100 text-green-600">
                                    $
                                </div>
                                <div class="flex-1">
                                    <div class="flex justify-between items-start">
                                        <span class="font-bold text-gray-900">{{ support.supporter_name || "Alguien anónimo" }}</span>
                                        <span class="text-xs text-gray-400 font-medium bg-gray-50 px-2 py-1 rounded">
                                            {{ new Date(support.created_at).toLocaleDateString() }}
                                        </span>
                                    </div>
                                    <p class="text-xs text-brand-orange font-bold mt-0.5 mb-2">
                                        Donó ${{ support.amount }}
                                    </p>
                                    <div v-if="support.message" class="bg-gray-50 p-3 rounded-xl rounded-tl-none text-gray-600 text-sm italic inline-block border border-gray-100">
                                        "{{ support.message }}"
                                    </div>
                                </div>
                            </div>
                        </transition-group>
                    </div>

                    <div v-else class="text-center py-10 bg-gray-50 rounded-2xl border-2 border-dashed border-gray-200">
                        <div class="text-4xl mb-2">✨</div>
                        <p class="text-gray-500 font-medium">Aún no hay donaciones.</p>
                        <p class="text-gray-400 text-sm">¡Sé la primera persona en apoyar!</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-16 mb-6">
            <a href="/" class="inline-flex items-center gap-2 text-gray-400 hover:text-brand-orange transition font-serif font-bold opacity-60 hover:opacity-100">
                <span class="text-sm">Potenciado por</span>
                <span class="text-lg">eSponsor</span>
            </a>
        </div>
    </div>
    <div v-else class="min-h-screen flex items-center justify-center bg-[#fffbf0]">
        <p class="text-gray-500">Cargando perfil...</p>
    </div>
</template>