<script setup>
import { Head, useForm } from '@inertiajs/vue3';
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import TextInput from '@/Components/TextInput.vue';
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import Radiobox from '@/Components/Radiobox.vue';
import { ref } from 'vue';

let image = ref(null);

const props = defineProps({
    post: Object,
});

const form = useForm({
    title: {
        ar: props?.post?.data?.title_lang?.ar,
        en: props?.post?.data?.title_lang?.en,
    },
    content: {
        ar: props?.post?.data?.content_lang?.ar,
        en: props?.post?.data?.content_lang?.en,
    },
    image: '',
    is_published: true,
    _method: 'put',
});

const submit = () => {
    console.log("🚀 ~ submit ~ form:", form)
    form.post(route('posts.update', props.post.data.id));
};

const setSelectedImage = (event) => {
    image.value.style = 'display: none';
    form.image = event.files[0];
    console.log("🚀 ~ setSelectedImage ~ event.files[0]:", event.files[0])
};

const removeFile = () => {
    image.value.style = 'display: block';
    form.image = '';
};

</script>

<template>

    <Head title="Create post" />

    <AuthenticatedLayout>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $t('Update Post') }}</h2>

                        <form @submit.prevent="submit">
                            <div class="mt-3">
                                <InputLabel>{{ $t('Image') }}</InputLabel>
                                <div class="border p-3 rounded-md">
                                    <FileUpload name="image" @select="setSelectedImage" :showCancelButton="false"
                                        :showUploadButton="false" accept="image/*" :maxFileSize="1000000" @remove="removeFile" :chooseLabel="$t('Choose')">
                                        <template #empty>
                                            <p>{{ $t('Drag and drop files to here to upload.') }}</p>
                                        </template>
                                    </FileUpload>
                                </div>

                                <div class="mt-3">
                                    <img :src="post.data.image" class="max-w-80 m-auto" ref="image" alt="">
                                </div>
                                <InputError class="mt-2" :message="form.errors.image" />
                            </div>
                            <div class="mt-3">
                                <InputLabel>{{ $t('Status') }}</InputLabel>
                                <div class="flex">
                                    <div class="flex mr-4">
                                        <Radiobox v-model="form.is_published" inputId="ingredient1" name="is_published" :value="true" :checked="form.is_published" />
                                        <InputLabel>{{ $t('Active') }}</InputLabel>
                                    </div>
                                    <div class="flex">
                                        <Radiobox v-model="form.is_published" inputId="ingredient1" name="is_published" :value="false" :checked="form.is_published" />
                                        <InputLabel>{{ $t('InActive') }}</InputLabel>
                                    </div>
                                </div>
                                <InputError class="mt-2" :message="form.errors.is_published" />
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div class="mt-3">
                                    <InputLabel>{{ $t('Title (AR)') }}</InputLabel>
                                    <TextInput v-model="form.title.ar" />
                                    <InputError class="mt-2" :message="form.errors['title.ar']" />
                                </div>
                                <div class="mt-3">
                                    <InputLabel>{{ $t('Title (EN)') }}</InputLabel>
                                    <TextInput v-model="form.title.en" />
                                    <InputError class="mt-2" :message="form.errors['title.en']" />
                                </div>
                            </div>
                            <div class="mt-3">
                                <InputLabel>{{ $t('Content (AR)') }}</InputLabel>
                                <Editor v-model="form.content.ar" editorStyle="height: 320px" />
                                <InputError class="mt-2" :message="form.errors['content.ar']" />
                            </div>
                            <div class="mt-3">
                                <InputLabel>{{ $t('Content (EN)') }}</InputLabel>
                                <Editor v-model="form.content.en" editorStyle="height: 320px" />
                                <InputError class="mt-2" :message="form.errors['content.en']" />
                            </div>

                            <div class="mt-3">
                                <primary-button>{{ $t('Update Post') }}</primary-button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
