<script setup>
import PrimaryButton from "@/Components/PrimaryButton.vue";
import { Link, useForm, usePage } from "@inertiajs/vue3";
import { ref } from "vue";

const user = usePage().props.auth.user;

// Form data for avatar upload
const form = useForm({
    avatar: user.avatar,
});

const avatarPreview = ref(
    user.avatar ? `/storage/${user.avatar}` : "/default-avatar.png"
);

const updateAvatarPreview = (event) => {
    const file = event.target.files[0];
    if (file) {
        form.avatar = file;
        avatarPreview.value = URL.createObjectURL(file);
    }
};

// Submit the form to update the avatar
const submitForm = () => {
    form.post(route("profile.updateAvatar"), {
        preserveScroll: true,
        onSuccess: () => {
            avatarPreview.value = form.avatar
                ? avatarPreview.value
                : user.avatar;
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                Profile Avatar
            </h2>

            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                Update your Avatar.
            </p>
        </header>

        <form @submit.prevent="submitForm" class="mt-6 space-y-6">
            <div class="flex flex-col items-start">
                <div class="relative">
                    <!-- Avatar Preview -->
                    <img
                        class="mb-3 rounded-full shadow-lg w-36 h-36"
                        :src="avatarPreview"
                        alt="User Avatar"
                    />

                    <!-- Change Avatar Input -->
                    <label
                        for="avatar"
                        class="absolute bottom-0 right-0 px-3 py-1 text-xs text-white bg-blue-600 rounded-full cursor-pointer"
                    >
                        Change
                    </label>
                    <input
                        id="avatar"
                        type="file"
                        class="hidden"
                        accept="image/*"
                        @change="updateAvatarPreview"
                    />
                </div>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p
                        v-if="form.recentlySuccessful"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >
                        Saved.
                    </p>
                </Transition>
            </div>
        </form>
    </section>
</template>
