<template>
    <div class="border border-gray-200 dark:border-gray-800 rounded-md p-4 shadow-sm dark:text-gray-300 dark:bg-gray-800">
        <div class="text-gray-500 font-medium">
            <slot name="header" />
        </div>
        <slot/>
    </div>
</template>
