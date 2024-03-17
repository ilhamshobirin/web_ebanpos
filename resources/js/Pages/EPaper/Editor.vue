<script setup>
import { ref } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    data: Object,
    page_count: Object,
    edit_mode: String,
});

const form = useForm({
    release_date : props?.data?.release_date ?? '',
    title : props?.data?.title ?? '',
    desc : props?.data?.description ?? '',
    files : [],
    page_count : props?.data?.page_count ?? 5 
});

const pages = ref([]);

const submit = () => {
    // console.log(form);
    console.log("Uploaded Files");
    console.log(uploadedFiles);
    form.post(route("epaper.store"));
};

const addPage = () => {
    form.page_count += 1;
}

const uploadedFiles = ref([]);

const handleFileUpload = (event) => {
    const files = event.target.files;
    for (let i = 0; i < files.length; i++) {
        const file = files[i];
        
        const reader = new FileReader();
        reader.onload = (e) => {
            uploadedFiles.value.push(e.target.result);
        };
        reader.readAsDataURL(file);
    }
    form.files.push(files[0]);
};

</script>

<template>
    <AppLayout title="E-Paper">
        <form @submit.prevent="submit" enctype="multipart/form-data">

        <div class="max-w-screen m-5 p-10 bg-white rounded-xl z-10">
            <div class="flex">
                <span class="material-symbols-outlined"> newsmode </span>
                <div class="font-bold text-xl mx-2 text-gray-800 leading-tight">
                    Form Tambah E-Paper
                </div>
            </div>
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
            <div v-if="props.edit_mode === '1'">
                <div class="grid grid-cols-2 gap-4 m-4">
                    <div class="col-span-1">
                        <button type="submit" class="m-4 w-full flex justify-center bg-green-500 text-gray-100 p-4 rounded-full tracking-wide
                                        font-semibold focus:outline-none focus:shadow-outline hover:bg-green-600 shadow-lg cursor-pointer transition ease-in duration-300">
                            Update E-Paper
                        </button>
                    </div>
                    <div class="col-span-1">
                        <button type="submit" class="m-4 w-full flex justify-center bg-red-500 text-gray-100 p-4 rounded-full tracking-wide
                                        font-semibold focus:outline-none focus:shadow-outline hover:bg-red-600 shadow-lg cursor-pointer transition ease-in duration-300">
                            Hapus E-Paper
                        </button>
                    </div>
                </div>
            </div>
            <div v-else>
                <button type="submit" class="m-4 w-full flex justify-center bg-blue-500 text-gray-100 p-4 rounded-full tracking-wide
                                font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                    Tambah E-Paper
                </button>
            </div>

        </div>

        <!-- HALAMAN -->
        <div class="whitespace-nowrap gap-4 mb-2 flex overflow-x-auto">
            <div
                v-for="index in form.page_count"
                :key="index"
            >
                <div v-if="uploadedFiles.length < index">
                    <!-- Upload File -->
                    <div class="sm:max-w-lg w-full mx-5 my-5 p-5 bg-white rounded-xl">
                        <div class="text-center">
                            <h2 class="my-2 text-3xl font-bold text-gray-900">
                                Halaman {{ index }}
                            </h2>
                        </div>
                        <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-96 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                            <div class="flex flex-col items-center justify-center px-6">
                                <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500 dark:text-gray-400"><span class="font-semibold">Klik untuk upload</span> atau drag and drop</p>
                                <p class="text-xs text-gray-500 dark:text-gray-400">*pastikan file format .pdf dan hanya 1 halaman</p>
                            </div>
                            <input type="file" name="file" id="dropzone-file" multiple @change="handleFileUpload" class="hidden" />
                        </label>
                    </div>
                </div>
                <div v-else>
                    <!-- Preview File -->
                    <div class="sm:max-w-lg w-full mx-5 my-5 p-5 bg-white rounded-xl">
                        <div class="text-center">
                            <h2 class="my-2 text-3xl font-bold text-gray-900">
                                Halaman {{ index }}
                            </h2>
                        </div>
                    
                        <img :src="uploadedFiles[index-1]" class="flex flex-col items-center justify-center w-48 h-96 pb border-2" />

                    </div>
                </div>
            </div>

            <!-- Add Button -->
            <div class="sm:max-w-lg w-full m-5 p-10 rounded-xl z-10 flex items-center justify-center flex-col">
                <button type="button" class="text-white bg-blue-600 hover:bg-blue-800 focus:ring-4 focus:outline-none font-medium rounded-full text-sm p-2.5 text-center inline-flex items-center"
                    @click="addPage()"
                >
                    <span class="material-symbols-outlined"> add_circle </span>
                </button>
                <h2 class="text-xl font-semibold text-blue-600">
                    Tambah Halaman
                </h2>
            </div>
                           
        </div>

        <!-- component -->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        
    </form>
    </AppLayout>
</template>
