<template>
    <div class="bg-white mb-5">
        <div class="mt-3 flex items-center text-sm font-semibold">
            <div class="mr-4 flex">
                <label>Periode : </label>
            </div>

            <jet-input type="date" class="mt-1 block" placeholder="Tanggal Penilaian"
                ref="tgl"
                v-model="form.periode"
                />
    </div>
    <div class="mt-3 flex items-center mb-5 text-sm font-semibold">
            <div class="mr-4 flex">
                <label>Rank </label>
            </div>
            <select  class="focus:ring-opacity-50 rounded-md shadow-sm mt-1 block"
            v-model="form.rank" v-on:change="getRanking(form.rank)">
                                                        
                <option value="" disabled selected>Select</option>
                <option value="top">5 Teratas</option>
                <option value="bottom">5 Terbawah</option>
            </select>
            
            <select  class="focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
            v-model="form.timRank">
                                                        
                <option value="" disabled selected>Select Team</option>
                <option v-for="(tim, index) in list.listTim" :key="tim.id" :value="tim">{{index+1}} - {{tim.nama}} - {{tim.nilai_final}}</option>
            </select>
            <div class="ml-2 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block">
                <jet-button @click="fillData()">
                    Lihat
                </jet-button>
            </div>            
    </div>
  </div>

  <div id="rankingChart">
    <apexcharts
      ref="chart"
      :width="rankingChart.width"
      height="300"
      :type="rankingChart.type"
      :options="rankingChart.options"
      :series="rankingChart.series">
    </apexcharts>
  </div>

</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import VueApexCharts from "vue3-apexcharts"
import JetInput from '@/Jetstream/Input.vue'

export default {
  name: "RankingChart",
  components: {
    JetButton,
    JetInput,
    apexcharts:VueApexCharts,
  },
  props:{
    tims:Array,
    timList:Array,
    penilaianTims:Array,
    rankingChart:Object,
    penilaianDetails:Array,
    indexKriterias:Array,


  },
  data(){
      return {

        form:this.$inertia.form({
            rank:'',
            timRank:{},
            periode:'',
        }),
        value:this.$inertia.form({
            categoriesTemp:[],
            seriesTemp:[]
        }),
        list:this.$inertia.form({
            daftarTim:[{}],
            listTim:[]
        })

      }
  },

  methods:{
      getRanking(rank){
        this.list.reset();
        var date = new Date();
        var bulan_periode = date.getMonth(this.form.periode);
        var tahun_periode = date.getFullYear(this.form.periode);          

        for(var h=0;h < this.timList.length;h++){

            var nilai_final = 0;
            var total = [];
            var kategori = [];
            this.list.daftarTim[h] = this.timList[h];
            var i=0;
            
            var jumlahAnggota = 0;
            
            for(var y=0;y<this.penilaianTims.length;y++){
                for(var z=0;z<this.tims.length;z++){
                if(this.penilaianTims[y].tim_id == this.tims[z].tim_id && this.penilaianTims[y].tim_unit.nama == this.timList[h].nama){
                    jumlahAnggota++;
                }
                }
            };
            
            for(var index=0;index < this.penilaianTims.length;index++){
                if(this.penilaianTims[index].tim_unit.nama == this.timList[h].nama){
                    kategori[i] = this.penilaianTims[index].tim.nama;
                    var w = 0;
                    var x = 0;
                    var kriteria_array = [];
                    var total_array = [];
                    for(var j=0;j < this.penilaianDetails.length;j++){                       
                    var sub_total = 0;
                    var index_kriteria = '';
                    kriteria_array[x] = {};
                        if(this.penilaianDetails[j].penilaian.tim_unit_id == this.penilaianTims[index].tim_unit_id){
                        for(var k=0;k<this.tims.length;k++){
                            if(this.penilaianDetails[j].penilaian.pernum == this.tims[k].karyawan.pernum && this.tims[k].tim_id == this.penilaianTims[index].tim_id){
                            for(var l=0;l < this.indexKriterias.length;l++){
                                var bulan_periode_awal = date.getMonth(this.indexKriterias[l].periode_awal);
                                var tahun_periode_awal = date.getFullYear(this.indexKriterias[l].periode_awal);
                                var bulan_periode_akhir = date.getMonth(this.indexKriterias[l].periode_akhir);
                                var tahun_periode_akhir = date.getFullYear(this.indexKriterias[l].periode_akhir);
                                var bulan_penilaian = date.getMonth(this.penilaianDetails[j].penilaian.tgl);
                                var tahun_penilaian = date.getFullYear(this.penilaianDetails[j].penilaian.tgl);
                                if(bulan_periode >= bulan_periode_awal && tahun_periode >= tahun_periode_awal 
                                && bulan_periode <= bulan_periode_akhir && tahun_periode <= tahun_periode_akhir 
                                && bulan_penilaian >= bulan_periode_awal && tahun_penilaian >= tahun_periode_awal 
                                && bulan_penilaian <= bulan_periode_akhir && tahun_penilaian <= tahun_periode_akhir
                                ){      
                                    if(this.indexKriterias[l].kriteria == this.penilaianDetails[j].kriteria.nama && this.indexKriterias[l].sub_kriteria == this.penilaianDetails[j].kriteria.sub_kriteria){
                                        sub_total = sub_total + this.penilaianDetails[j].nilai
                                        index_kriteria = this.indexKriterias[l].index;
                                    }
                                }               
                            }
                            
                            }                    
                        }    
                        kriteria_array[x].sub_nilai = (sub_total/jumlahAnggota) * index_kriteria;
                        kriteria_array[x].kriteria = this.penilaianDetails[j].kriteria.nama;
                        kriteria_array[x].sub_kriteria = this.penilaianDetails[j].kriteria.sub_kriteria;
                        kriteria_array[x].tgl = this.penilaianDetails[j].penilaian.tgl;
                        x++;
                        }
                    }
                    for(var a = 0;a < this.indexKriterias.length; a++){
                        if(this.indexKriterias[a].sub_kriteria == ''){
                            total_array[w] = 0;
                            var bulan_periode_awal = date.getMonth(this.indexKriterias[a].periode_awal);
                            var tahun_periode_awal = date.getFullYear(this.indexKriterias[a].periode_awal);
                            var bulan_periode_akhir = date.getMonth(this.indexKriterias[a].periode_akhir);
                            var tahun_periode_akhir = date.getFullYear(this.indexKriterias[a].periode_akhir);
                            if(bulan_periode >= bulan_periode_awal && tahun_periode >= tahun_periode_awal 
                            && bulan_periode <= bulan_periode_akhir && tahun_periode <= tahun_periode_akhir
                            ){                   
                            for(var b = 0;b < kriteria_array.length;b++){
                                var bulan_penilaian = date.getMonth(kriteria_array[b].tgl);
                                var tahun_penilaian = date.getFullYear(kriteria_array[b].tgl);
                                if(this.indexKriterias[a].kriteria == kriteria_array[b].kriteria){
                                if(bulan_penilaian >= bulan_periode_awal && tahun_penilaian >= tahun_periode_awal && bulan_penilaian <= bulan_periode_akhir && tahun_penilaian <= tahun_periode_akhir){
                                    total_array[w] = total_array[w] + kriteria_array[b].sub_nilai;
                                    
                                }
                                }
                            }
                            }
                            total_array[w] = total_array[w] * this.indexKriterias[a].index
                            w++;
                        }
                    }
                    total[i] = 0;
                    for(var c=0;c < total_array.length;c++){
                        total[i] = parseFloat((total[i] + total_array[c]).toFixed(2));
                    }
                    i++;
                }
            }
            for(var d=0; d < total.length;d++){
                nilai_final = nilai_final + total[d];
            }
            this.list.daftarTim[h].nilai_final = parseFloat((nilai_final/i).toFixed(2));
            this.list.daftarTim[h].kategori = kategori
            this.list.daftarTim[h].series = total
        }
        this.addRanking();
      },
      addRanking(){
        var tempObject = {};
        if(this.form.rank == 'top'){
            for(var i = 0; i < this.list.daftarTim.length;i++){
                for(var j=i+1;j<this.list.daftarTim.length;j++){
                    if(this.list.daftarTim[j].nilai_final >= this.list.daftarTim[i].nilai_final){
                        tempObject = this.list.daftarTim[j];
                        this.list.daftarTim[j] = this.list.daftarTim[i];
                        this.list.daftarTim[i] = tempObject;
                    }
                }
            }
        }
        else if(this.form.rank == 'bottom'){
            for(var i = 0; i < this.list.daftarTim.length;i++){
                for(var j=i+1;j<this.list.daftarTim.length;j++){
                    if(this.list.daftarTim[j].nilai_final <= this.list.daftarTim[i].nilai_final){
                        tempObject = this.list.daftarTim[j];
                        this.list.daftarTim[j] = this.list.daftarTim[i];
                        this.list.daftarTim[i] = tempObject;
                    }
                }
            }            
        }
        for(var k=0;k<5;k++){
            this.list.listTim[k] = this.list.daftarTim[k];
            if(this.form.rank == 'top'){
                this.list.listTim[k].rank = 'Tim ke-' + k+1 + 'Tertinggi';
            }
            else if(this.form.rank == 'bottom'){
                this.list.listTim[k].rank =  'Tim ke-' + k+1 + 'Terendah';
            }
        }
      },
      fillData(){
        var tim = this.form.timRank;
        this.rankingChart.options = {
            xaxis:{
                categories:tim.kategori
            },
            chart:{
                toolbar:true,
                animations:{
                    enabled:true,
                },
                subtitle:{
                    text:tim.rank
                },

            },
            colors: ['#66DA26', '#2E93fA', '#546E7A', '#E91E63', '#FF9800'],
        };
        this.rankingChart.series[0].data = tim.series
        this.rankingChart.series[0].name = tim.nama
        this.renderChart(this.rankingChart.options, this.rankingChart.series);
      },
      renderChart(options, series){
        var chartQuarter = new ApexCharts(document.getElementById('rankingChart'), this.rankingChart.options);
        chartQuarter.destroy();
        chartQuarter.updateOptions(options);
        chartQuarter.updateSeries(series);
        chartQuarter.render();          
      },
    
  }
}
</script>