<template>
    <app-layout title="Area">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Unit
                <create-Area />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-Area :areas="areas" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListArea from './Partials/ListArea.vue'
    import CreateArea from './Partials/CreateArea.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListArea,
            CreateArea,
            
            
        },
        props: {
            areas: Array
        }
    })
</script>