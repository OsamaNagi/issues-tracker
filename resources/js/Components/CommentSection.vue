<template>
    <div>
        <div v-for="comment in comments" :key="comment.id" class="mb-4 border-b pb-2">
            <p>
                <strong>@{{ comment.user.name }}</strong> commented
                <span class="text-gray-500 text-sm">
                    {{ new Date(comment.created_at).toLocaleString() }}
                </span>
            </p>
            <p>{{ comment.content }}</p>
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
