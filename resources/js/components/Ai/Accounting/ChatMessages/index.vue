<template>
  <div class="pr-4 h-[474px]" style="min-width: 100%; display: table;">
      <!-- Chat Message AI -->
      <AccountingChatMessagesAssistant :message="messages.content" v-if="messages?.role === 'assistant'" />
      <AccountingChatMessagesUser :message="messages.content" v-if="messages?.role === 'user'" />
    </div>
</template>
<script setup>import AccountingChatMessagesAssistant from '@/components/Ai/Accounting/ChatMessages/Assistant/index.vue';
import AccountingChatMessagesUser from '@/components/Ai/Accounting/ChatMessages/User/index.vue';
import { onMounted } from 'vue';
const props = defineProps({
  messages: {
    type: Object,
    default: {},
  },
 
});

onMounted(() => {
  console.log(props.messages,'messages');
  console.log(props.messages.role,'role');
});
</script>