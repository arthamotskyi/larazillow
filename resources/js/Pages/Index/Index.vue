<template>
    <MainLayout>
        <div>Index</div>
        <div>
            The message is {{ message }}
        </div>
    </MainLayout>
</template>

<script setup>
    import MainLayout from '../../Layouts/MainLayout.vue'
    defineProps({
        message: String
    });
</script>
