import TaskApiRequester from "../api.request";
import { JsonSerializer } from "typescript-json-serializer";
import { Task } from '../../models/task_model';
import { plainToInstance } from 'class-transformer';
import { Status } from '../../models/task_status_enum';

export class TaskModule {
  static readonly controller = 'task';
  static readonly axios = TaskApiRequester.getAxios();
  static readonly serializer = new JsonSerializer();

  static async getTasks(params: {
    page?: number,
    status?: Status | null
    pageSize?: number
  }): Promise<{ tasks: any; currentPage: number; totalPages: number; totalTasks: number }> {
    try {
      const queryParams: any = { page: params.page, status: params.status, pageSize: params.pageSize };
      const res = await this.axios.get(this.controller, { params: queryParams });
      const tasks = plainToInstance(Task, res?.data.tasks as Task[]);
      return {
        tasks,
        currentPage: res?.data.currentPage ?? 1,
        totalPages: res?.data.totalPage ?? 1,
        totalTasks: res?.data.totalTasks ?? 10
      };
    } catch (error) {
      console.error(error);
      return {
        tasks: [],
        currentPage: 1,
        totalPages: 1,
        totalTasks: 0
      };
    }
  }

  static async createTask(newTask: Task): Promise<any> {
    try {
      const res = await this.axios.post(this.controller, newTask);
      const tasks = plainToInstance(Task, res?.data);
      return tasks ?? [];
    } catch (error) {
      console.log(error);
      return [];
    }
  }

  static async updateTask(newTask: Task, taskId: string): Promise<any> {
    try {
      const res = await this.axios.put(this.controller + `/${taskId}`, newTask);
      const tasks = plainToInstance(Task, res?.data);
      return tasks ?? [];
    } catch (error) {
      console.log(error);
      return [];
    }
  }

  static async deleteTask(taskId: string): Promise<any> {
    try {
      const res = await this.axios.delete(this.controller + `/${taskId}`);
      return res;
    } catch (error) {
      console.log(error);
      return null;
    }
  }
}