import { IEmployees } from '../types';

export const getEmployees = async (): Promise<IEmployees[] | undefined> => {
  return new Promise((resolve) => {
    setTimeout(() => {
      resolve([
        {
          id: 1,
          name: 'Test Object',
          surname: 'Test Object',
          department: 'sales',
          performance: 1.15,
        },
        {
          id: 2,
          name: 'Test Object',
          surname: 'Test Object',
          department: 'sales',
          performance: 1.15,
        },
        {
          id: 3,
          name: 'Test Object',
          surname: 'Test Object',
          department: 'sales',
          performance: 1.15,
        },
      ]);
    }, 10); // 10 ms delay
  });
};

// return axios
//   .post(`${API_URL}${INQUIRY_LOADS}`, data)
//   .then(
//     (response: AxiosResponse<{data: {id: number}}>): {data: {id: number}} => {
//       if (response.status > 299) {
//         throw new Error('Error editing user');
//       }
//
//       return response.data;
//     },
//   )
//   .catch((err: unknown) => {
//     console.error(err);
//   });
