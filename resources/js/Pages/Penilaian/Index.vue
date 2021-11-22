<template>
    <app-layout title="Penilaian">
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Penilaian
                <create-penilaian :karyawans="karyawans" :tims="tims" :penilaianTims="penilaianTims" :unitDetails="unitDetails"/>
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <list-penilaian :penilaians="penilaians" :penilaianDetails="penilaianDetails" :tims="tims"/>
            </div>
        </div>
    </app-layout>
</template>
<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import ListPenilaian from './Partials/ListPenilaian.vue'
    import CreatePenilaian from './Partials/CreatePenilaian.vue'
    
    

    export default defineComponent({
        components: {
            AppLayout,
            ListPenilaian,
            CreatePenilaian,
            
            
        },
        props: {
            penilaians: Array,
            karyawans: Array,
            tims: Array,
            penilaianTims:Array,
            unitDetails:Array,
            penilaianDetails:Array
        }
    })
</script>