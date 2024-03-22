<script setup>

import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import PostSection from '@/Components/Post/PostSection.vue';
import axios from 'axios';
import { useIntersectionObserver } from '@vueuse/core'
import { ref } from 'vue';
import { Link } from '@inertiajs/vue3';

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

const deletePost = (postId) => {
    allPosts.value = allPosts.value.filter(post => post.id !== postId);
}

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

                    <div class="flex justify-center flex-col items-center">
                        <PostSection v-for="post in allPosts" :key="post.id" :post="post" @deletePost="deletePost" />
                        <div ref="last"></div>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
