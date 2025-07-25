import { Table, Button, HStack, Box, Text } from '@chakra-ui/react';
import React from 'react';

export type TableProps<T> = {
  headers: string[];
  data?: T[];
  pagination?: {
    page: number;
    limit: number;
    total: number;
    onPageChange: (page: number) => void;
  };
};

const DataTable = <T extends Record<string, unknown>>({
  headers,
  data,
  pagination,
}: TableProps<T>) => {
  const totalPages = pagination
    ? Math.ceil(pagination.total / pagination.limit)
    : 1;

  return (
    <Box overflowX="auto">
      {data ? (
        <Table.Root size="md">
          <Table.Header>
            <Table.Row bgColor="gray.600" >
              {headers.map((header, idx) => (
                <Table.ColumnHeader key={idx} color='white'>{header}</Table.ColumnHeader>
              ))}
            </Table.Row>
          </Table.Header>
          <Table.Body>
            {data.map((row, rowIndex) => (
              <Table.Row key={rowIndex} bgColor="gray.600">
                {Object.keys(row).map((key, colIndex) => (
                  <Table.Cell key={colIndex}>{`${row[key]}`}</Table.Cell>
                ))}
              </Table.Row>
            ))}
          </Table.Body>
        </Table.Root>
      ) : (
        <Box>load</Box>
      )}

      {pagination && (
        <HStack justify="space-between" mt={4}>
          <Button
            onClick={() => pagination.onPageChange(pagination.page - 1)}
            disabled={pagination.page <= 1}
          >
            Previous
          </Button>

          <Text>
            Page {pagination.page} of {totalPages}
          </Text>

          <Button
            onClick={() => pagination.onPageChange(pagination.page + 1)}
            disabled={pagination.page >= totalPages}
          >
            Next
          </Button>
        </HStack>
      )}
    </Box>
  );
};

export default DataTable;
