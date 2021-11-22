<template>
    <div>
        <jet-button @click="createIndexKriteria">
            Buat Index Kriteria
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingIndexKriteria" @close="closeModal">
            <template #title>
                Index Kriteria
            </template>

            <template #content>

                <div class="space-x-4 sm:-my-px sm:flex mb-12 sm:self-center align-middle">
                    <div>Periode Awal :
                        <div>
                            <jet-input type="date" class="mt-1 block" placeholder="Periode Awal"
                                        ref="tgl"
                                        v-model="form.periode_awal"
                                        @keyup.enter="create" />

                            <jet-input-error :message="form.errors.periode_awal" class="mt-2" />
                        </div>
                    </div>
                    
                    <div>Periode Akhir :
                        <div>
                            <jet-input type="date" class="mt-1 block" placeholder="Periode Akhir"
                                        ref="tgl"
                                        v-model="form.periode_akhir"
                                        @keyup.enter="create" />

                            <jet-input-error :message="form.errors.periode_akhir" class="mt-2" />                    
                        </div>
                    </div>
                </div> 

                <div class="sm:ml-1 sm:flex bg-gray align-middle sm:mb-4 mt-4 sm:items-center mb-14">
                    <jet-secondary-button v-on:click.prevent="getKriteria1()" >P1</jet-secondary-button>
                    <jet-secondary-button v-on:click.prevent="getKriteria2()" >P2</jet-secondary-button>
                    <jet-secondary-button v-on:click.prevent="getKriteria3()" >P3</jet-secondary-button>
                    <jet-secondary-button v-on:click.prevent="getKriteria4()" >P4</jet-secondary-button>
                    <jet-secondary-button v-on:click.prevent="getKriteria5()" >P5</jet-secondary-button>
                </div>

                <div class="mt-4">
                    <div v-if="session === 1">
                        <div>
                            <label>P1</label>
                            <div>
                                <jet-input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4" placeholder="Index Kriteria 0-1"
                                            ref="index"
                                            v-model="form.singleIndex[session-1]"
                                            @keyup.enter="update" />

                            </div>
                            
                            <jet-input-error :message="form.errors.singleIndex" class="mt-2" />
                        </div>

                        <div v-for="item in kriteria1" :key="item.id">
                            <div v-if="item === null"> Tidak ada Kriteria </div>
                            <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                            <div>
                                <jet-input type="number" min="0" max="1" step="0.1" class="mt-1 block w-3/4" placeholder="Index Kriteria 0-1"
                                            ref="index"
                                            v-model="form.index[item.kriteriaIndex]"
                                            @keyup.enter="update" />

                                
                            </div>
                        
                        </div>
                        <div>
                            <jet-input-error :message="form.errors.index" class="mt-2" />  
                        </div>
                    </div>

                    <div v-if="session === 2">
                        <div>
                            <label>P2</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                v-model="form.singleIndex[session-1]"
                                @keyup.enter="create"
                            />
                            
                            <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                        </div>                        
                        <div v-for="item in kriteria2" :key="item.id">
                            <div v-if="item === null"> Tidak ada Kriteria </div>
                            <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                v-model="form.index[item.kriteriaIndex]"
                                @keyup.enter="create"
                            />
                                 
                        </div>
                        <div>
                            <jet-input-error :message="form.errors.index" class="mt-2" />  
                        </div>                        
                    </div>

                    <div v-if="session === 3">
                        <div>
                            <label>P3</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                v-model="form.singleIndex[session-1]"
                                @keyup.enter="create"
                            />
                            
                            <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                        </div>                        
                        <div v-for="item in kriteria3" :key="item.id">
                            <div v-if="item === null"> Tidak ada Kriteria </div>
                            <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                v-model="form.index[item.kriteriaIndex]"
                                @keyup.enter="create"
                            />
                            
                        </div>
                        <div>
                            <jet-input-error :message="form.errors.index" class="mt-2" />  
                        </div>                        
                    </div>                                        
                </div>                         

                    <div v-if="session === 4">
                        <div>
                            <label>P4</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                v-model="form.singleIndex[session-1]"
                                @keyup.enter="create"
                            />
                            
                            <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                        </div>                         
                        <div v-for="item in kriteria4" :key="item.id">
                            <div v-if="item === null"> Tidak ada Kriteria </div>
                            <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                v-model="form.index[item.kriteriaIndex]"
                                @keyup.enter="create"
                            />
                            
                        </div>
                        <div>
                            <jet-input-error :message="form.errors.index" class="mt-2" />  
                        </div>                        
                    </div>

                    <div v-if="session === 5">
                        <div>
                            <label>P5</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                min="0"
                                max="1"
                                scale="0.1"
                                v-model.number="form.singleIndex[session-1]"
                                @keyup.enter="create"
                            />
                            
                            <jet-input-error :message="form.errors.singleIndex" class="mt-2" />  
                        </div>                         
                        <div v-for="item in kriteria5" :key="item.id">
                            <div v-if="item === null"> Tidak ada Kriteria </div>
                            <label>{{item.nama}} - {{item.sub_kriteria}}</label>
                            <jet-input type="number" class="mt-1 block w-3/4" placeholder="Index"
                                ref="index"
                                v-model="form.index[item.kriteriaIndex]"
                                @keyup.enter="create"
                            />
                                      
                        </div>
                        <div>
                            <jet-input-error :message="form.errors.index" class="mt-2" />  
                        </div>                        
                    </div>                                    
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="create" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Create
                </jet-button>
            </template>
        </jet-dialog-modal>
    </div>
</template>
<script>
import JetButton from '@/Jetstream/Button.vue'
import JetDialogModal from '@/Jetstream/DialogModal.vue'
import JetInput from '@/Jetstream/Input.vue'
import JetInputError from '@/Jetstream/InputError.vue'
import JetSecondaryButton from '@/Jetstream/SecondaryButton.vue'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
    },
    props:{
        kriterias:Array,
    },

    data() {
        return {

            session:0,
            kriteria1:[],
            kriteria2:[],
            kriteria3:[],
            kriteria4:[],
            kriteria5:[],

            creatingIndexKriteria: false,

            form: this.$inertia.form({
                periode_awal: '',
                periode_akhir: '',
                kriteria: [],
                sub_kriteria: [],
                index: [],
                singleKriteria:[],
                singleIndex:[],
            })
        }
    },

    methods: {
        getKriteria1(){
            this.session = 1;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P1';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P1'){
                    this.kriteria1[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria1[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria1[j].sub_kriteria;
                    this.kriteria1[j].kriteriaIndex = i;
                    
                    j++;
                }
            }
        },
        
        getKriteria2(){
            this.session = 2;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P2';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P2'){
                    this.kriteria2[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria2[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria2[j].sub_kriteria;
                    this.kriteria2[j].kriteriaIndex = i;
                    j++;
                    
                }
            }
        },

        getKriteria3(){
            this.session = 3;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P3';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P3'){
                    this.kriteria3[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria3[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria3[j].sub_kriteria;
                    this.kriteria3[j].kriteriaIndex = i;
                    j++;
                        
                }                
            }            
        },

        getKriteria4(){
            this.session = 4;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P4';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P4'){
                    this.kriteria4[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria4[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria4[j].sub_kriteria;
                    this.kriteria4[j].kriteriaIndex = i;
                    j++;            
                }                
            }                
        },

        getKriteria5(){
            this.session = 5;
            var kriteria = this.kriterias;
            var j=0;
            this.form.singleKriteria[this.session-1] = 'P5';
            for(var i=0;i<= kriteria.length-1;i++){
                if(kriteria[i].nama == 'P5'){
                    this.kriteria5[j] = kriteria[i];
                    this.form.kriteria[i] = this.kriteria5[j].nama;
                    this.form.sub_kriteria[i] = this.kriteria5[j].sub_kriteria;
                    this.kriteria5[j].kriteriaIndex = i;
                    j++;                
                }                
            }            
        }, 

        createIndexKriteria() {
            this.creatingIndexKriteria = true;

        },

        create() {
            this.form.post(route('indexKriteria.store'), {
                preserveScroll: true,
                onSuccess: () => [
                    this.closeModal(),
                    this.form.reset()
                ],
                onError: () => this.$refs.index.focus(),
            })
        },

        closeModal() {
            this.creatingIndexKriteria = false

            this.form.reset()
        },
    },
}
</script>
