<script setup>
import { Head } from '@inertiajs/vue3';
import NavLink from '@/Components/NavLink.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';

defineProps({
    canLogin: {
        type: Boolean,
    },
    canRegister: {
        type: Boolean,
    },
    laravelVersion: {
        type: String,
        required: true,
    },
    phpVersion: {
        type: String,
        required: true,
    },
});

function handleImageError() {
    document.getElementById('screenshot-container')?.classList.add('!hidden');
    document.getElementById('docs-card')?.classList.add('!row-span-1');
    document.getElementById('docs-card-content')?.classList.add('!flex-row');
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />

    <GuestLayout>
        <div class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
            <NavLink :href="route('login')" :active="route().current('dashboard')">
                Log in
            </NavLink>
            <NavLink :href="route('register')" :active="route().current('data')">
                Register
            </NavLink>
        </div>
    </GuestLayout>
</template>
