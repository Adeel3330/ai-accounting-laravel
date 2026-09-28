<template>
  <div class="pr-4 h-[474px] overflow-y-auto" style="min-width: 100%; display: table;">
    <template v-for="(msg, index) in messages" :key="index">
      <AccountingChatMessagesAssistant
        v-if="msg.role === 'assistant'"
        :message="msg.content"
      />
      <AccountingChatMessagesUser
        v-else-if="msg.role === 'user'"
        :message="msg.content"
      />
    </template>

    <div v-if="loading" class="flex gap-3 my-4 text-gray-600 text-sm flex-1">
      <AiAssistantIcon />
      <p class="leading-relaxed">
        <span class="block font-bold text-gray-700">AI </span>
        <span class="animate-pulse">Running...</span>
      </p>
    </div>
  </div>
</template>

<script setup>
import AccountingChatMessagesAssistant from '@/components/Ai/Accounting/ChatMessages/Assistant/index.vue';
import AccountingChatMessagesUser from '@/components/Ai/Accounting/ChatMessages/User/index.vue';
import AiAssistantIcon from '@/components/Ai/Accounting/ChatMessages/Assistant/Icon/index.vue';

defineProps({
  messages: {
    type: Array,
    default: () => [],
  },
  loading: {
    type: Boolean,
    default: false,
  },
});
</script>
