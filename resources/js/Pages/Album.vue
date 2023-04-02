<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import SearchInputText from "@/Components/Search/SearchInputText.vue";
import AlbumTable from "@/Components/Album/AlbumTable.vue";
import FormErrors from "@/Components/FormErrors.vue";
import FavouriteAlbumTable from "@/Components/Album/FavouriteAlbumTable.vue";
import {ref, watch} from "vue";
import debounce from "lodash/debounce";
import {router, useForm} from "@inertiajs/vue3";
import {open_new_tab} from "../utils";


let props = defineProps({search_results: Object, albums: Object, filters: {type: Object, default: {query: ""}}})

let search = ref(props.filters.query)

const form = useForm({
    name: undefined,
    artist: undefined,
    image: undefined,
    mbid: undefined,
    url: undefined,
})

watch(search, debounce((value) => {
    if(!value) return router.get(route('albums.index'))

    router.get(route('albums.index'), {query: value}, {
        preserveState: true,
        replace:true
    })
}, 500))

const albumValidateTransform = album => {
    const asArray = Object.entries(album);
    const filtered = asArray.filter(([key, value]) => value && key !== "id")
    return Object.fromEntries(filtered)
}

const addToFavourites = album => {
    const validated = albumValidateTransform(album)

    form.transform(data => ({...validated})).post(route('albums.store') );
}

const removeFavourite = ({id}) => form.delete(route('albums.destroy', id));

/**
 * Function handles $emits
 * @param action
 * @param data
 */
const handleUserEvent = ({action, data}) => {
    // open new tab
    if(action === "open-new-tab") return open_new_tab(data.url)

    // remove from favourites
    if(action === "remove-album") return removeFavourite(data)

    // add to favourites
    if(action === "add-to-favourite") return addToFavourites(data)
}


</script>


<template>
    <AppLayout title="Dashboard">
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                    <div>
                        <h1 class="px-6 mt-8 text-2xl font-medium text-gray-900">
                            Favourite Albums
                        </h1>
                        <div class="bg-gray-200 bg-opacity-25">
                            <div class="relative overflow-x-auto shadow-md">
                                <FormErrors v-if="Object.keys(form.errors).length" :errors="form.errors" />
                                <FavouriteAlbumTable :albums="albums" @album-click="handleUserEvent" />
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
                            <AlbumTable :albums="search_results || {}" @album-click="handleUserEvent"/>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </AppLayout>
</template>
