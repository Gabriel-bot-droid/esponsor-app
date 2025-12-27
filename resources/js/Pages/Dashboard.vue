<script setup>
import AuthenticatedLayout from "@/Layouts/AuthenticatedLayout.vue";
import { Head, useForm, router } from "@inertiajs/vue3"; // Importamos router para el borrar
import { ref } from "vue";
import QrcodeVue from "qrcode.vue";
import Swal from "sweetalert2";

// 1. RECIBIR DATOS (PROPS)
const props = defineProps({
    user: Object,
    links: Array, // Links que vienen de la base de datos
    supports: Array, // Donaciones recibidas
});

// --- LÓGICA DEL PERFIL ---
const profileForm = useForm({
    username: props.user.username || "",
    public_name: props.user.public_name || "",
    bio: props.user.bio || "",
    avatar: null,
});

const avatarPreview = ref(
    props.user.avatar ? `/storage/${props.user.avatar}` : null
);

const handleFileChange = (e) => {
    const file = e.target.files[0];
    if (file) {
        profileForm.avatar = file;
        avatarPreview.value = URL.createObjectURL(file);
    }
};

const submitProfile = () => {
    profileForm.post(route("dashboard.profile"), {
        preserveScroll: true,
                onSuccess: () => {
            Swal.fire({
                title: '¡Perfil Actualizado!',
                text: 'Tus cambios se han guardado con éxito.',
                icon: 'success',
                timer: 2000,
                timerProgressBar: true,
                showConfirmButton: false,
                toast: true,
                position: 'top-end',
             });
        },
    });
 };

// --- LÓGICA DE LOS LINKS ---
const linkForm = useForm({
    title: "",
    url: "",
});

const submitLink = () => {
    linkForm.post(route("links.store"), {
        preserveScroll: true,
        onSuccess: () => linkForm.reset(), // Limpia los inputs al guardar
    });
};

const deleteLink = (link) => {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "Esta acción no se puede deshacer.",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#e53e3e', 
        cancelButtonColor: '#718096', 
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar',
        reverseButtons: true
    }).then((result) => {
        if (result.isConfirmed) {
            router.delete(route("links.destroy", link.id), {
                preserveScroll: true,
                onSuccess: () => {
                    Swal.fire({
                        title: '¡Eliminado!',
                        text: 'El enlace se ha borrado.',
                        icon: 'success',
                        timer: 2000,
                        timerProgressBar: true,
                        showConfirmButton: false,
                        toast: true,
                        position: 'top-end',
                    });
                }
            });
        }
    });
};

// Estado para editar un link existente
const editingLink = ref(null); // Guarda el ID del link que se está editando
const editForm = useForm({ title: "", url: "" });

const startEdit = (link) => {
    editingLink.value = link.id;
    editForm.title = link.title;
    editForm.url = link.url;
};

const updateLink = (link) => {
    editForm.put(route("links.update", link.id), {
        preserveScroll: true,
        onSuccess: () => (editingLink.value = null), // Cierra el modo edición
    });
};

const isRecent = (date) => {
    const supportDate = new Date(date);
    const now = new Date();
    const diffHours = (now - supportDate) / (1000 * 60 * 60);
    return diffHours < 24;
};

const totalAmount = props.supports.reduce((sum, s) => sum + parseFloat(s.amount), 0).toFixed(2);

</script>

<template>
    <Head title="Panel de Creador" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-serif font-bold text-3xl text-gray-900 leading-tight">
                Hola, {{ $page.props.auth.user.name }} 👋
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">
                
                <div class="bg-brand-orange text-gray-900 overflow-hidden shadow-lg sm:rounded-2xl relative">
                    <div class="p-8 relative z-10 flex flex-col md:flex-row justify-between items-center gap-6">
                        <div>
                            <h3 class="font-bold text-xl mb-2 font-serif">Tu página está activa 🚀</h3>
                            <p class="text-gray-900/80">Comparte este enlace para recibir cafés.</p>
                            
                            <div class="mt-4 flex items-center gap-2 bg-white/30 p-2 rounded-lg border border-black/5">
                                <span class="text-sm font-mono font-semibold px-2">
                                    esponsor.com/@{{ user.username || 'tu-usuario' }}
                                </span>
                                <a :href="route('public.profile', user.username)" target="_blank" class="bg-white text-gray-900 px-3 py-1 rounded text-sm font-bold hover:bg-gray-50 transition shadow-sm">
                                    Ver página 
                                </a>
                            </div>
                        </div>
                        
                        <div class="bg-white p-2 rounded-lg shadow-sm hidden md:block opacity-90">
                            <QrcodeVue :value="route('public.profile', user.username)" :size="80" level="L" />
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-orange-100 p-6">
                        <div class="text-gray-500 text-sm font-medium mb-1 uppercase tracking-wider">Total Recibido</div>
                        <div class="text-4xl font-serif font-black text-gray-900">${{ totalAmount }}</div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-orange-100 p-6">
                        <div class="text-gray-500 text-sm font-medium mb-1 uppercase tracking-wider">Supporters</div>
                        <div class="text-4xl font-serif font-black text-gray-900">{{ supports.length }}</div>
                    </div>

                    <div class="bg-white overflow-hidden shadow-sm sm:rounded-2xl border border-orange-100 p-6">
                        <div class="text-gray-500 text-sm font-medium mb-1 uppercase tracking-wider">Enlaces Activos</div>
                        <div class="text-4xl font-serif font-black text-gray-900">{{ links.length }}</div>
                    </div>
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <div class="lg:col-span-1 space-y-8">
                        <div class="bg-white shadow-sm border border-orange-100 sm:rounded-2xl overflow-hidden">
                            <div class="p-6">
                                <h3 class="font-serif font-bold text-xl text-gray-900 mb-1">Tu Perfil</h3>
                                <p class="text-sm text-gray-500 mb-6">Información visible en tu página pública.</p>

                                <form @submit.prevent="submitProfile" class="space-y-5">
                                    <div class="flex flex-col items-center pb-6 border-b border-orange-50">
                                        <div class="relative group cursor-pointer w-24 h-24">
                                            <div class="w-full h-full rounded-full overflow-hidden bg-brand-orange/10 ring-4 ring-white shadow-lg relative">
                                                <img v-if="avatarPreview" :src="avatarPreview" class="w-full h-full object-cover" />
                                                <div v-else class="w-full h-full flex items-center justify-center text-brand-orange">
                                                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                                </div>
                                                <div class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                                                </div>
                                            </div>
                                            <input type="file" @change="handleFileChange" accept="image/*" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" />
                                        </div>
                                        <p class="text-xs text-gray-400 mt-2">Click para cambiar foto</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Username</label>
                                        <div class="flex mt-1 rounded-md shadow-sm">
                                            <span class="inline-flex items-center px-3 rounded-l-lg border border-r-0 border-gray-300 bg-gray-50 text-gray-500 sm:text-sm">@</span>
                                            <input v-model="profileForm.username" type="text" class="flex-1 block w-full rounded-none rounded-r-lg border-gray-300 focus:border-brand-orange focus:ring-brand-orange sm:text-sm" />
                                        </div>
                                        <p v-if="profileForm.errors.username" class="text-red-500 text-xs mt-1">{{ profileForm.errors.username }}</p>
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Nombre Público</label>
                                        <input v-model="profileForm.public_name" type="text" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-orange focus:ring-brand-orange sm:text-sm" />
                                    </div>

                                    <div>
                                        <label class="block text-sm font-medium text-gray-700">Biografía</label>
                                        <textarea v-model="profileForm.bio" rows="3" class="mt-1 block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-orange focus:ring-brand-orange sm:text-sm"></textarea>
                                    </div>

                                    <button type="submit" :disabled="profileForm.processing" class="w-full py-2.5 px-4 rounded-xl shadow-sm text-sm font-bold text-gray-900 bg-brand-orange hover:bg-brand-orange-hover transition-colors disabled:opacity-50">
                                        {{ profileForm.processing ? "Guardando..." : "Guardar Cambios" }}
                                    </button>
                                </form>

                                
                            </div>
                        </div>
                    </div>

                    <div class="lg:col-span-2 space-y-8">
                        
                        <div class="bg-white shadow-sm border border-orange-100 sm:rounded-2xl overflow-hidden">
                            <div class="p-6">
                                <header class="mb-6 flex justify-between items-end">
                                    <div>
                                        <h3 class="font-serif font-bold text-xl text-gray-900">Mis Enlaces</h3>
                                        <p class="text-sm text-gray-500">Botones que aparecen en tu perfil.</p>
                                    </div>
                                    <span class="bg-orange-100 text-orange-800 text-xs font-bold px-3 py-1 rounded-full">{{ links.length }} Links</span>
                                </header>

                                <form @submit.prevent="submitLink" class="bg-orange-50 p-4 rounded-xl border border-orange-100 mb-6 flex flex-col sm:flex-row gap-4">
                                    <div class="flex-1 space-y-2">
                                        <input v-model="linkForm.title" type="text" placeholder="Título (ej: Mi Instagram)" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-orange focus:ring-brand-orange text-sm" />
                                        <input v-model="linkForm.url" type="url" placeholder="URL (https://...)" class="block w-full rounded-lg border-gray-300 shadow-sm focus:border-brand-orange focus:ring-brand-orange text-sm" />
                                        <div v-if="linkForm.errors.title || linkForm.errors.url" class="text-red-500 text-xs">Revisa los campos</div>
                                    </div>
                                    <button type="submit" :disabled="linkForm.processing" class="h-10 px-4 bg-gray-900 text-white rounded-lg text-sm font-bold hover:bg-black transition self-start sm:self-center">
                                        Agregar
                                    </button>
                                </form>

                                <div v-if="links.length > 0" class="space-y-3">
                                    <div v-for="link in links" :key="link.id" class="flex items-center justify-between p-4 bg-white border border-gray-200 rounded-xl hover:border-orange-300 transition-colors group">
                                        
                                        <div v-if="editingLink !== link.id" class="flex-1 min-w-0">
                                            <div class="flex items-center gap-2">
                                                <h4 class="text-sm font-bold text-gray-800 truncate">{{ link.title }}</h4>
                                            </div>
                                            <a :href="link.url" target="_blank" class="text-xs text-orange-600 hover:text-orange-800 truncate block">{{ link.url }}</a>
                                        </div>

                                        <div v-else class="flex-1 flex gap-2 mr-4">
                                            <input v-model="editForm.title" class="block w-full rounded-md border-gray-300 text-sm focus:ring-brand-orange focus:border-brand-orange" />
                                            <input v-model="editForm.url" class="block w-full rounded-md border-gray-300 text-sm focus:ring-brand-orange focus:border-brand-orange" />
                                        </div>

                                        <div class="flex items-center gap-2 ml-4">
                                            <template v-if="editingLink !== link.id">
                                                <button @click="startEdit(link)" class="p-1.5 text-gray-400 hover:text-orange-600 hover:bg-orange-50 rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                                                </button>
                                                <button @click="deleteLink(link)" class="p-1.5 text-gray-400 hover:text-red-600 hover:bg-red-50 rounded-lg transition">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                                </button>
                                            </template>
                                            <template v-else>
                                                <button @click="updateLink(link)" class="text-xs bg-green-100 text-green-700 px-3 py-1 rounded-md font-bold hover:bg-green-200">Guardar</button>
                                                <button @click="editingLink = null" class="text-xs bg-gray-100 text-gray-600 px-3 py-1 rounded-md hover:bg-gray-200">Cancelar</button>
                                            </template>
                                        </div>
                                    </div>
                                </div>
                                <div v-else class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                                    <p class="text-gray-500 text-sm">Aún no has agregado enlaces.</p>
                                </div>
                            </div>
                        </div>

                        <div class="bg-white shadow-sm border border-orange-100 sm:rounded-2xl overflow-hidden">
                            <div class="px-6 py-5 border-b border-gray-100 flex justify-between items-center">
                                <h3 class="font-serif font-bold text-xl text-gray-900">Historial de Apoyos</h3>
                                <span class="text-xs font-bold text-gray-500 uppercase">Total: {{ supports.length }}</span>
                            </div>

                            <div class="overflow-x-auto">
                                <table class="min-w-full divide-y divide-gray-100">
                                    <thead class="bg-orange-50/50">
                                        <tr>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fecha</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Fan</th>
                                            <th class="px-6 py-3 text-left text-xs font-bold text-gray-500 uppercase tracking-wider">Mensaje</th>
                                            <th class="px-6 py-3 text-right text-xs font-bold text-gray-500 uppercase tracking-wider">Monto</th>
                                        </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-100">
                                        <tr v-for="support in supports" :key="support.id" class="hover:bg-orange-50/30 transition">
                                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                                {{ new Date(support.created_at).toLocaleDateString() }}
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-sm font-bold text-gray-900">
                                                {{ support.supporter_name || "Anónimo" }}
                                                <span v-if="isRecent(support.created_at)" class="ml-2 inline-flex items-center px-2 py-0.5 rounded-full text-xs font-bold bg-brand-orange text-gray-900">NUEVO</span>
                                            </td>
                                            <td class="px-6 py-4 text-sm text-gray-600 italic">"{{ support.message }}"</td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right">
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold bg-green-100 text-green-800">
                                                    ${{ support.amount }}
                                                </span>
                                            </td>
                                        </tr>
                                        <tr v-if="supports.length === 0">
                                            <td colspan="4" class="px-6 py-12 text-center text-gray-500">
                                                <div class="flex flex-col items-center">
                                                    <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center text-brand-orange mb-3">
                                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                                    </div>
                                                    <p>Aún no tienes apoyos. ¡Comparte tu página!</p>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>