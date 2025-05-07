<script setup lang=ts>
import {  type PropType } from 'vue';
const props = defineProps({
  id: String,
  label: String,
  modelValue: [String, Number],
  placeholder: String,
  error: String,
  type: {
    type: String as PropType<'input' | 'textarea'>,
    default: 'input', 
  },
});

const emit = defineEmits(['update:modelValue']);
</script>

<template>
  <div class="input-group" :class="{ 'has-error': error }">
    <label :for="id">{{ label }}</label>

    <template v-if="type === 'textarea'">
      <textarea
        :id="id"
        :placeholder="placeholder"
        rows="4"
        :value="modelValue"
       @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      />
    </template>

    <template v-else>
      <input
        :id="id"
        :type="type"
        :placeholder="placeholder"
        :value="modelValue"
        @input="$emit('update:modelValue', ($event.target as HTMLInputElement).value)"
      />
    </template>

    <p v-if="error" class="error-message">{{ error }}</p>
  </div>
</template>
<style scoped>
.input-group {
  margin-bottom: 20px;
}

.input-group label {
  font-size: 14px;
  color: #666;
  margin-bottom: 5px;
  display: block;
}

.input-group input,
.input-group textarea {
  width: 100%;
  padding: 12px;
  border: 1px solid #ddd;
  border-radius: 6px;
  font-size: 14px;
  margin-top: 5px;
  transition: border-color 0.3s;
  box-sizing: border-box; 
}

.input-group input:focus,
.input-group textarea:focus {
  border-color: #4e73df;
  outline: none;
}

textarea {
  resize: vertical;
}

.has-error input,
.has-error textarea {
  border-color: #f44336;
  background-color: #fff5f5;
}

.error-message {
  color: #f44336;
  font-size: 13px;
  margin-top: 5px;
}


.modal .input-group {
  max-width: 100%;
  padding-left: 15px;  
  padding-right: 15px;
  box-sizing: border-box;  
}

.input-group input,
.input-group textarea {
  margin-left: auto;
  margin-right: auto;
}
</style>