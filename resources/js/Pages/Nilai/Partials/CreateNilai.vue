<template>
    <div>
        <jet-button @click="createNilai">
            Create New
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingNilai" @close="closeModal">
            <template #title>
                Create Nilai
            </template>

            <template #content>


                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.kriteria_id" >
                        <option value="" disabled selected>Select Category</option>
                        <option v-for="kriteria in kriterias" :key="kriteria.id" :value="kriteria.id">{{kriteria.nama}} {{'-'}} {{ kriteria.sub_kriteria }}</option>
                    </select>

                    <jet-input-error :message="form.errors.kriteria_id" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="form.nilai_bawah"
                                @keyup.enter="create" min="0" max="100"/>

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="number" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="form.nilai_atas"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />
                </div>                

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Keterangan"
                                ref="keterangan"
                                v-model="form.keterangan"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.keterangan" class="mt-2" />
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
import { Inertia } from '@inertiajs/inertia'

export default {
    components: {
        JetButton,
        JetDialogModal,
        JetInput,
        JetInputError,
        JetSecondaryButton,
    },

    props: {
        kriterias: Array
    },

    data() {
        return {
            creatingNilai: false,

            form: this.$inertia.form({
                kriteria_id: '',
                nilai_bawah: '',
                nilai_atas: '',
                keterangan: '',
            })
        }
    },

    mounted () {
    },

    methods: {
        createNilai() {
            this.fetchKriterias();
            this.creatingNilai = true;

            setTimeout(() => this.$refs.nilai.focus(), 250)
        },

        fetchKriterias() {
            Inertia.reload({ only: ['kriterias'] })
        },

        create() {
            this.form.post(route('nilai.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
            })
        },

        closeModal() {
            this.creatingNilai = false
            this.form.clearErrors()
            this.form.reset()
        },
    },
}
</script>
