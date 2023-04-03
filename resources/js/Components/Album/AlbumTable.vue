<script setup>
import Pagination from "@/Components/Pagination.vue";

defineProps({
    albums: Object,
})

defineEmits(['album-click'])

const headers = ["Album", "MBID", "Favourite", "Action"]
</script>

<template>
    <div class="relative overflow-x-auto shadow-md">
        <table class="min-w-full text-sm text-left text-gray-500 dark:text-gray-400">
            <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
            <tr>
                <th scope="col" class="px-6 py-3" v-for="th in headers" :key="th" v-text="th"/>
            </tr>
            </thead>
            <tbody>
            <tr v-for="album in albums.data" :key="album.id" class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-600">
                <th scope="row" class="flex items-center px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                    <img v-if="album.image" class="w-10 h-10 rounded-full" :src="album.image" :alt="album.name">
                    <div class="pl-3">
                        <div class="text-base font-semibold" v-text="album.name"/>
                        <div class="font-normal text-gray-500" v-text="`Artist: ${album.artist}`"/>
                    </div>
                </th>
                <td class="py-4">{{ album.mbid }}</td>
                <td class="py-4">
                    <button
                        type="button"
                        @click="$emit('album-click', {action: 'add-to-favourite', data: album})"
                        class="text-white bg-purple-700 hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">Add To Favourites</button>
                </td>
                <td class="py-4">
                    <button
                        type="button"
                        @click="$emit('album-click', {action: 'open-new-tab', data: album})"
                        class="text-white bg-purple-700 hover:bg-indigo-800 focus:outline-none focus:ring-4 focus:ring-indigo-300 font-medium rounded-full text-sm px-5 py-2.5 text-center mb-2 dark:bg-indigo-600 dark:hover:bg-indigo-700 dark:focus:ring-indigo-900">Open In New Tab</button>
                </td>
            </tr>
            </tbody>
        </table>
        <Pagination v-if="albums.data && albums.data.length > 1" :links="albums.meta.links" />
    </div>
</template>

