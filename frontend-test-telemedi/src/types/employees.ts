export type Department = 'sales' | 'support' | 'complaints';

export interface IEmployees {
  id: number;
  name: string;
  surname: string;
  department: Department;
  performance: number;
}
