<template>
    <div>
        <jet-button @click="createKriteria">
            New Kriteria
        </jet-button>

        <!-- Delete Account Confirmation Modal -->
        <jet-dialog-modal :show="creatingKriteria" @close="closeModal">
            <template #title>
                Create Kriteria
            </template>

            <template #content>
                <div class="mt-4">
                    <select  class="border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm mt-1 block w-3/4"
                        v-model="form.nama">
                                        
                        <option value="" disabled selected>Select Kriteria</option>
                        <option value="P1">P1</option>
                        <option value="P2">P2</option>
                        <option value="P3">P3</option>
                        <option value="P4">P4</option>
                        <option value="P5">P5</option>
                    </select>

                    <jet-input-error :message="form.errors.nama" class="mt-2" />
                </div>
                <div class="mt-4">
                    <jet-input type="text" class="mt-1 block w-3/4" placeholder="Sub Kriteria"
                                ref="sub_kriteria"
                                v-model="form.sub_kriteria"
                                @keyup.enter="create" />

                    <jet-input-error :message="form.errors.sub_kriteria" class="mt-2" />
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
            creatingKriteria: false,

            form: this.$inertia.form({
                nama: '',
                sub_kriteria: '',
                keterangan: ''
            })
        }
    },

    methods: {
        createKriteria() {
            this.creatingKriteria = true;

            setTimeout(() => this.$refs.nama.focus(), 250)
        },

        create() {
            this.form.post(route('kriteria.store'), {
                preserveScroll: true,
                onSuccess: () => this.closeModal(),
                onError: () => this.$refs.nama.focus(),
                onFinish: () => this.form.reset(),
            })
        },

        closeModal() {
            this.creatingKriteria = false

            this.form.reset()
        },
    },
}
</script>
