<script setup>
defineProps({ modelValue: String })
defineEmits(['update:model-value'])
</script>

<template>
    <div class="relative mb-4 flex w-full flex-wrap items-stretch">
        <div class="relative z-0 w-full mb-1 group">
            <input
                type="text"
                :value="modelValue"
                @input="$emit('update:model-value', $event.target.value)"
                name="floating_email"
                id="floating_search"
                class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-gray-400 dark:border-gray-600 dark:focus:border-purple-500 focus:outline-none focus:ring-0 focus:border-purple-600 peer"
                placeholder=" " required />
            <label for="floating_search" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-purple-600 peer-focus:dark:text-purple-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Search Artist By Name</label>
        </div>
    </div>
</template>
