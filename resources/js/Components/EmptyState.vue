<template>
    <div class="flex items-center justify-center h-full">
        <div class="flex flex-col items-center justify-center text-center">
            <svg
                class="text-gray-800 dark:text-gray-600 opacity-70"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                width="70"
                height="70"
                viewBox="0 0 24 24"
            >
                <path
                    stroke="currentColor"
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    stroke-width="2"
                    d="M12 13V8m0 8h.01M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z"
                />
            </svg>

            <h2
                class="text-xl font-semibold text-gray-800 dark:text-gray-600 opacity-90"
            >
                <slot />
            </h2>
        </div>
    </div>
</template>
