<script setup>
import { onMounted, ref } from 'vue';

const model = defineModel({
    type: String,
    required: true,
});

const input = ref(null);

onMounted(() => {
    if (input.value.hasAttribute('autofocus')) {
        input.value.focus();
    }
});

defineProps({
    options: {
        type: Object,
        required: true,
    },
    selectedColumn: {
        type: String,
        required: true,
    },
})

defineExpose({ focus: () => input.value.focus() });
</script>

<template>
    <select
        class="border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm"
        v-model="model"
        ref="input"
    >
        <option v-for="option in options" :key="option.id" :value="option.id">{{ option[selectedColumn] }}</option>
    </select>
</template>
