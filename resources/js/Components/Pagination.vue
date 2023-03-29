
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
                        class="relative block rounded bg-transparent py-1.5 px-3 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                        v-html="link.label"
                        :class="{ 'pointer-events-none relative block rounded bg-transparent py-1.5 px-3 text-sm text-neutral-500 transition-all duration-300 dark:text-neutral-400': ! link.url, 'dark:hover:text-white bg-indigo-400': link.active }"
                    />
                </li>
            </ul>
        </nav>
    </div>
</template>

