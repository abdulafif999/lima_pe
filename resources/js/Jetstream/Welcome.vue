<template>
    <div>
        <div class="p-6 sm:px-20 bg-white border-b border-gray-200">
            <div>
                Dashboard Penilaian 5P oleh TPM Officer
            </div>
        </div>

        <div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2">
            <div class="p-6">
                <div class="flex items-center">

                </div>

                <div class="ml-12">
                    <div id="chart">
                        <bar-chart :timList="timList" :penilaianTims="penilaianTims" :penilaianChart="penilaianChart" 
                        :penilaianDetails="penilaianDetails" :tims="tims" :indexKriterias="indexKriterias"></bar-chart>
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-t-0 md:border-l">
                <div class="flex items-center">
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        <div id="rankingChart">
                            <ranking-chart :timList="timList" :penilaianTims="penilaianTims" :rankingChart="rankingChart" 
                            :penilaianDetails="penilaianDetails" :tims="tims" :indexKriterias="indexKriterias"
                            ></ranking-chart>
                        </div>      
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200">
                <div class="flex items-center">
                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" class="w-8 h-8 text-gray-400"><path d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold"><a href="https://tailwindcss.com/">Tailwind</a></div>
                </div>

                <div class="ml-12">
                    <div class="mt-2 text-sm text-gray-500">
                        Laravel Jetstream is built with Tailwind, an amazing utility first CSS framework that doesn't get in your way. You'll be amazed how easily you can build and maintain fresh, modern designs with this wonderful framework at your fingertips.
                    </div>
                </div>
            </div>

            <div class="p-6 border-t border-gray-200 md:border-l">
                <div class="flex items-center">
                    <div class="ml-4 text-lg text-gray-600 leading-7 font-semibold">Last Updated</div>
                </div>

                <div>
                    <div class="mt-2 text-sm text-gray-500">
                        <last-updated :penilaians="penilaians" :tims="tims"></last-updated>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
    import { defineComponent } from 'vue'
    import JetApplicationLogo from '@/Jetstream/ApplicationLogo.vue'
    import JetButton from '@/Jetstream/Button.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import BarChart from '@/Components/BarChart.vue'
    import RankingChart from '@/Components/RankingChart.vue'
    import VueApexCharts from "vue3-apexcharts";
    import LastUpdated from '@/Components/LastUpdated.vue'
    import { Container } from 'postcss'
    
    export default defineComponent({
        components: {
            JetApplicationLogo,
            JetButton,
            JetSecondaryButton,
            BarChart,
            RankingChart,
            apexchart:VueApexCharts,
            LastUpdated,
        },
        props:{
            penilaianDetails:Array,
            penilaians:Array,
            tims:Array,
            timUnits:Array,
            penilaianChart:Object,
            rankingChart:Object,
            timList:Array,
            penilaianTims:Array,
            indexKriterias:Array,
        },
    })
</script>
