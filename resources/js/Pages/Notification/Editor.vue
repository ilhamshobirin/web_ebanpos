<script setup>
import { ref, watch } from 'vue';
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';

const props = defineProps({
    data: Object,
});

const form = useForm({
    title : props?.data?.title ?? '',
    body : props?.data?.body ?? '',
});

const submit = () => {
    // console.log(form);
    form.post(route("notification.store"));
};

</script>

<template>
    <AppLayout title="Form Pembuatan Notifikasi">
        <form @submit.prevent="submit" enctype="multipart/form-data">

        <div class="max-w-screen m-5 p-10 bg-white rounded-xl z-10">
            <div class="flex">
                <span class="material-symbols-outlined"> notification_add </span>
                <div class="font-bold text-xl mx-2 text-gray-800 leading-tight">
                    Form Pembuatan Notifikasi 
                </div>
            </div>
            <div class="col-span-2 gap-4 m-4">
                <InputLabel for="judul" class="block" value="Judul Notifikasi"/>
                <TextInput type="text" name="title" id="title" v-model="form.title" class="mt-1 w-full" placeholder="Masukkan Judul Notifikasi"/>
                <InputError :message="form.errors.title" class="mt-1" />
            </div>
            <div class="m-4">
                <InputLabel for="desc" class="block" value="Isi Notifikasi"/>
                <textarea name="body" id="body" v-model="form.body" rows="4" placeholder="Masukkan Isi Notifikasi" class="mt-1 block w-full rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm"></textarea>
                <InputError :message="form.errors.body" class="mt-1" />
            </div>
            <button type="submit" 
                class="m-4 w-full flex justify-center bg-blue-500 text-gray-100 p-4 rounded-full tracking-wide
                            font-semibold focus:outline-none focus:shadow-outline hover:bg-blue-600 shadow-lg cursor-pointer 
                            transition ease-in duration-300"
            >
                Kirim Notifikasi
            </button>
        </div>
        
    </form>
    </AppLayout>
</template>