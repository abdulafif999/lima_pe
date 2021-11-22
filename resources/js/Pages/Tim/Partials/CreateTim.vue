<template>
    <div >
        <jet-button @click="createTim">
            Buat Tim Baru
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingTim" @close="closeModal">
            <template #title>
                Create Tim
            </template>

            <template #content>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Nama Tim"
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
            creatingTim: false,

            form: this.$inertia.form({
                nama: '',
            })
        }
    },

    methods: {
        createTim() {
            this.creatingTim = true;

            setTimeout(() => this.$refs.nama.focus(), 250)
        },

        create() {
            this.form.post(route('tim.store'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.creatingTim = false

            this.form.reset()
        },
    },
}
</script>
