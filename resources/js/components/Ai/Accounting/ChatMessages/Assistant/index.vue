<template>

    <!--  Assistant Chat Message -->
    <div class="flex gap-3 my-4 text-gray-600 text-sm flex-1" v-if="message">
        <AiAssistantIcon />
        <p class="leading-relaxed"><span class="block font-bold text-gray-700">AI </span>{{ message }}
        </p>
    </div>
</template>
<script setup>
import AiAssistantIcon from '@/components/Ai/Accounting/ChatMessages/Assistant/Icon/index.vue';
defineOptions({
    name: 'AccountingChatMessagesAssistant',
});

const props = defineProps({
    message: {
        type: String,
        default: '',
    },
});
</script>