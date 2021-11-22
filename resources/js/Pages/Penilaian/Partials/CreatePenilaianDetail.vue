<template>
    <app-Layout>
        <template #header>
            <h2 class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                Detail Penilaian
            </h2>
        </template>
        
        <div class="py-12" >
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="flex flex-col">
                    <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8" :v-on:show="getDataPenilaian()">
                            <!--List Rank Nilai-->
                            <div class="flex justify-between font-semibold text-xl text-gray-800 leading-tight">
                                <list-nilai :nilais="nilais" :kriterias="kriterias">?</list-nilai>
                            </div>                            
                            <table class="min-w-full divide-y divide-gray-200 mb-5">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penilai</th>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Penilaian</th>
                                        <th scope="col"
                                    class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tim 5P/Unit yang Dinilai</th>
                                    </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                    <tr >
                                        <td class="px-6 py-4 whitespace-nowrap">{{this.getData.karyawan.nama}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{this.getData.tgl}}</td>
                                        <td class="px-6 py-4 whitespace-nowrap">{{this.getData.tim_unit.nama}}</td>
                                    </tr>  
                                </tbody>                              
                            </table>            
                            <div class="sm:-my-px sm:ml-1 sm:flex bg-gray mt-12 mb-14"  :v-on:show ="getPenilaianId()">
                                <jet-secondary-button v-on:click.prevent="getKriteria1()" >P1</jet-secondary-button>
                                <jet-secondary-button v-on:click.prevent="getKriteria2()" >P2</jet-secondary-button>
                                <jet-secondary-button v-on:click.prevent="getKriteria3()" >P3</jet-secondary-button>
                                <jet-secondary-button v-on:click.prevent="getKriteria4()" >P4</jet-secondary-button>
                                <jet-secondary-button v-on:click.prevent="getKriteria5()" >P5</jet-secondary-button>
                            </div>

                            <div class="mt-4 form-group">

                                <!--Session Penilaian Berdasarkan Kriteria-->
                                <div v-if="session === 1">
                                    <div v-for="item in kriteria1" :key="item.id">
                                        <div v-if="item === null"> Tidak ada Kriteria </div>
                                        <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                        <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai"
                                            ref="nilai"
                                            v-model="form.nilai[item.kriteriaIndex]"
                                            @keyup.enter="create"
                                        />

                                        <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                ref="status"
                                                v-model="form.status[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.status" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                ref="rekomendasi"
                                                v-model="form.rekomendasi[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="foto"
                                                ref="foto"
                                                v-model="form.foto[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.foto" class="mt-2" />                                
                                        </div>
                                    </div>
                                </div>
                                <div v-if="session === 2">
                                    <div v-for="item in kriteria2" :key="item.id">
                                        <div v-if="item === null"> Tidak ada Kriteria</div>
                                        <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                        <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai"
                                            ref="nilai"
                                            v-model="form.nilai[item.kriteriaIndex]"
                                            @keyup.enter="create" />

                                        <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                ref="status"
                                                v-model="form.status[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                ref="rekomendasi"
                                                v-model="form.rekomendasi[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="foto"
                                                ref="foto"
                                                v-model="form.foto[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.nilai" class="mt-2" />                                
                                        </div>
                                    </div>
                                </div>
                                <div v-if="session === 3">
                                    <div v-for="item in kriteria3" :key="item.id">
                                        <div v-if="item === null"> Tidak ada Kriteria   </div>
                                        <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                        <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai"
                                            ref="nilai"
                                            v-model="form.nilai[item.kriteriaIndex]"
                                            @keyup.enter="create" />

                                        <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                ref="status"
                                                v-model="form.status[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                ref="rekomendasi"
                                                v-model="form.rekomendasi[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="foto"
                                                ref="foto"
                                                v-model="form.foto[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.foto" class="mt-2" />                                
                                        </div>
                                    </div>
                                </div>
                                <div v-if="session === 4">
                                    <div v-for="item in kriteria4" :key="item.id">
                                        <div v-if="item === null"> Tidak ada Kriteria   </div>
                                        <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                        <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai"
                                            ref="nilai"
                                            v-model="form.nilai[item.kriteriaIndex]"
                                            @keyup.enter="create" />

                                        <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                ref="status"
                                                v-model="form.status[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                ref="rekomendasi"
                                                v-model="form.rekomendasi[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="foto"
                                                ref="foto"
                                                v-model="form.foto[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.foto" class="mt-2" />                                
                                        </div>
                                    </div>
                                </div>
                                <div v-if="session === 5">
                                    <div v-for="item in kriteria5" :key="item.id">
                                        <div v-if="item === null"> Tidak ada Kriteria   </div>
                                        <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                                        <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai"
                                            ref="nilai"
                                            v-model="form.nilai[item.kriteriaIndex]"
                                            @keyup.enter="create" />

                                        <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="status"
                                                ref="status"
                                                v-model="form.status[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.nilai" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="rekomendasi"
                                                ref="rekomendasi"
                                                v-model="form.rekomendasi[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.rekomendasi" class="mt-2" />
                                        </div>
                                        <div>
                                            <jet-input type="text" class="mt-1 block w-3/4" placeholder="foto"
                                                ref="foto"
                                                v-model="form.foto[item.kriteriaIndex]"
                                                @keyup.enter="create" />

                                            <jet-input-error :message="form.errors.foto" class="mt-2" />                                
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <jet-button class="ml-2" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                                        Create
                                    </jet-button>            
                                </div>        
                            </div>
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </app-Layout>
</template>
<script>
    import JetButton from '@/Jetstream/Button.vue'
    import JetDialogModal from '@/Jetstream/DialogModal.vue'
    import JetInput from '@/Jetstream/Input.vue'
    import JetInputError from '@/Jetstream/InputError.vue'
    import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'
    import JetCheckbox from '@/Jetstream/Checkbox.vue'
    import ListNilai from './ListRankNilai.vue'
    import { Inertia } from '@inertiajs/inertia'
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'


    export default {
        components: {
            AppLayout,
            JetButton,
            JetDialogModal,
            JetInput,
            JetInputError,
            JetSecondaryButton,
            JetCheckbox,
            ListNilai,

        },

        props: {
            penilaians: Array,
            kriterias:Array,
            dataPenilaians:Array,
            nilais:Array

        },

        data() {
            return {
                session:1,
                kriteria1:[],
                kriteria2:[],
                kriteria3:[],
                kriteria4:[],
                kriteria5:[],
                getData:{},
            
                form:this.$inertia.form({
                    penilaian_id:'',
                    kriteria:[],
                    nilai:[],
                    foto:[],
                    status:[],
                    rekomendasi:[]
                }),
            }
        },
        methods:{
            getKriteria1(){
                this.session = 1;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P1'){
                        this.kriteria1[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria1[j].id;
                        this.kriteria1[j].kriteriaIndex = i;
                        j++;
                        
                    }
                }
                

            },
            getKriteria2(){
                this.session = 2;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P2'){
                        this.kriteria2[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria2[j].id;
                        this.kriteria2[j].kriteriaIndex = i;
                        j++;
                        
                    }
                }
            },
            getKriteria3(){
                this.session = 3;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P3'){
                        this.kriteria3[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria3[j].id;
                        this.kriteria3[j].kriteriaIndex = i;
                        j++;
                        
                    }                
                }            
            },                
            getKriteria4(){
                this.session = 4;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P4'){
                        this.kriteria4[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria4[j].id;
                        this.kriteria4[j].kriteriaIndex = i;
                        j++;
                        
                    }                
                }            
                
            },
            getKriteria5(){
                this.session = 5;
                var kriteria = this.kriterias;
                var j=0;
                for(var i=0;i<= kriteria.length-1;i++){
                    if(kriteria[i].nama == 'P5'){
                        this.kriteria5[j] = kriteria[i];
                        this.form.kriteria[i] = this.kriteria5[j].id;
                        this.kriteria5[j].kriteriaIndex = i;
                        j++;
                        
                    }                
                }            
            },
            getPenilaianId(){
                this.form.penilaian_id = this.penilaians.penilaian_id;
            },
            getDataPenilaian(){
                for(var index=0;index<=this.dataPenilaians.length-1;index++){
                    if(this.penilaians.penilaian_id == this.dataPenilaians[index].id){
                        this.getData = this.dataPenilaians[index];
                    }
                }
            },
            create() {
                var x = this.form.rekomendasi.length;
                var y = this.form.status.length;
                var z = this.form.foto.length;

                if(x < 1){
                    this.form.rekomendasi[this.kriterias.length-1] = '-';
                }else if(x > 1 && this.form.rekomendasi[this.kriterias.length-1] == null){
                    this.form.rekomendasi[this.kriterias.length-1] = '-';
                }
                if(y < 1){
                    this.form.status[this.kriterias.length-1] = '-';
                }else if(y > 1 && this.form.status[this.kriterias.length-1] == null){
                    this.form.status[this.kriterias.length-1] = '-';
                }
                if(z < 1){
                    this.form.foto[this.kriterias.length-1] = '-'
                }else if(z > 1 && this.form.foto[this.kriterias.length-1] == null){
                    this.form.foto[this.kriterias.length-1] = '-';
                }
                this.form.post(route('penilaianDetail.store'), {
                    preserveScroll: true,
                    preserveState: true,
                    onSuccess: () => {
                        this.form.reset();
                    },
                })
            },        
            // search(){
            //    this.$inertia.replace(this.route('karyawan.index', {term: this.term}))
            // }
        }
    }
</script>
