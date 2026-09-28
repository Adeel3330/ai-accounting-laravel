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
        style="box-shadow: 0 0 #0000, 0 0 #0000, 0 1px 2px 0 rgb(0 0 0 / 0.05);"
        class="fixed bottom-[calc(4rem+1.5rem)] right-0 mr-4 bg-white p-6 rounded-lg border border-[#e5e7eb] w-[440px] h-[634px]"
      >
        <AccountingChatHeader />
  
        <AccountingChatMessages :messages="messages" />
  
        <AccountingChatInput :loading="loading" @sendMessage="sendMessage" />
       
      </div>
    </Transition>
  </template>
  
  <script setup>
  import AccountingChatButton from '@/components/Ai/Accounting/ChatButtton/index.vue';
  import AccountingChatHeader from '@/components/Ai/Accounting/ChatHeader/index.vue';
  import AccountingChatMessages from '@/components/Ai/Accounting/ChatMessages/index.vue';
  import AccountingChatInput from '@/components/Ai/Accounting/ChatInput/index.vue';
  
  import { ref, onMounted } from 'vue';
  
  const message = ref('');
  const messages = ref([]);
  const isOpen = ref(false);
  
  const sendMessage = (message) => {
    console.log(message,"payload");


    if (message.role === 'user') {
      messages.value.push(message);
    } else {
      messages.value.push(message);
    }
  };
  
  onMounted(() => {
    messages.value.role = 'assistant'
    messages.value.content = 'Hello, how can I help you today?'
  });
  
  const toggleChat = () => {
    isOpen.value = !isOpen.value;
  };
  </script>