<template>
    <div class="min-h-screen font-sans bg-[#fffbf0]">
        
        <Navbar />

        <Hero />
        <StepsSection />
        <FeaturesSection />
        <TestimonialsSection />

        <Footer />

    </div>
</template>

<script setup>
import Navbar from '@/Components/Navbar.vue';
import Hero from '@/Components/Hero.vue';
import StepsSection from '@/Components/StepsSection.vue';
import FeaturesSection from '@/Components/FeaturesSection.vue';
import TestimonialsSection from '@/Components/TestimonialsSection.vue';
import Footer from '@/Components/Footer.vue';
</script>
