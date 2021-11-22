<template>
    <app-layout title="Kriteria">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Kriteria
                <create-Kriteria />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-Kriteria :kriterias="kriterias" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListKriteria from './Partials/ListKriteria.vue'
    import CreateKriteria from './Partials/CreateKriteria.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListKriteria,
            CreateKriteria,
            
            
        },
        props: {
            kriterias: Array
        }
    })
</script>