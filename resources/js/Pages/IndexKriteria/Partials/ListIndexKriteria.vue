<template>
    <div>
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div class="flex flex-col">
            <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                    <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                        <table class="min-w-full divide-y divide-gray-200" >
                            <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col"
                                        class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                        Periode Index
                                    </th>                                                                                                        
                                    <th scope="col" class="relative px-6 py-3">
                                        <span class="sr-only">Edit</span>
                                        <span class="sr-only">Delete</span>
                                    </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200" :v-on:show="getPeriode()">
                                <tr v-for="periode in periode" :key="periode.id">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{ periode.periode_awal }} s/d {{periode.periode_akhir}}
                                        </div>
                                    </td>                                                                 
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="showIndexKriteria(periode)" class="text-indigo-600 hover:text-indigo-900">Show Index</jet-secondary-button>
                                        <jet-secondary-button href="#" @click.prevent="updateIndexKriteria(periode)" class="text-indigo-600 hover:text-indigo-900">Edit Periode </jet-secondary-button>
                                        <jet-button href="#" @click.prevent="ConfirmingIndexKriteriaDeletion(periode)" class="text-indigo-600 hover:text-indigo-900">Hapus</jet-button>
                                    </td>                                    
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Update Kriteria Modal -->
        <jet-dialog-modal :show="updatingIndexKriteria" @close="closeModal">
            <template #title>
                Update Index Kriteria
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="date" class="mt-1 block w-3/4" placeholder="Periode Awal"
                                ref="periode_awal"
                                v-model="form.periode_awal"
                                @keyup.enter="update" /> Periode Awal

                    <jet-input-error :message="form.errors.periode_awal" class="mt-2" />
                </div>  

                <div class="mt-4">
                    <jet-input type="date" class="mt-1 block w-3/4" placeholder="Periode Akhir"
                                ref="periode_akhir"
                                v-model="form.periode_akhir"
                                @keyup.enter="update" /> Periode Akhir

                    <jet-input-error :message="form.errors.periode_akhir" class="mt-2" />
                </div>  
            
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="update" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
                </jet-button>
            </template>
        </jet-dialog-modal>    

        <!-- Delete Modal !-->

        <jet-dialog-modal :show="deletingIndexKriteria" @close="deletingIndexKriteria = false">
            <template #title>
                Delete Index Kriteria
            </template>
            <template #content>
                Yakin ingin menghapus??
            </template>

            <template #footer>
                <jet-secondary-button @click="deletingIndexKriteria = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="deleteIndexKriteria" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Delete Index Kriteria
                </jet-button>
            </template>
        </jet-dialog-modal>          

        <jet-dialog-modal :show="showingKriteria" @close="closeModal">
            <template #title>
                Daftar Index Kriteria
            </template>

            <template #content>
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Kriteria
                            </th>       
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Sub Kriteria
                            </th>                                           
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Index
                            </th>                                                                                                          
                            <th scope="col" class="relative px-6 py-3">
                                <span class="sr-only">Edit</span>
                                <span class="sr-only">Delete</span>
                            </th>                                    
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="kriteria in show.selectedIndex" :key="kriteria.kriteria">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{kriteria.kriteria}}
                                        </div>
                                    </td>                                                                                              
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{kriteria.sub_kriteria}}
                                        </div>
                                    </td>   
                                    <td class="px-6 py-4 whitespace-nowrap">
                                        <div class="flex items-center">
                                            {{kriteria.index}}
                                        </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-secondary-button href="#" @click.prevent="updateIndex(kriteria)" class="text-indigo-600 hover:text-indigo-900">Edit</jet-secondary-button>
                                    </td>                                                                                                             
                                </tr>

                                <!-- More people... -->
                            </tbody>
                        </table>
            </template>

            <template #footer>
                <jet-secondary-button @click="closeModal">
                    Close
                </jet-secondary-button>
            </template>

        </jet-dialog-modal>

        <jet-dialog-modal :show="updateSingleIndex" @close="updateSingleIndex = false">
            <template #title>
                Ubah Index
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Kriteria"

                                v-model="form.kriteria"
                                disabled />
                </div> 

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Sub Kriteria"
                                
                                v-model="form.sub_kriteria"
                                disabled />

                </div> 

                <div class="mt-4">
                    <jet-input type="number" step="0.1" class="mt-1 block w-3/4" placeholder="Index"
                                v-model="form.index"
                                @keyup.enter="updateSingle" />

                    <jet-input-error :message="form.errors.index" class="mt-2" />
                </div>             
            </template>

            <template #footer>
                <jet-secondary-button @click="updateSingleIndex = false">
                    Cancel
                </jet-secondary-button>

                <jet-button class="ml-2" @click="updateSingle" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    Update
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
import JetCheckbox from '@/Jetstream/Checkbox.vue'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
        JetCheckbox
    },

    props: {
        indexKriterias: Array,
        kriterias:Array
    },

    data() {
        return {
            updatingIndexKriteria: false,
            deletingIndexKriteria: false,
            showingKriteria:false,
            updateSingleIndex:false,
            selectedIndexKriteria: {},
            periode:[],

            form: this.$inertia.form({
                indexId:'',
                periode_awal:'',
                periode_akhir:'',
                kriteria:'',
                sub_kriteria:'',
                index:'',
            }),

            show:this.$inertia.form({
                selectedIndex: [],
            })
        }
    },

    methods: {
        updateIndexKriteria(kriteria) {
            this.updatingIndexKriteria = true;
            this.selectedIndexKriteria = kriteria;
            this.form.periode_awal = kriteria.periode_awal;
            this.form.periode_akhir = kriteria.periode_akhir;
            this.form.indexId = kriteria.id;

        },

        update() {
            this.form.put(route('multiUpdate', this.selectedIndexKriteria.id), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.index.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        updateIndex(kriteria){
            this.updateSingleIndex = true;
            this.selectedIndexKriteria = kriteria;
            this.form.kriteria = kriteria.kriteria;
            this.form.sub_kriteria = kriteria.sub_kriteria;
            this.form.index = kriteria.index;
        },
        updateSingle(){
            this.form.put(route('indexKriteria.update', this.selectedIndexKriteria.id), {
                preserveScroll: true,
                onSuccess: () => {
                    this.updateSingleIndex = false,
                    this.form.reset();
                    this.showIndexKriteria(this.selectedIndexKriteria); 
                },
                onError: () => this.$refs.index.focus(),
                onFinish: () => this.form.reset(),
            })
        },
        ConfirmingIndexKriteriaDeletion(kriteria) {
            this.deletingIndexKriteria = true;
            this.selectedIndexKriteria = kriteria;

        },

        deleteIndexKriteria() {
            this.form.delete(route('indexKriteria.destroy', this.selectedIndexKriteria.id), {
                preserveScroll: true,
                preserveState:true,
                errorBag: 'delete',
                onSuccess: () => {
                    this.closeModal();
                }
            })            
        },
        showIndexKriteria(kriteria){
            this.show.reset();
            this.showingKriteria = true;
            var j=0;
            for(var i=0;i<=this.indexKriterias.length-1;i++){
                if(kriteria.periode_awal == this.indexKriterias[i].periode_awal && kriteria.periode_akhir == this.indexKriterias[i].periode_akhir){
                    this.show.selectedIndex[j] = this.indexKriterias[i];
                    j++;
                }
            }
        },
        getPeriode(){
            var index = 0;
            var tempArray = this.indexKriterias;
            for(var i = 0; i < this.indexKriterias.length;i++){
                for(var j=i+1;j<this.indexKriterias.length;j++){
                    if(this.indexKriterias[i].periode_awal == this.indexKriterias[j].periode_awal && this.indexKriterias[i].periode_akhir == this.indexKriterias[j].periode_akhir){
                        tempArray[i] = this.indexKriterias[i];
                    }
                }
            };

            for(var i = 0; i < tempArray.length-1;i++){
                if(tempArray[i].periode_awal != tempArray[(i+1)].periode_awal && tempArray[i].periode_akhir != tempArray[(i+1)].periode_akhir){
                    this.periode[index] = tempArray[i];
                    index++;
                }

            };
            this.periode[index] = tempArray[tempArray.length-1];
        },

        closeModal() {
            this.updatingIndexKriteria = false,
            this.deletingIndexKriteria = false,
            this.showingKriteria = false,

            this.form.reset()
        },
    },
}
</script>
