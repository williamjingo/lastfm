<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import Pagination from "@/Components/Pagination.vue";
import SearchInputText from "@/Components/Search/SearchInputText.vue";
import FormErrors from "@/Components/FormErrors.vue";
import FavouriteArtistTable from "@/Components/Artist/FavouriteArtistTable.vue";
import ArtistTable from "@/Components/Artist/ArtistTable.vue";
import {ref, watch} from "vue";
import {router, useForm} from "@inertiajs/vue3";
import debounce from 'lodash/debounce';
import {open_new_tab} from "../utils";


let props = defineProps({search_results: Object, artists: Object, filters: {type: Object, default: {query: ""}}})

let search = ref(props.filters.query)

const form = useForm({
    name: undefined,
    listners: undefined,
    image: undefined,
    mbid: undefined,
    streamable: undefined,
    url: undefined,
})

watch(search, debounce((value) => {
    if(!value) return router.get(route('artists.index'))

    router.get(route('artists.index'), {query: value}, {
        preserveState: true,
        replace:true
    })
}, 500))

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

    form.transform(data => ({...validated})).post(route('artists.store') );
}

const removeFavourite = ({id}) => form.delete(route('artists.destroy', id));

const handleUserEvent = ({action, data}) => {
    // open new tab
    if(action === "open-new-tab") return open_new_tab(data.url)

    // remove from favourites
    if(action === "remove-artist") return removeFavourite(data)

    // add to favourites
    if(action === "add-to-favourite") return addToFavourites(data)
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
                                <FavouriteArtistTable :artists="artists" @artist-click="handleUserEvent" />
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
                            <ArtistTable :artists="search_results || {}" @artist-click="handleUserEvent"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
