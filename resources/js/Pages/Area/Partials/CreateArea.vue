<template>
    <div>
        <jet-button @click="createArea">
            Buat Unit Baru
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingArea" @close="closeModal">
            <template #title>
                Create Unit
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Area"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>
                <div class="mt-4">
                    <select class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.kategori" >
                        <option value="" disabled selected>Kategori Unit</option>
                        <option value="Pabrik">Operasional</option>
                        <option value="Pabrik">Non-Operasional</option>
                    </select>

                    <jet-input-error :message="form.errors.kategori" class="mt-2" />
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
            creatingArea: false,

            form: this.$inertia.form({
                nama: '',
                kategori: '',
                keterangan: '',                
            })
        }
    },

    methods: {
        createArea() {
            this.creatingArea = true;

            setTimeout(() => this.$refs.nama.focus(), 250)
        },

        create() {
            this.form.post(route('area.store'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.creatingArea = false

            this.form.reset()
        },
    },
}
</script>
