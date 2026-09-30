<template>
  <div v-if="message || streaming" class="flex items-start gap-3">
    <AiAssistantIcon />
    <div class="max-w-[85%] rounded-2xl rounded-tl-md bg-zinc-100 px-3.5 py-2.5 text-sm text-zinc-700 shadow-sm">
      <span class="mb-1 block text-xs font-semibold uppercase tracking-wide text-zinc-500">AI</span>
      <p class="whitespace-pre-wrap break-words leading-relaxed">
        {{ message }}<span
          v-if="streaming"
          class="ml-0.5 inline-block h-4 w-0.5 animate-pulse bg-zinc-500 align-middle"
        />
      </p>
    </div>
  </div>
</template>

<script setup>
import AiAssistantIcon from '@/components/Ai/Accounting/ChatMessages/Assistant/Icon/index.vue';

defineOptions({
  name: 'AccountingChatMessagesAssistant',
});

defineProps({
  message: {
    type: String,
    default: '',
  },
  streaming: {
    type: Boolean,
    default: false,
  },
});
</script>
