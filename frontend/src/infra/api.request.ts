import axios, { AxiosInstance } from 'axios';
import { Constants } from '../core/constants';

class TaskApiRequester {
  private static instance: AxiosInstance;
  public static getAxios(): AxiosInstance {
    const baseUrl = Constants.API_URL;
    TaskApiRequester.instance = axios.create({
      baseURL: baseUrl,
    });
    
    return TaskApiRequester.instance;
  }
}
export default TaskApiRequester;