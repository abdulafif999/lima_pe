<template>
    <app-layout title="UnitDetail">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Tim Unit
                <create-UnitDetail :karyawans="karyawans" :areas="areas"/>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-UnitDetail :karyawans="karyawans" :areas="areas" :unitDetails ="unitDetails"/>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListUnitDetail from './Partials/ListUnitDetail.vue'
    import CreateUnitDetail from './Partials/CreateUnitDetail.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListUnitDetail,
            CreateUnitDetail,
            
            
        },
        props: {
            karyawans: Array,
            areas: Array,
            unitDetails :Array
        }
    })
</script>