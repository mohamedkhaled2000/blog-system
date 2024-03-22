<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from '@/Components/Textarea.vue';
import CommentSection from '@/Components/Post/CommentSection.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { getCurrentInstance, ref } from 'vue';
import axios from 'axios';
import Dialog from 'primevue/dialog';

const { emit } = getCurrentInstance();

const props = defineProps({
    post: Object,
})

let comments = ref(props.post.comments);
let visible = ref(false);

const form = useForm({
    content: {},
});

const submit = (post) => {
    form.post(route('comments.store', post), {
        onFinish: () => form.content = {},
        onSuccess: (res) => {
            updatePost(post)
        },
        preserveScroll: true,
        resetOnSuccess: false,
    });
};

const updatePost = (post) => {
    return axios.get(route('posts.show', post))
        .then(response => {
            comments.value = response.data.data.comments;
        });
}

const deletePost = () => {
    router.delete(route('posts.destroy', props.post.id), {
        preserveScroll: true,
        onSuccess: () => {
            visible.value = false;
            emit('deletePost', props.post.id)
        }
    });
}

const actions = [
    {
        label: 'Update',
        icon: 'pi pi-pencil text-blue-500',
        command: (ele) => {
            router.visit(route('posts.edit', props.post.id));
        }
    },
    {
        label: 'Delete',
        icon: 'pi pi-trash text-red-500',
        command: () => {
            visible.value = true;
        }
    }
];
</script>

<template>
    <Card class="mt-5 max-w-96 block shadow-md border relative" style="overflow: hidden;min-width: 50%">
        <template #header>
            <SpeedDial :model="actions" direction="down" showIcon="pi pi-angle-double-down"
                hideIcon="pi pi-angle-double-up" :style="{ right: '15px', top: '10px' }" v-if="post.is_owner" />

            <div class="flex mt-3 ml-3">
                <Avatar :label="post.user.name[0].toUpperCase()" shape="circle" />
                <div class="ml-3">
                    <div class="font-semibold">{{ post.user.name }}</div>
                    <div class="text-xs text-gray-500">{{ post.created_at }}</div>
                </div>
            </div>
        </template>
        <template #title>{{ post.title }}</template>
        <template #content>
            <div v-html="post.content"></div>

            <div class="flex justify-center">
                <img alt="user header" :src="post.image" v-if="post.image" />
            </div>
        </template>
        <template #footer>
            <form @submit.prevent="submit(post.id)">
                <Textarea v-model="form.content[post.id]" rows="2" cols="3" required />

                <div class="flex gap-3 mt-1">
                    <PrimaryButton>
                        Comment
                    </PrimaryButton>
                </div>
            </form>

            <CommentSection :comments="comments" />
        </template>
    </Card>

    <Dialog v-model:visible="visible" modal header="Delete post" :style="{ width: '25rem' }">
        <div class="text-center">
            <p>Are you sure you want to delete this post?</p>
        </div>

        <template #footer>
            <Link class="text-red-700" @click="deletePost">
            Delete
            </Link>
        </template>
    </Dialog>
</template>
