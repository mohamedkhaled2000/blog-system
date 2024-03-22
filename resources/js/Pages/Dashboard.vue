<script setup>
import { Head, Link, router, useForm } from '@inertiajs/vue3';

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Textarea from '@/Components/Textarea.vue';
import { useIntersectionObserver } from '@vueuse/core'
import { ref } from 'vue';
import axios from 'axios';

const form = useForm({
    content: {},
});

const submit = (post) => {
    form.post(route('comments.store', post), {
        onFinish: () => form.content = {},
    });
};

const props = defineProps({
    posts: Object,
    auth: Object,
});

let allPosts = ref(props.posts.data);
let last = ref(null);
let nextLink = ref(props.posts.links.next);

useIntersectionObserver(last, ([entry]) => {
    if (!entry.isIntersecting) {
        return ;
    }

    axios.get(nextLink.value)
        .then(response => {
            nextLink.value = response.data.links.next;
            allPosts.value = [...allPosts.value, ...response.data.data];
        });
});
// allPosts.value = [...allPosts.value, ...props.posts.data];

const comments = (post) => {
    return post.comments;
};

</script>

<template>

    <Head title="Dashboard" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-5">
                    <Link :href="route('posts.create')" class="primary-button">
                        Create post
                    </Link>

                    <!-- <Timeline :value="posts">
                        <template #content="slotProps">
                            {{ slotProps.item.title }}
                        </template>
                    </Timeline> -->

                    <div class="flex justify-center flex-col items-center">
                        <Card v-for="post in allPosts" :key="post.id" class="mt-5 max-w-96 block shadow-md border" style="overflow: hidden;min-width: 50%">
                            <template #header >
                                <div class="flex mt-3 ml-3">
                                    <Avatar :label="post.user.name[0].toUpperCase()" shape="circle" />
                                    <div class="ml-3">
                                        <div class="font-semibold">{{ post.user.name }}</div>
                                        <div class="text-xs text-gray-500">{{ post.created_at }}</div>
                                    </div>
                                </div>
                            </template>
                            <template #title>{{ post.title }}</template>
                            <!-- <template #subtitle>Card subtitle</template> -->
                            <template #content>
                                <div v-html="post.content"></div>

                                <div class="flex justify-center">
                                    <img alt="user header" :src="post.image" v-if="post.image" />
                                </div>
                            </template>
                            <template #footer>
                                <!-- <div class="flex gap-3 mt-1">
                                    <Button label="Edit" class="w-full" />
                                    <Button label="Delete" class="w-full" />
                                </div> -->

                                <form @submit.prevent="submit(post.id)">
                                    <Textarea v-model="form.content[post.id]" rows="2" cols="3" />

                                    <div class="flex gap-3 mt-1">
                                        <PrimaryButton>
                                            Comment
                                        </PrimaryButton>
                                    </div>
                                </form>

                                <h4 class="mt-5">Comments {{ comments(post).length }}</h4>
                                <hr class="mt-2">
                                <div class="comments max-h-80 overflow-scroll" v-if="comments(post).length > 0">
                                    <div class="comment" v-for="comment in comments(post)" :key="comment.id">
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
                        </Card>

                        <div ref="last"></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
