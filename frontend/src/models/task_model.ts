import { Expose, Transform, Type } from "class-transformer";
import { Status } from './task_status_enum';


export class Task {
  @Expose()
  id?: string;

  @Expose()
  title?: string;

  @Expose()
  description?: string;

  @Expose()
  @Transform(({ value }) => Status[value?.toUpperCase() as keyof typeof Status])
  status!: Status;

  @Expose()
  @Type(() => Date)
  createdAt?: Date;

  @Expose()
  @Type(() => Date)
  updatedAt?: Date;

  toggleStatus() {
    return this.status === Status.PENDING ? Status.DONE : Status.PENDING;
  }
}
