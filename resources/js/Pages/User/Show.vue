<template>
    <app-layout title="User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User Detail
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    Nama : {{user.name}} <br />
                    Email : {{user.email}} <br />
                    Role : {{user.role}} <br />
                    Created At : {{user.created_at}} <br />
                    Updated At : {{user.updated_at}} <br />
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    

    export default defineComponent({
        components: {
            AppLayout,
        },
        props:{
            user:Array
        }
    })
</script>
