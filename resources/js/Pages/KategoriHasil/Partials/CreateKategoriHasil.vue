<template>
    <div>
        <jet-button @click="createKategoriHasil">
            Create New
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingKategoriHasil" @close="closeModal">
            <template #title>
                Create Kategori Hasil
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai Atas"
                                ref="nilai_atas"
                                v-model="form.nilai_atas"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nilai_atas" class="mt-2" />                    
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nilai Bawah"
                                ref="nilai_bawah"
                                v-model="form.nilai_bawah"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nilai_bawah" class="mt-2" />                    
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Kategori"
                                ref="nama"
                                v-model="form.nama"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
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
            creatingKategoriHasil: false,

            form: this.$inertia.form({
                nilai_atas:'',
                nilai_bawah:'',
                nama: '',
                
            })
        }
    },

    methods: {
        createKategoriHasil() {
            this.creatingKategoriHasil = true;

            setTimeout(() => this.$refs.nilai_atas.focus(), 250)
        },

        create() {
            this.form.post(route('kategoriHasil.store'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nilai_atas.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.creatingKategoriHasil = false

            this.form.reset()
        },
    },
}
</script>
