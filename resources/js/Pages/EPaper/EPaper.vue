<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    data: Object,
});

const form = useForm({
    release_date : props?.data?.release_date ?? '',
    title : props?.data?.title ?? '',
    desc : props?.data?.description ?? ''
});

const submit = () => {
    console.log(form);
    form.post(route("epaper.store"), {
        onFinish: () => {
            form.reset();
        },
    });
};

</script>

<template>
    <AppLayout title="E-Paper">
        <form @submit.prevent="submit">

        <div class="max-w-screen m-5 p-10 bg-white rounded-xl z-10">
            <h2 class="font-bold text-xl text-gray-800 leading-tight">
                Form Tambah E-Paper
            </h2>
            <div class="grid grid-cols-3 gap-4 m-4">
                <div class="col-span-1">
                    <InputLabel for="release_date" class="block" value="Tanggal Rilis" />
                    <input type="date" name="release_date" id="release_date" v-model="form.release_date" class="mt-1 w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    <InputError :message="form.errors.release_date" class="mt-1" />
                </div>
                <div class="col-span-2">
                    <InputLabel for="judul" class="block" value="Judul"/>
                    <TextInput type="text" name="title" id="title" v-model="form.title" class="mt-1 w-full" placeholder="Masukkan Judul"/>
                    <InputError :message="form.errors.title" class="mt-1" />
                </div>
            </div>
            <div class="m-4">
                <InputLabel for="desc" class="block" value="Deskripsi"/>
                <textarea name="desc" id="desc" v-model="form.desc" rows="4" placeholder="Masukkan Deskripsi" class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                <InputError :message="form.errors.desc" class="mt-1" />
            </div>
            <button type="submit" class="m-4 w-full flex justify-center bg-blue-500 text-gray-100 p-4 rounded-full tracking-wide
                            font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                Simpan
            </button>
        </div>

        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                <div class="sm:max-w-lg w-full m-5 p-10 bg-white rounded-xl z-10">
                    <div class="text-center">
                        <h2 class="my-5 text-3xl font-bold text-gray-900">
                            Halaman 1
                        </h2>
                    </div>
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-64 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">PDF FILE ONLY</p>
                            </div>
                            <input id="dropzone-file" type="file" class="hidden" />
                        </label>
                        <p class="text-sm text-gray-300">
                            <span>Pastikan file format .pdf dan hanya berisi 1 halaman</span>
                        </p>
                        <div>
                            <button type="submit" class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4  rounded-full tracking-wide
                                        font-semibold  focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                            Upload
                        </button>
                        </div>
                </div>
                <div class="sm:max-w-lg w-full m-5 p-10 bg-white rounded-xl z-10">
                    <div class="text-center">
                        <h2 class="my-5 text-3xl font-bold text-gray-900">
                            Halaman 1
                        </h2>
                    </div>
                        <embed src="{{ asset('/images/2.pdf') }}" type="application/pdf" width="100%" height="250" />
                        <iframe src="{{ asset('/storage/files/2.pdf') }}" frameborder="0" width="100%" height="600px"></iframe>
                        <p class="text-sm text-gray-300">
                            <span>Pastikan file format .pdf dan hanya berisi 1 halaman</span>
                        </p>
                        <div>
                            <button type="submit" class="my-5 w-full flex justify-center bg-blue-500 text-gray-100 p-4  rounded-full tracking-wide
                                        font-semibold  focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                            Upload
                        </button>
                        </div>
                </div>
               
                <div class="sm:max-w-lg w-full m-5 p-10 bg-white rounded-xl z-10">
                    <div class="text-center">
                        <h2 class="my-5 text-3xl font-bold text-gray-900">
                            Tambah Halaman
                        </h2>
                    </div>
                </div>
        </div> -->


        <!-- component -->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        
    </form>
    </AppLayout>
</template>
