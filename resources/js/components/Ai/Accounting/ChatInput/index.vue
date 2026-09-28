<template>
    <div class="flex items-center pt-0">
        <form class="flex items-center justify-center w-full space-x-2">
            <input
                class="flex h-10 w-full rounded-md border border-[#e5e7eb] px-3 py-2 text-sm placeholder-[#6b7280] focus:outline-none focus:ring-2 focus:ring-[#9ca3af] disabled:cursor-not-allowed disabled:opacity-50 text-[#030712] focus-visible:ring-offset-2"
                placeholder="Type your message" v-model="message">
            <button type="button"
                class="inline-flex items-center justify-center rounded-md text-sm font-medium text-[#f9fafb] disabled:pointer-events-none disabled:opacity-50 bg-black hover:bg-[#111827E6] h-10 px-4 py-2" @click="sendMessage">
                Send</button>
        </form>
    </div>
</template>
<script setup>
import { defineProps, defineEmits } from 'vue';
import { useApi } from '@/lib/useApi';  
import { ref } from 'vue';
const message = ref('');
const props = defineProps({
    message: {
        type: String,
        default: '',
    },
});
const emit = defineEmits(['sendMessage']);
const sendMessage = async () => {
    try {
        console.log(message.value,'message');
        emit('sendMessage', {
            role: 'user',
            content: message.value,
        });
        const response = await useApi().post('/v1/chat', {
            prompt: message.value,
        }).then(response => {
            console.log(response.data);
            message.value = '';
            emit('sendMessage', {
                role: 'assistant',
                content: response.data.response,
            });
        }).catch(error => {
            console.error(error);
        });
    } catch (error) {
        console.error(error);
    }
};


</script>