<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Pagination from "@/Components/Pagination.vue";
import SearchInputText from "@/Components/Search/SearchInputText.vue";
import FormErrors from "@/Components/FormErrors.vue";
import {ref, watch} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import debounce from 'lodash/debounce';

let props = defineProps({search_results: Object, filters: {type: Object, default: {query: ""}}})

let search = ref(props.filters.query)

const form = useForm({
    name: undefined,
    listners: undefined,
    image: undefined,
    mbid: undefined,
    streamable: undefined,
    url: undefined,
})

const tableHeaders = ["Artist", "MBID", "Streamable", "Favourite", "Action"]
const tableFavouriteHeaders = tableHeaders.filter(value => value !== "Favourite")

watch(search, debounce((value) => {
    if(!value) return router.get(route('artists.index'))

    router.get(route('artists.index'), {query: value}, {
        preserveState: true,
        replace:true
    })
}, 500))

const linkAction = href => window.open(href, '_blank', 'noreferrer')

const artistValidateTransform = artist => {
    const asArray = Object.entries(artist);
    const filtered = asArray.filter(([key, value]) => value && key !== "id")
    let obj = Object.fromEntries(filtered)

    // transform required fields - these fields are by default numeric strings
    return {...obj,
        listners: Number(obj['listners']),
        streamable: Number(obj['streamable'])
    }
}

const addToFavourites = artist => {
    const validated = artistValidateTransform(artist)

    form.transform(data => ({...validated})).post(route('artists.store'));
}

</script>

<template>
    <AppLayout title="Artists">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <h1 class="px-6 mt-8 text-2xl font-medium text-gray-900">
                            Favourite Artists
                        </h1>
                        <div class="bg-gray-200 bg-opacity-25">
                            <div class="relative overflow-x-auto shadow-md">
                                <FormErrors v-if="Object.keys(form.errors).length" :errors="form.errors" />
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3" v-for="th in tableFavouriteHeaders" :key="th" v-text="th"/>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="py-1">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <div class="p-6 lg:p-4 bg-white border-b border-gray-200">
                            <SearchInputText v-model="search" />
                        </div>
                        <div class="bg-gray-200 bg-opacity-25">
                            <div class="relative overflow-x-auto shadow-md">
                                <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400">
                                    <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                        <tr>
                                            <th scope="col" class="px-6 py-3" v-for="th in tableHeaders" :key="th" v-text="th"/>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-if="search_results" v-for="artist in search_results.data" :key="artist.id" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                                        <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                            <img v-if="artist.image" class="w-10 h-10 rounded-full" :src="artist.image" :alt="artist.name">
                                            <div class="pl-3">
                                                <div class="text-base font-semibold" v-text="artist.name"/>
                                                <div class="font-normal text-gray-500" v-text="`${artist.listners} Listners`"/>
                                            </div>
                                        </th>
                                        <td class="py-4">{{ artist.mbid }}</td>
                                        <td class="py-4">{{ artist.streamable }}</td>
                                        <td class="py-4">
                                            <button
                                                type="button"
                                                @click="addToFavourites(artist)"
                                                class="text-white bg-purple-700 hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">Add To Favourites</button>
                                        </td>
                                        <td class="py-4">
                                            <button
                                                type="button"
                                                @click="linkAction(artist.url)"
                                                class="text-white bg-purple-700 hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">Open In New Tab</button>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                                <Pagination v-if="search_results" :links="search_results.meta.links" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </AppLayout>
</template>
