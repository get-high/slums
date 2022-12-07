import axios from 'axios'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const createSpot = createAsyncThunk(
    'spot/create',
    async ({ title, slug }, { rejectWithValue }) => {
        try {
            const config = {
                headers: {
                    'Content-Type': 'application/json',
                },
            }
            const { data } = await axios.post(
                '/api/spots',
                { title, slug },
                config
            )
            return data
        } catch (error) {
            return rejectWithValue(error.response.data.message)
        }
    }
)