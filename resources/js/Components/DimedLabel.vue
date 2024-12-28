<script setup>

const props = defineProps({
    Color: {
        type: String,
        required: true,
    },
})

const dimColor = (hex) => {
    return hexToRgbA(hex, 0.2);  // Adjust 0.2 for the desired dimming effect
};

// Helper function to convert hex to RGBA
const hexToRgbA = (hex, alpha = 1) => {
    const r = parseInt(hex.slice(1, 3), 16);
    const g = parseInt(hex.slice(3, 5), 16);
    const b = parseInt(hex.slice(5, 7), 16);
    return `rgba(${r}, ${g}, ${b}, ${alpha})`;
};

</script>

<template>
    <span
        :style="{backgroundColor: dimColor(Color), borderColor: Color, color: Color}"
        class="border px-2 py-1 text-sm font-bold text-white  rounded-full"
    >
        <slot/>
    </span>
</template>

<style scoped>

</style>
