<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import { Head, Link, router, useForm } from '@inertiajs/vue3';
import InputLabel from '@/Components/InputLabel.vue';
import TextInput from '@/Components/TextInput.vue';
import { watch, ref } from "vue";
import SimplePagination from '@/Components/SimplePagination.vue';

const props = defineProps({
    list: Object,
});

const search = ref('');

watch(
    search, 
    (value) => {
        router.get(
            route("epaper.index"),
            {search: value},
            {preserveState: true}
        )
    }
)

const newData = () => {
    router.visit(route("epaper.create"));
};

const editData = ($data) => {
    router.visit(route("epaper.edit", { id: $data.id }));
};

</script>

<template>
    <AppLayout title="E-Paper">
        <div class="max-w-screen m-5 p-10 bg-white rounded-xl z-10">
            <div class="flex">
                <span class="material-symbols-outlined"> notifications </span>
                <div class="font-bold text-xl mx-2 text-gray-800 leading-tight">
                    Riwayat Notifikasi
                </div>
            </div>

            <div class="flex mt-4 flex-col">
                <div class="w-full p-4 flex justify-between items-center">
                    <div class="w-1/2 flex items-center">
                        <div
                            class="w-full max-w-md inline-flex items-center bg-white rounded-md border border-black focus-within:border-transparent focus-within:ring-2 focus-within:indigo-500"
                        >
                            <InputLabel
                                for="globalsearch"
                                class="text-sm pl-4"
                                value="Pencarian"
                            />
                            <TextInput
                                type="search"
                                v-model="search"
                                class="w-full rounded-r-md ring-0 border-0 focus:ring-0 text-sm"
                                name="globalsearch"
                                id="globalsearch"
                            />
                        </div>
                    </div>
                    <button
                        class="flex gap-2 text-sm bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition"
                        @click="newData"
                    >
                        Tambah
                        <span class="hidden md:block"
                            >Notifikasi Baru</span
                        >
                    </button>
                </div>
            </div>

            <!-- Table -->
            <div class="w-full">
                <table class="w-full whitespace-nowrap text-sm">
                    <thead>
                        <tr>
                            <th class="p-2 w-10">No.</th>
                            <th class="p-2">Tanggal</th>
                            <th class="p-2 w-50">Isi Pesan</th>
                            <th class="p-2">Deskripsi</th>
                        </tr>
                    </thead>
                    <!-- <tbody>
                        <tr v-if="props.list.data.length <= 0">
                            <td
                                colspan="7"
                                class="text-left md:text-center text-sm font-semibold text-slate-500 p-4"
                            >
                                Tidak ada data
                            </td>
                        </tr>
                        <tr
                            v-for="(data, index) in props.list.data"
                            :key="data.id"
                            @click="editData(data)"
                            class="cursor-pointer hover:bg-gray-200 transition"
                        >
                            <td class="p-2 text-center">
                                {{ props.list.from + index }}.
                            </td>
                            <td class="p-2 text-center w-24"> {{ data.release_date }} </td>
                            <td class="p-2 text-center w-20"> {{ data.title }} </td>
                            <td class="p-2 text-center"> {{ data.description }} </td>
                            <td class="p-2 text-center">
                                <span class="material-symbols-outlined">
                                    chevron_right
                                </span>
                            </td>
                        </tr>
                    </tbody> -->
                </table>
            </div> 
            <div class="flex justify-between items-center">
                <!-- <SimplePagination :links="props.list.links" />
                <span class="text-sm text-gray-400 font-semibold"
                    >Menampilkan {{ props.list.from }} sampai
                    {{ props.list.to }} dari {{ props.list.total }} data</span
                > -->
            </div>
        </div>
        
    </AppLayout>
</template>
