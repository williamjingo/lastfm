<script setup>
import AppLayout from '@/Layouts/AppLayout.vue';
import Welcome from '@/Components/Welcome.vue';
import SearchInputText from "@/Components/Search/SearchInputText.vue";
import AlbumTable from "@/Components/Album/AlbumTable.vue";
import {ref, watch} from "vue";
import debounce from "lodash/debounce";
import {router} from "@inertiajs/vue3";
import {open_new_tab} from "../utils";


let props = defineProps({search_results: Object, albums: Object, filters: {type: Object, default: {query: ""}}})

let search = ref(props.filters.query)

watch(search, debounce((value) => {
    if(!value) return router.get(route('artists.index'))

    router.get(route('albums.index'), {query: value}, {
        preserveState: true,
        replace:true
    })
}, 500))

/**
 * Function handles $emits
 * @param action
 * @param data
 */
const handleUserEvent = ({action, data}) => {
    // open new tab
    if(action === "open-new-tab") return open_new_tab(data.url)

    // // remove from favourites
    // if(action === "remove-artist") return removeFavourite(data)
    //
    // // add to favourites
    // if(action === "add-to-favourite") return addToFavourites(data)
}


</script>


<template>
    <AppLayout title="Dashboard">
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
