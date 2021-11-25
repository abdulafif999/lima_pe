<template>
    <div>
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="overflow-hidden border-b">
                        <table class="min-w-full divide-y divide-gray-200" :v-on:show="getTimPenilai()">
                            <thead class="bg-white">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                        Nama Tim
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                        Nama Penilai
                                    </th>                                   
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-black uppercase tracking-wider">
                                        Tim 5P/Unit yg Dinilai
                                    </th>                                    
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-light text-black uppercase tracking-wider">
                                        Tanggal Penilaian
                                    </th>                                   
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="penilaian in penilaians" :key="penilaian.id">
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.nama_tim }}
                                        </div>
                                    </td>                                    
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.karyawan.nama }}
                                        </div>
                                    </td>
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tim_unit.nama }}
                                        </div>
                                    </td>                                                                        
                                    <td class="px-2 py-2 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ penilaian.tgl }}
                                        </div>
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>  
    </div>
</template>
<script>

export default{
    props: {
        penilaians:Array,
        penilaianDetails:Array,
        kriterias:Array,
        tims:Array,
    },
    data() {
        return {
            detailNilai: false,
            selectedPenilaian:{},
            nilaiTotal:0,

            form: this.$inertia.form({
                listNilai: [],
            })            
        }
    },
    methods:{
        getTimPenilai(){
            for(var index=0;index<=this.penilaians.length-1;index++){
                for(var j=0;j<=this.tims.length-1;j++){
                    if(this.penilaians[index].pernum == this.tims[j].karyawan.pernum){
                        this.penilaians[index].nama_tim = this.tims[j].tim.nama;
                    }
                }
            }
        },
    }
    
    
}
</script>
