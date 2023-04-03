
<script setup>

defineProps({links: Array})


</script>


<template>
    <div class="flex justify-center bg-white py-1.5 dark:bg-gray-700 dark:text-gray-400">
        <nav aria-label="Pagination">
            <ul class="list-style-none mb-6 flex">
                <li v-for="link in links" :key="link.url">
                    <Component
                        :is="link.url ? 'Link': 'span'"
                        :href="link.url"
                        class="relative block rounded py-1.5 px-3 text-sm text-neutral-600 transition-all duration-300 hover:bg-purple-400 hover:text-white dark:hover:text-white dark:text-white"
                        v-html="link.label"
                        :class="{ 'pointer-events-none relative text-neutral-500': ! link.url, 'bg-purple-400 text-white': link.active }"
                    />
                </li>
            </ul>
        </nav>
    </div>
</template>

