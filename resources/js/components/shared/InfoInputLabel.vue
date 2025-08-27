<script setup lang="ts">
import { Input } from "@/components/ui/input"
import { Label } from "@/components/ui/label"

const props = defineProps({
    label: {
        type: String,
        required: true
    },
    value: {
        type: String,
        required: true
    }
});

// Destructure for easier template access
const { label, value } = props;
</script>


<template>
    <div class="grid w-full max-w-sm items-center gap-1.5">
        <Label :for="label">{{ label }}</Label>
        <Input :id="label" type="text" :model-value="value" readonly />
    </div>

</template>


<style scoped></style>
