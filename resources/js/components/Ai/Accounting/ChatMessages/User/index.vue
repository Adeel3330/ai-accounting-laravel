<template>
  <div v-if="message" class="flex flex-row-reverse items-start gap-3">
    <AiUserIcon />
    <div class="max-w-[85%] rounded-2xl rounded-tr-md bg-zinc-900 px-3.5 py-2.5 text-sm text-white shadow-sm">
      <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-zinc-300">You</span>
      <p class="whitespace-pre-wrap break-words leading-relaxed">{{ message }}</p>
    </div>
  </div>
</template>

<script setup>
import AiUserIcon from '@/components/Ai/Accounting/ChatMessages/User/Icon/index.vue';

defineOptions({
  name: 'AccountingChatMessagesUser',
});

defineProps({
  message: {
    type: String,
    default: '',
  },
});
</script>
