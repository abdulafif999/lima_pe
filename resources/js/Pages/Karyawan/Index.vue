<template>
    <app-layout title="Karyawan">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Daftar Karyawan
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-karyawan :karyawans="karyawans" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListKaryawan from './Partials/ListKaryawan.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListKaryawan
            
        },
        props: {
            karyawans: Array
        }
    })
</script>