export interface IPaginationWrapper<T> extends IPagination {
    data: T;
}

export interface IPagination {
    page: number;
    limit: number;
    total: number;
}