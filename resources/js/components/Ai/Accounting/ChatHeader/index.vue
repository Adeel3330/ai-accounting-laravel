<template>
  <div class="flex items-center justify-between border-b border-zinc-100 px-4 py-3">
    <div>
      <h2 class="text-base font-semibold tracking-tight text-zinc-900">Accounting Chat</h2>
      <p class="text-xs text-zinc-500">Ask anything about your books</p>
    </div>
    <button
      type="button"
      class="inline-flex h-8 w-8 items-center justify-center rounded-full text-zinc-400 transition hover:bg-zinc-100 hover:text-zinc-700"
      aria-label="Close chat"
      @click="$emit('close')"
    >
      <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
        <path d="M18 6 6 18" />
        <path d="m6 6 12 12" />
      </svg>
    </button>
  </div>
</template>

<script setup>
defineOptions({
  name: 'AccountingChatHeader',
});

defineEmits(['close']);
</script>
