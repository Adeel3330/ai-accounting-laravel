<template>
  <div class="border-t border-zinc-100 bg-white p-3">
    <form class="flex items-end gap-2" @submit.prevent="sendMessage">
      <textarea
        v-model="message"
        rows="1"
        class="max-h-28 min-h-10 w-full resize-none rounded-xl border border-zinc-200 bg-zinc-50 px-3 py-2.5 text-sm text-zinc-900 placeholder:text-zinc-400 focus:border-zinc-400 focus:bg-white focus:outline-none focus:ring-2 focus:ring-zinc-200 disabled:cursor-not-allowed disabled:opacity-50"
        placeholder="Type your message..."
        :disabled="loading"
        @keydown.enter.exact.prevent="sendMessage"
      />
      <button
        type="submit"
        class="inline-flex h-10 shrink-0 items-center justify-center rounded-xl bg-zinc-900 px-4 text-sm font-medium text-white transition hover:bg-zinc-800 disabled:pointer-events-none disabled:opacity-50"
        :disabled="loading || !message.trim()"
      >
        Send
      </button>
    </form>
  </div>
</template>

<script setup>
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

  let assistantMessage = '';

  try {
    const response = await fetch(`${import.meta.env.VITE_API_URL}/v1/chat`, {
      method: 'POST',
      headers: {
        'Content-Type': 'application/json',
        Accept: 'text/event-stream',
      },
      body: JSON.stringify({ prompt }),
    });

    if (!response.ok) {
      throw new Error(`HTTP ${response.status}`);
    }

    if (!response.body) {
      throw new Error('Streaming is not supported by this browser.');
    }

    const reader = response.body.getReader();

    for await (const item of parseSSEStream(reader)) {
      if (item.type === 'text_delta' && item.delta) {
        assistantMessage += item.delta;
        emit('sendMessage', {
          role: 'assistant',
          content: assistantMessage,
        });
      }
    }

    emit('sendMessage', {
      role: 'assistant',
      content: assistantMessage || 'No response received.',
      done: true,
    });
  } catch (error) {
    console.error(error);
    emit('sendMessage', {
      role: 'assistant',
      content:
        error?.response?.data?.message ||
        error?.message ||
        'Sorry, something went wrong. Please try again.',
      done: true,
      error: true,
    });
  }
};
</script>
