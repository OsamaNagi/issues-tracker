<template>
    <div class="space-y-4">
        <div v-for="comment in comments" :key="comment.id" class=" bg-gray-800 p-4 rounded-lg">
            <p class="text-gray-50">
                <strong>@{{ comment.user.name }}</strong> commented
                <span class="text-gray-50 text-sm">
                    {{ new Date(comment.created_at).toLocaleString() }}
                </span>
            </p>
            <p class="text-gray-50">{{ comment.content }}</p>
        </div>
    </div>
</template>

<script>
export default {
    props: {
        comments: {
            type: Object,
            required: true,
        },
    },
};
</script>
