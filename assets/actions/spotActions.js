import axios from 'axios'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const createSpot = createAsyncThunk(
    'spot/create',
    async ({ title, slug, cats }, { rejectWithValue }) => {
        try {
            const config = {
                headers: {
                    'Content-Type': 'multipart/form-data',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                },
            }

            const form = new FormData();
            form.append('title', title)
            form.append('slug', slug)
            cats.forEach(cat => form.append('categories[]', cat.value))

            const { data } = await axios.post(
                '/api/spots',
                form,
                config
            )
            return data
        } catch (error) {
            return rejectWithValue(error.response.data.message)
        }
    }
)