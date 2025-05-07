<script setup>
import { useTaskStore } from '../store/task/task.store'
import { Status } from '../models/task_status_enum'
import CommonButton from './CommonButton.vue';
const taskStore = useTaskStore()
const emit = defineEmits(['createTask', 'filterChanged'])
</script>

<template>
  <div class="sidebar">
    <div class="filters">
      <div class="filter-group">
        <label for="statusFilter">Filtrar por Status:</label>
        <select v-model="taskStore.statusFilter" id="statusFilter" @change="$emit('filterChanged')">
          <option :value="null">Todos</option>
          <option :value="Status.PENDING">Pendente</option>
          <option :value="Status.DONE">Concluída</option>
        </select>
      </div>

      <div class="filter-group">
        <label for="pageSizeFilter">Quantidade por página:</label>
        <select v-model="taskStore.pageSize" id="pageSizeFilter" @change="$emit('filterChanged')">
          <option v-for="option in taskStore.pageSizeOptions()" :key="option" :value="option">
            {{ option }}
          </option>
        </select>
      </div>
    </div>

    <div class="sidebar-actions">
      <div class="task-stats">
        <p><strong>Total:</strong> {{ taskStore.tasks.length }}</p>
        <p><strong>Concluídas:</strong> {{taskStore.tasks.filter(t => t.status === Status.DONE).length}}</p>
        <p><strong>Pendentes:</strong> {{taskStore.tasks.filter(t => t.status === Status.PENDING).length}}</p>
      </div>
      <CommonButton :onClick="$emit.bind(null, 'create-task')" icon="fas fa-plus"  text="Criar Tarefa" size="large" type="primary" />
    </div>
  </div>
</template>

<style scoped>
.sidebar {
  width: 250px;
  background-color: #6a1b9a;
  padding: 20px;
  border-radius: 10px;
  color: white;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  margin-right: 20px;
  display: flex;
  flex-direction: column;
  justify-content: space-between;
  gap: 20px;
  height: calc(100vh - 125px);
}

.filters {
  display: flex;
  flex-direction: column;
  gap: 20px;
}

.filter-group {
  display: flex;
  flex-direction: column;
}

.filter-group label {
  margin-bottom: 5px;
}

.filter-group select {
  padding: 10px;
  border: 1px solid #ddd;
  border-radius: 6px;
  background-color: white;
  color: black;
}

.sidebar-actions {
  display: flex;
  flex-direction: column;
  gap: 15px;
}

.add-btn,
.toggle-stats-btn {
  padding: 10px;
  background-color: #4a148c;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.add-btn:hover,
.toggle-stats-btn:hover {
  background-color: #38006b;
}

.task-stats {
  background-color: rgba(255, 255, 255, 0.1);
  padding: 10px;
  border-radius: 8px;
}
</style>
