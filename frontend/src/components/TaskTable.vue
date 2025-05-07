<script setup>
import { defineProps } from 'vue'
import CommonButton from './CommonButton.vue'

const props = defineProps({
  tasks: Array,
  isLoading: Boolean,
  onEdit: Function,
  onToggleStatus: Function,
  onDelete: Function,
})
</script>

<template>
  <div v-if="isLoading" class="loading-container">
    <div class="purple-spinner"></div>
  </div>
  <div v-else class="table-wrapper-scrollable">
    <table class="main-table">
      <thead>
        <tr>
          <th>Nome</th>
          <th>Descrição</th>
          <th>Status</th>
          <th>Ações</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="task in tasks" :key="task.id">
          <td class="td-text">{{ task.title }}</td>
          <td class="td-text">{{ task.description ?? 'Sem Descrição' }}</td>
          <td>
            <span :class="['status-chip', task.status]">
              {{ task.status === 'pending' ? 'Pendente' : 'Concluída' }}
            </span>
          </td>
          <td>
            <div class="icon-actions">
              <CommonButton :onClick="() => onEdit(task)" icon="fas fa-edit" type="action" title="Editar" />
              <CommonButton
                :onClick="() => onToggleStatus(task)"
                :icon="task.status === 'pending' ? 'fas fa-check-circle' : 'fas fa-undo-alt'"
                type="action"
                :title="task.status === 'pending' ? 'Concluir' : 'Reativar'" />
              <CommonButton :onClick="() => onDelete(task.id)" icon="fas fa-trash-alt" type="action" title="Excluir" />
            </div>
          </td>
        </tr>
      </tbody>
    </table>
  </div>
</template>

<style scoped>
.table-wrapper-scrollable {
  height: calc(100vh - 240px);
  overflow-y: auto;
  overflow-x: auto;
  border: 1px solid #e4e9f2;
  border-radius: 8px;
}

.icon-actions {
  display: flex;
  flex-direction: row;
  gap: 8px;
  flex-wrap: wrap;
}

.main-table {
  width: 100%;
  min-width: 600px;
  border-collapse: collapse;
  table-layout: fixed;
}

.main-table th,
.main-table td {
  padding: 15px;
  text-align: left;
  border-bottom: 1px solid #e4e9f2;
  word-wrap: break-word;
  word-break: break-word;
}

.main-table th {
  position: sticky;
  top: 0;
  background: linear-gradient(to right, #6a1b9a, #8e24aa);
  color: white;
  z-index: 1;
}

.main-table tr:last-child td {
  padding-bottom: 30px;
}

.td-text {
  color: #620470;
  font-weight: 700;
}

.status-chip {
  padding: 4px 10px;
  border-radius: 20px;
  font-size: 13px;
  font-weight: 500;
  text-transform: capitalize;
  display: inline-block;
  white-space: nowrap;
}

.status-chip.pending {
  background-color: #ffebee;
  color: #c62828;
}

.status-chip.done {
  background-color: #e8f5e9;
  color: #388e3c;
}

.loading-container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 300px;
}

.purple-spinner {
  width: 60px;
  height: 60px;
  border: 6px solid #e1bee7;
  border-top: 6px solid #6a1b9a;
  border-radius: 50%;
  animation: spin 1s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}

@media (max-width: 768px) {
  .main-table th,
  .main-table td {
    padding: 10px;
    font-size: 14px;
  }

  .icon-actions {
    flex-direction: column;
    align-items: flex-start;
    gap: 4px;
  }

  .status-chip {
    font-size: 12px;
    padding: 3px 8px;
  }
}

@media (max-width: 480px) {
  .main-table {
    min-width: 100%;
    font-size: 13px;
  }

  .main-table th,
  .main-table td {
    padding: 8px;
  }

  .status-chip {
    font-size: 11px;
  }
}

</style>
