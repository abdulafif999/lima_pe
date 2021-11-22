<template>
    <div>
        <jet-button @click="createTimUnit">
            Buat Tim Baru
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingTimUnit" @close="closeModal">
            <template #title>
                Buat Tim 5P/Unit Baru
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Tim"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>

                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Unit"
                                ref="nama"
                                v-model="form.unit"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.unit" class="mt-2" />

                    <jet-input-error :message="form.errors.unit" class="mt-2" />
                </div>

                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.kategori" >
                        <option value="" disabled selected>Pilih Kategori</option>
                        <option value="Operasional">Operasional</option>
                        <option value="Non-Operasional">Non-Operasional</option>
                    </select>

                    <jet-input-error :message="form.errors.kategori" class="mt-2" />
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

    data() {
        return {
            creatingTimUnit: false,

            form: this.$inertia.form({
                nama: '',
                unit: '',
                kategori:'',
            })
        }
    },

    mounted () {
    },

    methods: {
        createTimUnit() {
            this.creatingTimUnit = true;
        },

        create() {
            this.form.post(route('timUnit.store'), {
                preserveScroll: true,
                preserveState: true,
                onSuccess: () => {
                    this.closeModal();
                    this.form.reset();
                },
                onError:() => this.$refs.nama.focus()
            })
        },

        closeModal() {
            this.creatingTimUnit = false
            this.form.clearErrors()
            this.form.reset()
        },

    },
}
</script>
