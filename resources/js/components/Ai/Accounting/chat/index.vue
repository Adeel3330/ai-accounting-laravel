<template>
  <AccountingChatButton
    :isOpen="isOpen"
    @toggleChat="toggleChat"
  />

  <Transition
    enter-active-class="transition-all duration-300 ease-out"
    enter-from-class="opacity-0 translate-y-4 scale-95"
    enter-to-class="opacity-100 translate-y-0 scale-100"
    leave-active-class="transition-all duration-200 ease-in"
    leave-from-class="opacity-100 translate-y-0 scale-100"
    leave-to-class="opacity-0 translate-y-4 scale-95"
  >
    <div
      v-if="isOpen"
      class="fixed bottom-[calc(4rem+1.5rem)] right-4 z-50 flex h-[min(634px,calc(100vh-6rem))] w-[min(440px,calc(100vw-2rem))] flex-col overflow-hidden rounded-2xl border border-zinc-200 bg-white shadow-xl shadow-zinc-900/10"
    >
      <AccountingChatHeader @close="toggleChat" />

      <AccountingChatMessages :messages="messages" :loading="loading" />

      <AccountingChatInput :loading="loading" @sendMessage="sendMessage" />
    </div>
  </Transition>
</template>

<script setup>
import AccountingChatButton from '@/components/Ai/Accounting/ChatButtton/index.vue';
import AccountingChatHeader from '@/components/Ai/Accounting/ChatHeader/index.vue';
import AccountingChatMessages from '@/components/Ai/Accounting/ChatMessages/index.vue';
import AccountingChatInput from '@/components/Ai/Accounting/ChatInput/index.vue';

import { ref } from 'vue';

const messages = ref([
  {
    role: 'assistant',
    content: 'Hello, how can I help you today?',
    streaming: false,
  },
]);
const isOpen = ref(false);
const loading = ref(false);

const sendMessage = (message) => {
  if (message.role === 'user') {
    loading.value = true;
    messages.value.push({
      role: 'user',
      content: message.content,
    });
    messages.value.push({
      role: 'assistant',
      content: '',
      streaming: true,
    });
    return;
  }

  const last = messages.value[messages.value.length - 1];

  if (last?.role === 'assistant') {
    last.content = message.content;

    if (message.done || message.error) {
      last.streaming = false;
      loading.value = false;
    }

    return;
  }

  messages.value.push({
    role: 'assistant',
    content: message.content,
    streaming: false,
  });
  loading.value = false;
};

const toggleChat = () => {
  isOpen.value = !isOpen.value;
};
</script>
