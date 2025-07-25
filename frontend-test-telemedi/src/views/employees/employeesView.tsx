import { Box } from '@chakra-ui/react';
import { useEffect, useState } from 'react';
import { getEmployees } from '../../api';
import DefaultTable from '../../components/customUi/defaultTable';
import { IEmployees } from '../../types';
import {IPagination} from "../../types/paginations";

export const EmployeesView = () => {
  const [employees, setEmployees] = useState<IEmployees[]>();
  const [pagination, setPagination] = useState<IPagination>({
    page: 1,
    limit: 10,
    total: 1
  });

  useEffect(() => {
    fetchEmployees(pagination);
  },[]);

  const fetchEmployees = async (pagination?:IPagination) => {
    const response = await getEmployees(pagination);

    if (response) {
      const {data, ...pagination} = response;
      console.log(data)
      setPagination(pagination);
      setEmployees(data);
    }
  };

  const onPageChange = (page: number) => {
    if(pagination?.limit && pagination.total) {
      fetchEmployees({...pagination, page});
    }
  }

  return (
    <Box>
      <DefaultTable
        headers={['id', 'name', 'surname', 'department', 'performance']}
        pagination={{...pagination, onPageChange}}
        data={
          employees &&
          (employees as Array<IEmployees & Record<string, unknown>>)
        }
      />
    </Box>
  );
};
