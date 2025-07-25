import {IEmployees} from '../types';
import axios from "axios";
import {IPagination, IPaginationWrapper} from "../types/paginations";

const API_URL="http://localhost:8080/api/"

const paginationParse=(pagination?: IPagination) => `?page=${pagination?.page || 1}&limit=${pagination?.limit}`

export const getEmployees = async (pagination?: IPagination) => {
    return axios
        .get(`${API_URL}employees${paginationParse(pagination)}`)
        .then(
            response => (response.data as unknown as IPaginationWrapper<IEmployees[]>)
        )
        .catch((err: unknown) => {
            console.error(err);
            return
        });
};

