<script setup>

    defineProps({
        comments: Object,
    });

</script>

<template>
    <h4 class="mt-5">Comments {{ comments.length }}</h4>
    <hr class="mt-2">
    <div class="comments max-h-80 overflow-scroll" v-if="comments.length > 0">
        <div class="comment" v-for="comment in comments" :key="comment.id">
            <div class="flex mt-3 ml-3">
                <Avatar :label="comment.user.name[0].toUpperCase()" shape="circle" />
                <div class="ml-3">
                    <div class="font-semibold">{{ comment.user.name }}</div>
                    <div class="text-xs text-gray-500">{{ comment.created_at }}</div>
                </div>
            </div>
            <div class="ml-16 mt-3">
                <div class="text-xs text-gray-500">{{ comment.content }}</div>
            </div>
        </div>
    </div>

    <div v-else>
        <div class="text-gray-500 mt-3">No comments yet</div>
    </div>
</template>
