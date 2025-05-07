<script setup>
import { ref, onMounted } from 'vue'
import { useTaskStore } from '../store/task/task.store'
import TaskModal from '../components/TaskModal.vue'
import TaskTable from '../components/TaskTable.vue'
import SideBar from '../components/Sidebar.vue'
import CommonButton from '../components/CommonButton.vue'

const isLoading = ref(false)
const taskStore = useTaskStore();
const taskToEdit = ref(null)
const isEdit = ref(false)
const showModal = ref(false)

const openModal = (task = null, editMode = false) => {
  isEdit.value = editMode
  taskToEdit.value = task
  showModal.value = true
}



const closeModal = () => {
  showModal.value = false
  taskStore.clearAttributes()
  isEdit.value = false
  taskToEdit.value = null
}

const toggleTaskStatus = async (task) => {
  taskStore.selectedTaskId = task.id
  await taskStore.updateTaskStatus({ status: task.toggleStatus() })
  taskStore.clearAttributes()
  await fetchTasks()
}

const deleteTaskById = async (taskId) => {
  try {
    taskStore.selectedTaskId = taskId
    await taskStore.deleteTask()
    await fetchTasks()
    taskStore.clearAttributes()
  } catch (error) {
    console.error('Erro ao excluir tarefa:', error)
  }
}

const fetchTasks = async () => {
  isLoading.value = true
  try {
    await taskStore.getTasks()
  } catch (error) {
    console.error('Erro ao carregar tarefas:', error)
  } finally {
    isLoading.value = false
  }
}

const changePage = async (direction) => {
  const newPage = taskStore.page + direction
  taskStore.page = newPage
  await fetchTasks()
}

onMounted(() => {
  fetchTasks()
})
</script>

<template>
  <div class="todo-container">
    <SideBar @createTask="openModal" @filterChanged="fetchTasks" />
    <div class="todo-table">
      <div class="header">
        <h1 class="todo-title">
          <i class="fas fa-tasks"></i> Tarefas do dia
        </h1>
        <div class="page-navigation">
          <CommonButton :onClick="() => changePage(-1)" title="Anterior" icon="fas fa-chevron-left" type="action"
            size="small" :disabled="!taskStore.hasPrevPage()" />
          <span class="page-info">Página {{ taskStore.page }} de {{ taskStore.totalPage }}</span>
          <CommonButton :onClick="() => changePage(1)" icon="fas fa-chevron-right" title="Próxima" type="action"
            size="small" :disabled="!taskStore.hasNextPage()" />
        </div>
      </div>
      <div class="task-table-container">
        <TaskTable :tasks="taskStore.tasks" :isLoading="isLoading" :onEdit="openModal"
          :onToggleStatus="toggleTaskStatus" :onDelete="deleteTaskById" />
      </div>
    </div>
  </div>
  <TaskModal :showModal="showModal" :closeModal="closeModal" :onCreateSuccess="fetchTasks" :taskToEdit="taskToEdit"
    :isEdit="isEdit" />
</template>


<style scoped>
.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 20px;
}

.page-info {
  font-size: 16px;
  color: #6a1b9a;
  font-weight: 600;
}

.page-navigation {
  display: flex;
  justify-content: space-between;
  align-items: center;
  width: 250px;
}

.fixed-footer {
  position: fixed;
  bottom: 0;
  left: 50%;
  transform: translateX(-50%);
  background-color: #6a1b9a;
  color: white;
  padding: 10px 20px;
  border-radius: 10px;
  text-align: center;
  width: calc(100% - 40px);
  box-shadow: 0 -5px 10px rgba(0, 0, 0, 0.1);
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.todo-container {
  display: flex;
  justify-content: flex-start;
  align-items: flex-start;
  padding: 30px;
  background: linear-gradient(to right, #f0e6f6, #f9f1fb);
  min-height: calc(100vh - 140px);
}

.todo-sidebar {
  width: 250px;
  background-color: #6a1b9a;
  padding: 20px;
  border-radius: 10px;
  color: white;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  margin-right: 20px;
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
}

.todo-table {
  flex: 1;
  background-color: white;
  padding: 30px 25px;
  border-radius: 12px;
  box-shadow: 0 8px 30px rgba(0, 0, 0, 0.07);
  display: flex;
  flex-direction: column;
  gap: 20px;
  height: calc(100vh - 140px);
}

.todo-title {
  font-size: 28px;
  color: #6a1b9a;
  display: flex;
  align-items: center;
  gap: 10px;
  margin-bottom: 10px;
}

.footer-actions {
  display: flex;
  justify-content: space-between;
  align-items: center;
}

.add-btn {
  padding: 10px 20px;
  font-size: 16px;
  background-color: #6a1b9a;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
  transition: background-color 0.2s;
}

.add-btn:hover {
  background-color: #4a148c;
}
</style>
