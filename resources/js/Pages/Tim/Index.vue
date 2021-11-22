<template>
    <app-layout title="Tim">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Tim
                <create-tim />
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-tim :tims="tims" :dataTims="dataTims" :karyawans="karyawans" :penilaianTims="penilaianTims" :timUnits="timUnits"/>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListTim from './Partials/ListTim.vue'
    import CreateTim from './Partials/CreateTim.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
            ListTim,
            CreateTim,
            
            
        },
        props: {
            tims: Array,
            dataTims:Array,
            karyawans:Array,
            penilaianTims:Array,
            timUnits:Array
        }
    })
</script>