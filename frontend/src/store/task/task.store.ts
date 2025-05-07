import { defineStore } from 'pinia';
import { TaskModule } from "@/infra/task/task.module";
import { Task } from "@/models/task_model";
import { Status } from "@/models/task_status_enum";
import { ValueResult } from "@/models/value_result";
import { GlobalData } from '../../global';

interface ITaskStore {
  tasks: Task[];
  page: number;
  totalPage: number;
  totalTasks: number;
  pageSize: number;
  title: string;
  titleError: string;
  selectedTaskId: string;
  description: string;
  statusFilter: Status | null;
}

export const useTaskStore = defineStore('task_store', {
  state: (): ITaskStore => ({
    tasks: [],
    page: 1,
    totalPage: 1,
    totalTasks: 0,
    pageSize: 10,
    title: '',
    titleError: '',
    selectedTaskId: '',
    description: '',
    statusFilter: null,
  }),

  actions: {
    async getTasks(): Promise<ValueResult<void>> {
      try {
        const response = await TaskModule.getTasks({
          page: this.page,
          pageSize: this.pageSize,
          status: this.statusFilter
        });
        this.tasks = response.tasks;
        this.page = response.currentPage;
        this.totalPage = response.totalPages;
        this.totalTasks = response.totalTasks;
        return new ValueResult<void>({ value: undefined });
      } catch (err: any) {
        return ValueResult.fromError(err);
      }
    },

    async createTask(): Promise<ValueResult<Task>> {
      if (!this.validateTitle()) {
        return new ValueResult<Task>({ error: 'Título inválido' });
      }
      try {
        const newTask = new Task();
        newTask.title = this.title;
        newTask.description = this.description;
        newTask.status = Status.PENDING;
        const res = await TaskModule.createTask(newTask);
        return new ValueResult<Task>({ value: res });
      } catch (err: any) {
        return new ValueResult<Task>({ error: err ?? 'Erro desconhecido' });
      }
    },

    async updateTask(): Promise<ValueResult<Task>> {
      try {
        const updatedTask = new Task();
        updatedTask.title = this.title;
        updatedTask.description = this.description;
        const res = await TaskModule.updateTask(updatedTask, this.selectedTaskId);
        return new ValueResult<Task>({ value: res });
      } catch (err: any) {
        return new ValueResult<Task>({ error: err ?? 'Erro desconhecido' });
      }
    },

    async updateTaskStatus(params: {
      status: Status
    }): Promise<ValueResult<Task>> {
      try {
        const updatedTask = new Task();
        updatedTask.status = params.status;
        const res = await TaskModule.updateTask(updatedTask, this.selectedTaskId);
        return new ValueResult<Task>({ value: res });
      } catch (err: any) {
        return new ValueResult<Task>({ error: err ?? 'Erro desconhecido' });
      }
    },

    async deleteTask(): Promise<ValueResult<void>> {
      try {
        const res = await TaskModule.deleteTask(this.selectedTaskId);
        return new ValueResult<void>({ value: res });
      } catch (err: any) {
        return ValueResult.fromError(err);
      }
    },

    validateTitle(): boolean {
      if (!this.title) {
        this.titleError = 'O nome é obrigatório.';
        return false;
      }
      this.titleError = '';
      return true;
    },

    clearAttributes() {
      this.title = '';
      this.selectedTaskId = '';
      this.description = '';
      this.titleError = '';
      this.statusFilter = null;
    },

    hasPrevPage(): boolean {
      return this.page > 1;
    },

    hasNextPage(): boolean {
      return this.page < this.totalPage;
    },

    pageSizeOptions(): number[] {
      const options: number[] = [];
      let size = 5;
      while (size <= this.totalTasks) {
        options.push(size);
        size += 5;
      }
      if (options[options.length - 1] !== this.totalTasks) {
        options.push(this.totalTasks);
      }
      return options;
    }
  }
});
