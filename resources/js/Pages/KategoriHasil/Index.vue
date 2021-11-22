<template>
    <app-layout title="Kategori Hasil">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Kategori Hasil
                <create-KategoriHasil />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-KategoriHasil :kategoriHasils="kategoriHasils" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListKategoriHasil from './Partials/ListKategoriHasil.vue'
    import CreateKategoriHasil from './Partials/CreateKategoriHasil.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListKategoriHasil,
            CreateKategoriHasil,
            
            
        },
        props: {
            kategoriHasils: Array
        }
    })
</script>