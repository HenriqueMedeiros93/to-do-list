<script setup>
import { watch, ref } from 'vue';
import { useTaskStore } from '../store/task/task.store';
import CommonInput from './CommonInput.vue';
import CommonButton from './CommonButton.vue';

const props = defineProps({
  showModal: Boolean,
  closeModal: Function,
  onCreateSuccess: Function,
  taskToEdit: Object,
  isEdit: Boolean,
});

const taskStore = useTaskStore();
const loading = ref(false);

const addOrUpdateTask = async () => {
  loading.value = true;
  taskStore.titleError = '';
  let response = null;
  try {
    if (props.isEdit) {
      response = await taskStore.updateTask();
    } else {
      response = await taskStore.createTask();
    }
    if (response.getError()) {
      return;
    }

    props.closeModal();
    if (props.onCreateSuccess) props.onCreateSuccess();
  } catch (error) {
    let message = props.isEdit ? 'atualizar tarefa' : 'adicionar tarefa';
    console.error(`Erro ao ${message}`, error);
  } finally {
    loading.value = false;
  }
};

watch(
  () => props.showModal,
  (visible) => {
    if (visible && props.taskToEdit) {
      taskStore.selectedTaskId = props.taskToEdit.id;
      taskStore.title = props.taskToEdit.title;
      taskStore.description = props.taskToEdit.description;
      taskStore.statusFilter = props.taskToEdit.status;
    } else if (visible) {
      taskStore.title = '';
      taskStore.description = '';
      taskStore.selectedTaskId = '';
    }
  }
);
</script>

<template>
  <div v-if="showModal" class="modal-overlay">
    <div class="modal">
      <h2 class="modal-title">{{ props.isEdit ? 'Alterar' : 'Adicionar' }} Tarefa</h2>
      <form @submit.prevent="addOrUpdateTask">
        <CommonInput id="task-title" label="Nome" v-model="taskStore.title" :placeholder="'Digite o nome da tarefa'"
          :error="taskStore.titleError" />
        <CommonInput id="task-description" label="Descrição" v-model="taskStore.description"
          :placeholder="'Digite uma descrição opcional'" type="textarea" />

        <div class="modal-actions">
          <CommonButton :onClick="props.closeModal" text="Cancelar" size="small" type="secondary" />
          <CommonButton :onClick="addOrUpdateTask" 
            :text="loading ? (props.isEdit ? 'Atualizando' : 'Adicionando') : (props.isEdit ? 'Atualizar' : 'Adicionar')"
            :size="'large'" :disabled="loading" :type="loading ? 'disabled' : 'primary'" />
        </div>
      </form>
    </div>
  </div>
</template>

<style scoped>
.modal-overlay {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  bottom: 0;
  background-color: rgba(0, 0, 0, 0.5);
  display: flex;
  justify-content: center;
  align-items: center;
  z-index: 1000;
  padding: 20px;
}

.modal {
  background-color: white;
  padding: 25px;
  border-radius: 10px;
  box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
  width: 450px;
  max-width: 100%;
  display: flex;
  flex-direction: column;
}

.modal-title {
  font-size: 24px;
  font-weight: 600;
  color: #333;
  text-align: center;
  margin-bottom: 20px;
}

.modal-actions {
  display: flex;
  padding: 0 15px;
  justify-content: space-between;
  gap: 10px;
}
</style>
