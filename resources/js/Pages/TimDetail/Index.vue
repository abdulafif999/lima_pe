<template>
    <app-layout title="TimDetail">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Tim Detail
                <create-TimDetail :tims="tims" :karyawans="karyawans" />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-TimDetail :tims="tims" :karyawans="karyawans" :timDetails="timDetails"/>
                
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListTimDetail from './Partials/ListTimDetail.vue'
    import CreateTimDetail from './Partials/CreateTimDetail.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListTimDetail,
            CreateTimDetail,
            
            
        },
        props: {
            tims: Array,
            karyawans: Array,
            timDetails :Array
        }
    })
</script>