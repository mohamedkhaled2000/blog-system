<script setup>
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from '@/Components/Textarea.vue';
import CommentSection from '@/Components/Post/CommentSection.vue';
import { Link, router, useForm } from '@inertiajs/vue3';
import { getCurrentInstance, ref } from 'vue';
import axios from 'axios';
import Dialog from 'primevue/dialog';
import SplitButton from 'primevue/splitbutton';
import { useToast } from 'primevue/usetoast';
import { useI18n } from 'vue-i18n';
const { t } = useI18n();

const toast = useToast();
const { emit } = getCurrentInstance();

const props = defineProps({
    post: Object,
})

let comments = ref(props.post.comments);
let visible = ref(false);
let visibleComment = ref(false);
let selectedCommentsId = ref([]);

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
            emit('deletePost', props.post.id);
            toast.add({ severity: 'success', summary: 'Success', group: 'br', detail: 'Post deleted successfulty', life: 3000 });
        }
    });
}

const deletePermanentlyPost = () => {
    router.delete(route('posts.force-delete', props.post.id), {
        preserveScroll: true,
        onSuccess: () => {
            visible.value = false;
            emit('deletePost', props.post.id);
            toast.add({ severity: 'success', summary: 'Success', group: 'br', detail: 'Post deleted successfulty', life: 3000 });
        }
    });
}

const deleteComments = () => {
    router.delete(route('comments.destroy'), {
        data: {
            comments: selectedCommentsId.value
        },
        preserveScroll: true,
        onSuccess: () => {
            visibleComment.value = false;
            comments.value = comments.value.filter(comment => !selectedCommentsId.value.includes(comment.id));
            toast.add({ severity: 'success', summary: 'Success', group: 'br', detail: 'Comments deleted successfulty', life: 3000 });
        }
    });
}

const openCommentDialog = (selectedComments) => {
    selectedCommentsId.value = selectedComments;
    visibleComment.value = true;
}

const actions = [
    {
        label: t('Update'),
        icon: 'pi pi-pencil text-blue-500',
        command: (ele) => {
            router.visit(route('posts.edit', props.post.id));
        }
    },
    {
        label: t('Delete'),
        icon: 'pi pi-trash text-red-500',
        command: () => {
            visible.value = true;
        }
    },
];


</script>

<template>
    <Card class="mt-5 max-w-96 block shadow-md border relative" style="overflow: hidden;min-width: 50%">
        <template #header>
            <SplitButton :model="actions" direction="down" class="absolute" showIcon="pi pi-angle-double-down"
                hideIcon="pi pi-angle-double-up" :style="{ right: '15px', top: '10px' }" v-if="post.is_owner && locale() == 'en'" />

            <SplitButton :model="actions" direction="down" class="absolute" showIcon="pi pi-angle-double-down"
                hideIcon="pi pi-angle-double-up" :style="{ left: '15px', top: '10px' }" v-if="post.is_owner && locale() == 'ar'" />

            <div class="flex mt-3 m-3">
                <Avatar :label="post.user.name[0].toUpperCase()" shape="circle" />
                <div class="m-3 mb-0 mt-0">
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
                        {{ $t('Comment') }}
                    </PrimaryButton>
                </div>
            </form>

            <CommentSection :comments="comments" @openCommentDialog="openCommentDialog" />
        </template>
    </Card>

    <Dialog v-model:visible="visible" modal :header="$t('Delete post')" :style="{ width: '25rem' }">
        <div class="text-center">
            <p>{{ $t('Are you sure you want to delete this post?') }}</p>
        </div>

        <template #footer>
            <Link class="text-gray-700 hover:bg-gray-300 p-3 rounded" @click="deletePost">
                {{ $t('Delete') }}
            </Link>
            <Link class="text-red-700 hover:bg-red-300 p-3 rounded" @click="deletePermanentlyPost">
                {{ $t('Delete Permanently') }}
            </Link>
        </template>
    </Dialog>

    <Dialog v-model:visible="visibleComment" modal :header="$t('Delete Comments')" :style="{ width: '25rem' }">
        <div class="text-center">
            <p>{{ $t('Are you sure you want to delete comments?') }}</p>
        </div>

        <template #footer>
            <Link class="text-red-700 hover:bg-red-300 p-3 rounded" @click="deleteComments">
                {{ $t('Delete') }}
            </Link>
        </template>
    </Dialog>
</template>
