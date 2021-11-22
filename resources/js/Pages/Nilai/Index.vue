<template>
    <app-layout title="Nilai">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Nilai
                <create-nilai :kriterias="kriterias"/>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-nilai :nilais ="nilais" :kriterias ="kriterias" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListNilai from './Partials/ListNilai.vue'
    import CreateNilai from './Partials/CreateNilai.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListNilai,
            CreateNilai,
            
            
        },
        props: {
            nilais: Array,
            kriterias: Array,
        }
    })
</script>