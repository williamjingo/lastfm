<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Pagination from "@/Components/Pagination.vue";
import {ref, watch} from "vue";
import {router} from "@inertiajs/vue3";
import debounce from 'lodash/debounce';


let props = defineProps({search_results: Object, filters: Object})

let search = ref(props.filters.query)

watch(search, debounce((value) => {
    router.get('/artists', {query: value}, {
        preserveState: true,
        replace:true
    })
}, 500))


</script>

<template>
    <AppLayout title="Artists">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">

                    <div>
                        <div class="p-6 lg:p-4 bg-white border-b border-gray-200">
                            <div class="relative mb-4 flex w-full flex-wrap items-stretch">
                                <div class="relative z-0 w-full mb-1 group">
                                    <input type="text" v-model="search" name="floating_email" id="floating_search" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-400 dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                    <label for="floating_search" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Search Artist By Name</label>
                                </div>
                            </div>
                        </div>

                        <div v-if="search_results" class="bg-gray-200 bg-opacity-25">
                            <div class="relative overflow-x-auto shadow-md">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Name
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            MBID
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Streamable
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="artist in search_results.data" :key="artist.id" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <img v-if="artist.image" class="w-10 h-10 rounded-full" :src="artist.image" :alt="artist.name">
                                            <div class="pl-3">
                                                <div class="text-base font-semibold" v-text="artist.name"/>
                                                <div class="font-normal text-gray-500" v-text="`${artist.listners} Listners`"/>
                                            </div>
                                        </th>
                                        <td class="px-6 py-4">{{ artist.mbid }}</td>
                                        <td class="px-6 py-4">{{ artist.streamable }}</td>
                                        <td class="px-6 py-4">
                                            <div class="flex items-center">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 6H5.25A2.25 2.25 0 003 8.25v10.5A2.25 2.25 0 005.25 21h10.5A2.25 2.25 0 0018 18.75V10.5m-10.5 6L21 3m0 0h-5.25M21 3v5.25" />
                                                </svg>
                                            </div>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>

                                <Pagination :links="search_results.meta.links" />

                            </div>



                        </div>
                    </div>



                </div>
            </div>
        </div>
    </AppLayout>
</template>
