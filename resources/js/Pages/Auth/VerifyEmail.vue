<template>
    <div>
        You need to verified first to see this page!
    </div>
    <div>
        <Link :href="route('verification.send')" method="post" as="button" class="text-indigo-600 dark:text-indigo-400 cursor-pointer">
            Resend verification email
        </Link>
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/vue3'
import { route } from 'ziggy'
</script>
