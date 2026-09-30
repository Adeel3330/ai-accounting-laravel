<template>
  <div class="flex items-center pt-0">
    <form class="flex items-center justify-center w-full space-x-2" @submit.prevent="sendMessage">
      <input
        class="flex h-10 w-full rounded-md border border-[#e5e7eb] px-3 py-2 text-sm placeholder-[#6b7280] focus:outline-none focus:ring-2 focus:ring-[#9ca3af] disabled:cursor-not-allowed disabled:opacity-50 text-[#030712] focus-visible:ring-offset-2"
        placeholder="Type your message" v-model="message" :disabled="loading">
      <button type="submit"
        class="inline-flex items-center justify-center rounded-md text-sm font-medium text-[#f9fafb] disabled:pointer-events-none disabled:opacity-50 bg-black hover:bg-[#111827E6] h-10 px-4 py-2"
        :disabled="loading || !message.trim()">
        Send
      </button>
    </form>
  </div>
</template>

<script setup>
import { useApi } from '@/lib/useApi';
import { parseSSEStream } from '@/lib/useSSE';
import { ref } from 'vue';

defineProps({
  loading: {
    type: Boolean,
    default: false,
  },
});

const message = ref('');
const emit = defineEmits(['sendMessage']);

const sendMessage = async () => {
  const prompt = message.value.trim();
  if (!prompt) return;

  emit('sendMessage', {
    role: 'user',
    content: prompt,
  });

  message.value = '';

  try {
    const response = await fetch(`${import.meta.env.VITE_API_URL}/v1/chat`,{
    method: 'POST',
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'text/event-stream',
    },
    body: JSON.stringify({
      prompt,
    }),
  });
  console.log(response);
    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    if (!response.body) {
      throw new Error('Streaming is not supported by this browser.');
    }

    const reader = response.body.getReader();

    let assistantMessage = '';

    for await (const item of parseSSEStream(reader)) {
      console.log('SSE ITEM:', item);

      if (item.type === 'text_delta') {
        assistantMessage += item.delta;

        emit('sendMessage', {
          role: 'assistant',
          content: assistantMessage,
        });
      }
    }
  } catch (error) {
    console.error(error);
    const message =
      error?.response?.data?.message ||
      error?.message ||
      'Sorry, something went wrong. Please try again.';
    emit('sendMessage', {
      role: 'assistant',
      content: message,
    });
  }
};
</script>
