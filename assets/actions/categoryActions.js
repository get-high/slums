import axios from 'axios'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const fetchCategories = createAsyncThunk(
    'categories/get',
    async () => {
        try {
            const config = {
                headers: {
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            }
            const { data } = await axios.get(
                '/api/categories',
                config,
            )
            return data
        } catch (error) {
            return rejectWithValue(error.response.data.message)
        }
    }
)