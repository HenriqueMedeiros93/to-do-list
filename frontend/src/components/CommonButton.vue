<script setup lang="ts" >
import '@fortawesome/fontawesome-free/css/all.min.css'
import {  type PropType } from 'vue';
const props = defineProps({
  onClick: Function,
  icon: String,
  text: String,
  type: {
    type: String as PropType<'primary' | 'action' | 'secondary' | 'disabled'>,
    default: 'primary',
  
  },
  size: {
    type: String as PropType<'small' | 'large'>,
    default: 'small',
  },
})

const handleClick = () => {
  if (props.onClick && props.type !== 'disabled') {
    props.onClick();
  }
}
</script>

<template>
  <button :class="['common-button', size, type]" @click="handleClick" :disabled="type === 'disabled'"
    :title="icon && text ? text : ''">
    <i v-if="icon" :class="icon"></i>
    <span v-if="text">{{ text }}</span>
  </button>
</template>

<style scoped>
.common-button {
  display: flex;
  align-items: center;
  justify-content: center;
  border-radius: 6px;
  cursor: pointer;
  font-size: 16px;
  transition: background-color 0.3s, color 0.3s;
  border: none;
  opacity: 1;
}

.common-button i {
  margin-right: 8px;
}

.common-button span {
  font-weight: 500;
}

.common-button.small {
  font-size: 14px;
  padding: 8px 16px;
}

.common-button.large {
  font-size: 18px;
  padding: 12px 24px;
}

.common-button.primary {
  background-color: #7e57c2;
  color: white;
}

.common-button.primary:hover {
  background-color: #5e35b1;
}

.common-button.secondary {
  background-color: #f44336;
  color: white;
}

.common-button.secondary:hover {
  background-color: #d32f2f;
}

.common-button.disabled {
  background-color: #cccccc;
  color: #666666;
  cursor: not-allowed;
}

.common-button.disabled:hover {
  background-color: #cccccc;
}

.common-button.action {
  background: none;
  color: #6c757d;
  padding: 4px;
  font-size: 18px;
}

.common-button.action i {
  margin: 0;
}

.common-button.action:hover {
  color: #7e57c2;
}
</style>
