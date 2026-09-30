<template>
  <div ref="scrollContainer" class="min-h-0 flex-1 overflow-y-auto overscroll-contain px-4 py-3">
    <div class="flex flex-col gap-3">
      <template v-for="(msg, index) in messages" :key="index">
        <AccountingChatMessagesAssistant
          v-if="msg.role === 'assistant'"
          :message="msg.content"
          :streaming="Boolean(msg.streaming)"
        />
        <AccountingChatMessagesUser
          v-else-if="msg.role === 'user'"
          :message="msg.content"
        />
      </template>

      <div
        v-if="loading && !hasStreamingMessage"
        class="flex items-start gap-3"
      >
        <AiAssistantIcon />
        <div class="rounded-2xl rounded-tl-md bg-zinc-100 px-3.5 py-2.5 text-sm text-zinc-600">
          <span class="inline-flex gap-1">
            <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-zinc-400 [animation-delay:0ms]" />
            <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-zinc-400 [animation-delay:150ms]" />
            <span class="h-1.5 w-1.5 animate-bounce rounded-full bg-zinc-400 [animation-delay:300ms]" />
          </span>
        </div>
      </div>

      <div ref="bottomAnchor" />
    </div>
  </div>
</template>

<script setup>
import AccountingChatMessagesAssistant from '@/components/Ai/Accounting/ChatMessages/Assistant/index.vue';
import AccountingChatMessagesUser from '@/components/Ai/Accounting/ChatMessages/User/index.vue';
import AiAssistantIcon from '@/components/Ai/Accounting/ChatMessages/Assistant/Icon/index.vue';
import { computed, nextTick, ref, watch } from 'vue';

const props = defineProps({
  messages: {
    type: Array,
    default: () => [],
  },
  loading: {
    type: Boolean,
    default: false,
  },
});

const scrollContainer = ref(null);
const bottomAnchor = ref(null);

const hasStreamingMessage = computed(() =>
  props.messages.some((msg) => msg.role === 'assistant' && msg.streaming),
);

const scrollToBottom = async () => {
  await nextTick();
  bottomAnchor.value?.scrollIntoView({ block: 'end', behavior: 'smooth' });
};

watch(
  () => [
    props.messages.length,
    props.messages.at(-1)?.content,
    props.loading,
  ],
  () => {
    scrollToBottom();
  },
  { flush: 'post' },
);
</script>
