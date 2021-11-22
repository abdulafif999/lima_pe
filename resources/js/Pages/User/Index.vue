<template>
    <app-layout title="User">
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                User List
                <jet-nav-link class="float-right" :href="route('user.create')" v-if="$page.props.permission.user.create"> 
                    <jet-button>
                        Create New
                    </jet-button> 
                </jet-nav-link>               
            </h2>
        </template>

        <div class="py-12">             
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    
                    <div class="flex flex-col">
                        <div class="-my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="py-2 align-middle inline-block min-w-full sm:px-6 lg:px-8">
                            <div class="shadow overflow-hidden border-b border-gray-200 sm:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead class="bg-gray-50">
                                <tr>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Name
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Status
                                    </th>
                                    <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                    Role
                                    </th>
                                    <th scope="col" class="relative px-6 py-3">
                                    <span class="sr-only">Edit</span>
                                    </th>
                                </tr>
                                </thead>
                                <tbody class="bg-white divide-y divide-gray-200">
                                <tr v-for="user in users" :key="user.email">
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="flex items-center">
                                        <div class="ml-4">
                                            <div class="text-sm font-medium text-gray-900">
                                                {{ user.name }}
                                            </div>
                                            <div class="text-sm text-gray-500">
                                                {{ user.email }}
                                            </div>
                                        </div>
                                        <div v-for="random in chart.series" :key="random.series">
                                            {{random}}
                                        </div>                                        
                                    </div>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap">
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                        Active
                                    </span>
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                    {{ user.role }}
                                    </td>
                                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                        <jet-nav-link 
                                            :href="route('user.show', user.id)"
                                            class = "ml-2"
                                            v-if="user.can.view"
                                        > Show </jet-nav-link>
                                        <jet-nav-link 
                                            :href="route('user.edit', user.id)"
                                            class = "ml-2"
                                            v-if="user.can.update"
                                        > Edit </jet-nav-link>
                                    </td>
                                </tr>
                                </tbody>
                            </table>
                            </div>
                        </div>

                        </div>
                    </div>             
                </div>
            </div>
        </div>
    </app-layout>
</template>

<script>
    import { defineComponent } from 'vue'
    import AppLayout from '@/Layouts/AppLayout.vue'
    import JetNavLink from '@/Jetstream/NavLink.vue'


    export default defineComponent({
        components: {
            AppLayout,
            JetNavLink
        },
        props:{
            users:Array,
            chart:Object
        },
        data(){
            return {
                series: [50, 80, 57, 15, 25, 15]
            }
        }
    })
</script>
