<template>
    <div class="flex justify-start flex-row-reverse gap-3 my-4 text-gray-600 text-sm flex-1" v-if="message">
        <AiUserIcon />
        <p class="leading-relaxed"><span class="block font-bold text-gray-700">You </span>{{ message }}</p>
      </div>
</template>
<script setup>
import AiUserIcon from '@/components/Ai/Accounting/ChatMessages/User/Icon/index.vue';
defineOptions({
    name: 'AccountingChatMessagesUser',
});

const props = defineProps({
    message: {
        type: String,
        default: '',
    },
});
</script>