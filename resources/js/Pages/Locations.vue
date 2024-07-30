<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import { ref } from 'vue';
import axios from 'axios';


const form = ref({
    name: '',
    latitude: '',
    longitude: '',
    visibility: '',
    comment: '',
});

const submit = async () => {
    console.log(typeof(form.value.visibility));
    try {
        // const baseUrl = window.location.origin;
        // await axios.post(`${baseUrl}/locations/submit-location`, form.value).then(...);
        await axios.post('/training-project-2/public/locations/submit-location', form.value).then(function (response) {
            window.location = response.data.redirect;
            console.log('Data submitted successfully:', response.data);
        });

    } catch (error) {
        console.error('There was an error submitting the form:', error);
    }
};
</script>

<template>
    <AuthenticatedLayout>
        <div class="bg-white p-6 rounded shadow-md max-w-md mx-auto mt-6">
            <h1 class="text-3xl text-white bg-gray-800 p-4 rounded mb-6 text-center">Add Location</h1>
            <form @submit.prevent="submit">

                <!-- <input type="hidden" name="_token" :value="csrf_token"> -->

                <div>
                    <InputLabel for="name" value="Name" />

                    <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.name" /> -->
                </div>

                <div class="mt-4">
                    <InputLabel for="latitude" value="Latitude" />

                    <input
                    id="latitude"
                    type="number"
                    step="any"
                    class="mt-1 block w-full"
                    v-model="form.latitude"
                    required
                    autocomplete=""
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.latitude" /> -->
                </div>

                <div class="mt-4">
                    <InputLabel for="longitude" value="Longitude" />

                    <input
                    id="longitude"
                    type="number"
                    step="any"
                    class="mt-1 block w-full"
                    v-model="form.longitude"
                    required
                    autocomplete=""
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.longitude" /> -->
                </div>

                <div class="mt-4">
                    <InputLabel for="visibility" value="Visibility" />

                    <select id="event_visibility" v-model="form.visibility" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 white:bg-gray-700 white:border-gray-600 dark:placeholder-gray-400 white:text dark:focus:ring-blue-500 dark:focus:border-blue-500">
                    <option selected>The location is...</option>
                    <option value="public">Public</option>
                    <option value="private">Private</option>
                    </select>

                    <!-- <InputError class="mt-2" :message="form.errors.visibility" /> -->
                </div>

                <div class="mt-4">
                    <InputLabel for="comment" value="Comment" />

                    <TextInput
                    id="comment"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.comment"
                    autocomplete=""
                    />

                    <!-- <InputError class="mt-2" :message="form.errors.comment" /> -->
                </div>

                <div class="flex items-center justify-end mt-4">
                    <PrimaryButton class="ms-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Submit Location
                    </PrimaryButton>
                </div>
            </form>
        </div>
    </AuthenticatedLayout>
</template>








