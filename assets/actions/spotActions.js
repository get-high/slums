import axios from 'axios'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const createSpot = createAsyncThunk(
    'spot/create',
    async ({ title, slug, cats, description, content, address, image, lat, lng, main }, { rejectWithValue }) => {
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
            form.append('description', description)
            form.append('content', content)
            form.append('address', address)
            form.append('lat', lat)
            form.append('lng', lng)
            form.append('main', main)
            form.append('image', image[0])
            cats.forEach(cat => form.append('categories[]', cat.value))

            const { data } = await axios.post(
                '/api/spots',
                form,
                config
            )
            return data
        } catch (error) {
            /*
            if (error.response && error.response.data.message) {
                return rejectWithValue(error.response.data.message)
            } else {
                return rejectWithValue(error.message)
            }*/
            return rejectWithValue(error.response.data.violations)
        }
    }
)