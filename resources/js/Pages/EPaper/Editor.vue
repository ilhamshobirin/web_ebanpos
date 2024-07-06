<script setup>
import { ref, computed } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import ConfirmationModal from "@/Components/ConfirmationModal.vue";
import SecondaryButton from "@/Components/SecondaryButton.vue";
import DangerButton from "@/Components/DangerButton.vue";

const props = defineProps({
    data: Object,
    edit_mode: String,
});

const form = useForm({
    release_date : props?.data?.release_date ?? '',
    title : props?.data?.title ?? '',
    desc : props?.data?.description ?? '',
    header : props?.data?.header ?? '',
    epaper : props?.data?.epaper ?? '',
});

const uploadedHeader = ref(null);
const uploadedEPaper = ref(null);

const showDeleteConfirmation = ref(false);

const Delete = () => {
    form.delete(route("epaper.destroy", [props.data.id ?? 0]), {
        onFinish: () => {
            form.reset();
        },
    });
};

const submit = () => {
    // console.log(form);
    
    form.post(route("epaper.store"),
        {
            onError: (errors) => {
                console.log("Error");
                console.log(errors);
            }
        }
    );
};

    const handleHeaderUpload = (event) => {
        const files = event.target.files;
        for (let i = 0; i < files.length; i++) {
            const file = files[i];

            const reader = new FileReader();
            reader.onload = (e) => {
                uploadedHeader.value = e.target.result;
            };
            reader.readAsDataURL(file);
        }
        form.header = files[0];
    };

    const handleEPaperUpload = (event) => {
      const file = event.target.files[0];
      if (file && file.type === 'application/pdf') {
        const reader = new FileReader();
        reader.onload = (e) => {
            uploadedEPaper.value = {
                name: file.name,
                data: e.target.result,
            };
        };
        reader.readAsDataURL(file);
        form.epaper = file;
      }
    };

    const deleteHeader = () => {
      if (form.header.value) {
        form.header.value = ''; // Clear the file selection
      }
      uploadedHeader.value = null; // Clear the uploaded image preview
    };

function openPdf(url) {
    window.open(url, '_blank');
}
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
                <button @click="showDeleteConfirmation = true" class="m-4 w-full flex justify-center bg-red-500 text-gray-100 p-4 rounded-full tracking-wide
                                font-semibold focus:outline-none focus:shadow-outline hover:bg-red-600 shadow-lg cursor-pointer transition ease-in duration-300">
                    Hapus E-Paper
                </button>
            </div>
            <div v-else>
                <button type="submit" class="m-4 w-full flex justify-center bg-blue-500 text-gray-100 p-4 rounded-full tracking-wide
                                font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer transition ease-in duration-300">
                    Tambah E-Paper
                </button>
            </div>

        </div>

        <div class="whitespace-nowrap items-center gap-4 grid-cols-2 mb-2 w-full-1/2 flex overflow-x-auto">
            <!-- HEADER -->
            <div v-if="props.edit_mode === '1'">
                <!-- Preview File -->
                <div class="sm:max-w-lg w-full mx-5 my-5 p-5 bg-white rounded-xl">
                    <div class="text-center">
                        <h2 class="my-2 text-3xl font-bold text-gray-900">
                            Header
                        </h2>
                    </div>
                
                    <img :src="props.data.header_path" class="flex flex-col items-center justify-center w-48 h-96 pb border-2" />
                </div>
            </div>
            <div v-else-if="uploadedHeader">
                <div class="sm:max-w-lg w-full mx-5 my-5 p-5 bg-white rounded-xl">
                    <div class="text-center">
                        <h2 class="my-2 text-3xl font-bold text-gray-900">
                            Header
                        </h2>
                    </div>
                    
                    <img :src="uploadedHeader" class="flex flex-col items-center justify-center w-48 h-96 pb border-2" />
                    <button @click="deleteHeader" class="m-4 p-2 w-full flex flex-col items-center justify-center bg-red-500 rounded-full tracking-wide
                                font-semibold focus:outline-none focus:shadow-outline hover:bg-red-600 shadow-lg cursor-pointer transition ease-in duration-300">
                        <span class="material-symbols-outlined" style="color: white;"> delete </span>
                    </button>
                </div>
            </div>
            <div v-else>
                <div class="sm:max-w-lg w-full mx-5 my-5 p-5 bg-white rounded-xl">
                    <div class="text-center">
                        <h2 class="my-2 text-3xl font-bold text-gray-900">
                            Header
                        </h2>
                    </div>
                    <label for="dropzone-file" class="flex flex-col items-center justify-center w-full h-96 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div class="flex flex-col items-center justify-center px-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-semibold">Klik untuk upload gambar header dari E-Paper</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">*pastikan file format .jpg atau .png</p>
                        </div>
                        <input type="file" name="file" id="dropzone-file" multiple @change="handleHeaderUpload" class="hidden" />
                    </label>
                    <InputError :message="form.header.epaper" class="mt-1" />
                </div>
            </div>
            <!-- EPAPER -->
            <div class="sm:w-1/2 w-full col-span-1 mx-5 my-5 p-5 bg-white rounded-xl">
                <div v-if="props.edit_mode === '1'">
                    <div class="text-center">
                        <h2 class="my-2 text-3xl font-bold text-gray-900">
                            E-Paper 
                        </h2>
                    </div>
                    <label class="flex flex-col items-center justify-center w-full h-96 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:bg-gray-700 dark:border-gray-600">
                        <svg @click="openPdf(props.data.epaper_path)" class="text-gray-200 hover:bg-gray-100 dark:text-gray-500 items-center" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960" width="100" height="100">
                            <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/>
                        </svg>
                        <p class="text-lg text-center font-medium">{{ props.data.epaper_path }}</p>
                        
                    </label>
                    <InputError :message="form.errors.epaper" class="mt-1" />
                </div>

                <div v-else>
                    <div class="text-center">
                        <h2 class="my-2 text-3xl font-bold text-gray-900">
                            E-Paper 
                        </h2>
                    </div>
    
                    <label class="flex flex-col items-center justify-center w-full h-96 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 dark:hover:bg-bray-800 dark:bg-gray-700 hover:bg-gray-100 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600">
                        <div v-if="!uploadedEPaper" class="flex flex-col items-center justify-center px-6">
                            <svg class="w-8 h-8 mb-4 text-gray-500 dark:text-gray-400" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                            </svg>
                            <p class="mb-2 text-sm text-gray-500 dark:text-gray-400 font-semibold">Klik untuk upload file header dari E-Paper</p>
                            <p class="text-xs text-gray-500 dark:text-gray-400">*pastikan file format .pdf</p>
                        </div>  
                        <input type="file" @change="handleEPaperUpload" class="m-2 p-2 border-2 border-blue-500 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 hidden" />
                        <div v-if="uploadedEPaper" class="flex flex-col items-center justify-center px-6 mt-4">
                            <svg class="w-10 h-10 text-gray-200 dark:text-gray-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 -960 960 960">
                                <path d="M320-240h320v-80H320v80Zm0-160h320v-80H320v80ZM240-80q-33 0-56.5-23.5T160-160v-640q0-33 23.5-56.5T240-880h320l240 240v480q0 33-23.5 56.5T720-80H240Zm280-520v-200H240v640h480v-440H520ZM240-800v200-200 640-640Z"/>
                            </svg>
                            <p class="text-lg text-center font-medium">File Terpilih:</p>
                            <span class="text-sm font-normal ">{{ uploadedEPaper.name }}</span>
                        </div>
                        
                    </label>
                    <InputError :message="form.errors.epaper" class="mt-1" />

                </div>
            </div>
        
        </div>

        <!-- component -->
        <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
        
    </form>

    <!-- Delete Confirmation -->
    <ConfirmationModal
        :show="showDeleteConfirmation"
        @close="showDeleteConfirmation = false"
    >
        <template #title> Hapus E-Paper </template>
        <template #content>
            Anda yakin akan Hapus E-Paper ini?
        </template>
        <template #footer>
            <SecondaryButton @click="showDeleteConfirmation = false">
                Batal
            </SecondaryButton>
            <DangerButton
                class="ml-2"
                @click="Delete"
                :class="{ 'opacity-25': form.processing }"
                :disabled="form.processing"
            >
                Hapus E-Paper
            </DangerButton>
        </template>
    </ConfirmationModal>
    <!-- End of Delete Confirmation -->

    </AppLayout>
</template>