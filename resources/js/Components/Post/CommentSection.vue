<script setup>
import { getCurrentInstance, ref, watch } from 'vue';
import Checkbox from '../Checkbox.vue';
import { router } from '@inertiajs/vue3';

let selectedComments = ref([]);

const props = defineProps({
    comments: Object,
});

const { emit } = getCurrentInstance();

const openDialog = () => {
    emit('openCommentDialog', selectedComments.value);
}
</script>

<template>
    <div class="flex justify-between">
        <h4 class="mt-5">{{ $t('Comments') }} {{ comments.length }}</h4>
        <div class="flex justify-end">
            <button class="text-red-700" @click="openDialog" v-if="selectedComments.length > 0">
                <i class="pi pi-trash"></i>
            </button>
        </div>
    </div>
    <hr class="mt-2">
    <div class="comments max-h-80 overflow-scroll scrollbar-hide" v-if="comments.length > 0">
        <Timeline :value="comments" class="w-full md:w-20rem">
            <template #content="slotProps">
                <div class="comment">
                    <div class="flex mt-3 ml-3">
                        <div class="m-3 mt-0">
                            <Checkbox :checked="selectedComments" :value="slotProps.item.id" v-model="selectedComments"
                                v-if="slotProps.item.is_owner" />
                        </div>
                        <Avatar :label="slotProps.item.user.name[0].toUpperCase()" shape="circle" />
                        <div class="m-3 mt-0 mb-0">
                            <div class="font-semibold">{{ slotProps.item.user.name }}</div>
                            <div class="text-xs text-gray-500">{{ slotProps.item.created_at }}</div>
                        </div>
                    </div>
                    <div class="ml-16 mt-3">
                        <div class="text-xs text-gray-500">{{ slotProps.item.content }}</div>
                    </div>
                </div>
            </template>
        </Timeline>
    </div>

    <div v-else>
        <div class="text-gray-500 mt-3">{{ $t('No comments yet') }}</div>
    </div>
</template>
