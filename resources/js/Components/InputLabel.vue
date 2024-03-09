<script setup>
defineProps({
    value: String,
});
</script>

<template>
    <label class="block font-medium text-m text-gray-600">
        <span v-if="value">{{ value }}</span>
        <span v-else><slot /></span>
    </label>
</template>
