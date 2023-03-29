<template>
    <div class="flex justify-center bg-white py-1.5">
        <nav aria-label="Pagination">
            <ul class="list-style-none mb-6 flex">
                <li>
                    <a
                        class="pointer-events-none relative block rounded bg-transparent py-1.5 px-3 text-sm text-neutral-500 transition-all duration-300 dark:text-neutral-400"
                    >Previous</a>
                </li>
                <li>
                    <a
                        class="relative block rounded bg-transparent py-1.5 px-3 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100  dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                        href="#!"
                    >1</a
                    >
                </li>
                <li aria-current="page">
                    <a
                        class="relative block rounded bg-green-300 py-1.5 px-3 text-sm font-medium text-success-700 transition-all duration-300"
                        href="#!"
                    >2
                        <span
                            class="absolute -m-px h-px w-px overflow-hidden whitespace-nowrap border-0 p-0 [clip:rect(0,0,0,0)]"
                        >(current)</span
                        >
                    </a>
                </li>
                <li>
                    <a
                        class="relative block rounded bg-transparent py-1.5 px-3 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                        href="#!"
                    >3</a
                    >
                </li>
                <li>
                    <a
                        class="relative block rounded bg-transparent py-1.5 px-3 text-sm text-neutral-600 transition-all duration-300 hover:bg-neutral-100 dark:text-white dark:hover:bg-neutral-700 dark:hover:text-white"
                        href="#!"
                    >Next</a
                    >
                </li>
            </ul>
        </nav>
    </div>
</template>

<script>
export default {
    name: "Pagination"
}
</script>

<style scoped>

</style>
