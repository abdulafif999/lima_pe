<template>
  <div class="mb-4 flex items-center bg-white">
      <div>
        <label>Periode</label>
        <jet-input type="date" class="mt-1 block" placeholder="Tanggal Penilaian"
            ref="tgl"
            v-model="form.periode"
            @keyup.enter="create" />
      </div>
  </div>

  <div id="chart">
    <apexcharts
      ref="chart"
      :width="penilaianChart.width"
      height="300"
      :type="penilaianChart.type"
      :options="penilaianChart.options"
      :series="penilaianChart.series">
    </apexcharts>
  </div>
  <div class="mt-3 flex items-center text-sm font-semibold">
    
    <div class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                              
      <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block"
      v-model="form.kriteria">
                                                  
        <option value="" disabled selected>Select Kriteria</option>
        <option value="P1">P1</option>
        <option value="P2">P2</option>
        <option value="P3">P3</option>
        <option value="P4">P4</option>
        <option value="P5">P5</option>
        <option value="total">Semua Nilai</option>
      </select>
    </div>

    <div class="ml-4 text-center text-sm sm:text-right sm:ml-0">
                              
        <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block"
        v-model="form.timUnit">
                                                  
          <option value="" disabled selected>Pilih Tim 5P</option>
          <option v-for="tim in timList" :key="tim.id" :value="tim.nama">{{tim.nama}}</option>
        </select>
    </div>    
  </div>
  <div>
      <jet-button class="mt-2" @click="fillData()">
          Lihat
      </jet-button>                            
  </div>   
</template>

<script>
import JetButton from '@/Jetstream/Button.vue'
import VueApexCharts from "vue3-apexcharts"
import JetInput from '@/Jetstream/Input.vue'

export default {
  name: "Chart",
  components: {
    JetButton,
    JetInput,
    apexcharts:VueApexCharts,
  },
  props:{
    tims:Array,
    timList:Array,
    penilaianTims:Array,
    penilaianChart:Object,
    penilaianDetails:Array,
    indexKriterias:Array

  },
  data() {
    return {

      form:this.$inertia.form({
        kriteria:'',
        timUnit:'',
        periode:'',
      }),

      value:this.$inertia.form({
        categoriesTemp:[],
        seriesTemp:[],
      }),                
    }     

  },

  methods: {
    getRandomInt () {
      return Math.floor(Math.random() * (50 - 5 + 1)) + 5
    },    
    fillData(){
      var kriteria = this.form.kriteria;
      var timUnit = this.form.timUnit;
      var date = new Date();
      var bulan_periode = date.getMonth(this.form.periode);
      var tahun_periode = date.getFullYear(this.form.periode);
      this.value.reset();
      var i=0;
      
      var jumlahAnggota = 0;
    
      for(var y=0;y<this.penilaianTims.length;y++){
        for(var z=0;z<this.tims.length;z++){
          if(this.penilaianTims[y].tim_id == this.tims[z].tim_id && this.penilaianTims[y].tim_unit.nama == timUnit){
            jumlahAnggota++;
          }
        }
      };
      
      for(var index=0;index < this.penilaianTims.length;index++){
          if(this.penilaianTims[index].tim_unit.nama == timUnit){
            this.value.categoriesTemp[i] = this.penilaianTims[index].tim.nama;
            var total = 0;
            var w = 0;
            var x = 0;
            var kriteria_array = [];
            var total_array = [];
            for(var j=0;j < this.penilaianDetails.length;j++){                       
              var sub_total = 0;
              var index_kriteria = '';
              kriteria_array[x] = {};
              if(kriteria == this.penilaianDetails[j].kriteria.nama ){
                if(this.penilaianDetails[j].penilaian.tim_unit_id == this.penilaianTims[index].tim_unit_id){                
                  for(var k=0;k<this.tims.length;k++){
                    if(this.penilaianDetails[j].penilaian.pernum == this.tims[k].karyawan.pernum && this.tims[k].tim_id == this.penilaianTims[index].tim_id){
                      for(var l=0;l<=this.indexKriterias.length-1;l++){
                        var bulan_periode_awal = date.getMonth(this.indexKriterias[l].periode_awal);
                        var tahun_periode_awal = date.getFullYear(this.indexKriterias[l].periode_awal);
                        var bulan_periode_akhir = date.getMonth(this.indexKriterias[l].periode_akhir);
                        var tahun_periode_akhir = date.getFullYear(this.indexKriterias[l].periode_akhir);
                        var bulan_penilaian = date.getMonth(this.penilaianDetails[j].penilaian.tgl);
                        var tahun_penilaian = date.getFullYear(this.penilaianDetails[j].penilaian.tgl);
                        if(bulan_periode == bulan_periode_awal && tahun_periode == tahun_periode_awal 
                        && bulan_periode == bulan_periode_akhir && tahun_periode == tahun_periode_akhir 
                        && bulan_penilaian == bulan_periode_awal && tahun_penilaian == tahun_periode_awal 
                        && bulan_penilaian == bulan_periode_akhir && tahun_penilaian == tahun_periode_akhir
                        ){      
                            if(this.indexKriterias[l].kriteria == this.penilaianDetails[j].kriteria.nama && this.indexKriterias[l].sub_kriteria == this.penilaianDetails[j].kriteria.sub_kriteria){
                              sub_total = sub_total + this.penilaianDetails[j].nilai;
                            }
                        }               
                      }
                      
                    }                    
                  }    
                  sub_total = sub_total/jumlahAnggota;
                  for(var n=0;n<=this.indexKriterias.length-1;n++){
                    if(this.indexKriterias[n].kriteria == kriteria && this.indexKriterias[n].sub_kriteria == this.penilaianDetails[j].kriteria.sub_kriteria){
                        sub_total = sub_total*this.indexKriterias[n].index
                    }
                  }                  
                  
                }
                total = total + sub_total;
              }
              else if(kriteria == 'total'){
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
            }
            if(kriteria == 'total'){
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
              for(var c=0;c < total_array.length;c++){
                total = total + total_array[c]
              }
            }
            this.value.seriesTemp[i] = parseFloat((total).toFixed(2));
            i++;
        };
      };
      this.penilaianChart.options = {
        xaxis:{
          categories:this.value.categoriesTemp
        },
        chart:{
          toolbar:true,
          animations:{
            enabled:true,
          }
        },
        subtitle:{
          text : this.form.timUnit
        },
        colors: ['#66DA26', '#2E93fA', '#546E7A', '#E91E63', '#FF9800'],
      };
      this.penilaianChart.series[0].data = this.value.seriesTemp
      this.penilaianChart.series[0].name = this.form.kriteria
      this.renderChart(this.penilaianChart.options, this.penilaianChart.series);
    },
    renderChart(options, series){
      var chartQuarter = new ApexCharts(document.getElementById('chart'), this.penilaianChart.options);
      chartQuarter.destroy();
      chartQuarter.updateOptions(options);
      chartQuarter.updateSeries(series);
      chartQuarter.render();          
    },
  }
}
</script>
