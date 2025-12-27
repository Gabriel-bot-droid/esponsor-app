<script setup>
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-[#fffbf0]">
        
        <div class="mb-6">
            <Link href="/">
                <span class="text-4xl font-black text-[#1f2937] tracking-tight font-serif">
                    eSponsor
                </span>
            </Link>
        </div>

        <div
            class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white shadow-xl border border-orange-100 overflow-hidden sm:rounded-3xl"
        >
            <slot />
        </div>
    </div>
</template>
