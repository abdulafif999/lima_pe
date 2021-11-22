<template>
    <app-layout title="TimUnit">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Tim 5P/Unit
                <create-TimUnit :areas="areas"/>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-TimUnit :timUnits="timUnits" :karyawans="karyawans" :unitDetails="unitDetails" />
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListTimUnit from './Partials/ListTimUnit.vue'
    import CreateTimUnit from './Partials/CreateTimUnit.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListTimUnit,
            CreateTimUnit,
            
            
        },
        props: {
            timUnits:Array,
            karyawans:Array,
            unitDetails:Array
        }
    })
</script>