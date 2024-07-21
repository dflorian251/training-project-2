<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
</script>

<template>
    <Head title="Unauthorized" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-red-600 leading-tight">Unauthorized Action</h2>
        </template>

        <div class="py-12 bg-gray-100 flex items-center justify-center">
            <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white border border-red-600 shadow-md sm:rounded-lg">
                    <div class="p-6 text-red-800 flex items-center">
                        <svg class="w-12 h-12 mr-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M9.93 19.07A10 10 0 1116 6.93a10 10 0 01-6.07 12.14z"></path>
                        </svg>
                        <div>
                            <h3 class="text-2xl font-bold">Access Denied</h3>
                            <p class="mt-2 text-gray-600">You cannot perform this action: no admin privileges.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
