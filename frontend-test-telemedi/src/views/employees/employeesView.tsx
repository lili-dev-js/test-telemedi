import { Box } from '@chakra-ui/react';
import { useEffect, useState } from 'react';
import { getEmployees } from '../../api';
import DefaultTable from '../../components/customUi/defaultTable';
import { IEmployees } from '../../types';

export const EmployeesView = () => {
  const [employees, setEmployees] = useState<IEmployees[]>();

  useEffect(() => {
    fetchEmployees();
  });

  const fetchEmployees = async () => {
    const response = await getEmployees();

    if (response) {
      setEmployees(response);
    }
  };

  return (
    <Box>
      <DefaultTable
        headers={['id', 'name', 'surname', 'department', 'performance']}
        data={
          employees &&
          (employees as Array<IEmployees & Record<string, unknown>>)
        }
      />
    </Box>
  );
};
