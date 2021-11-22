<template>
    <app-layout title="Index Kriteria">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Kriteria
                <create-index-kriteria :kriterias="kriterias" />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-index-kriteria :indexKriterias="indexKriterias" :kriterias="kriterias" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListIndexKriteria from './Partials/ListIndexKriteria.vue'
    import CreateIndexKriteria from './Partials/CreateIndexKriteria.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListIndexKriteria,
            CreateIndexKriteria,
            
            
        },
        props: {
            indexKriterias: Array,
            kriterias:Array,
        }
    })
</script>