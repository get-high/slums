import axios from 'axios'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const createSpot = createAsyncThunk(
    'spot/create',
    async ({ title, slug, categories, description, content, address, image, lat, lng, main }, { rejectWithValue }) => {
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
            categories.forEach(category => form.append('categories[]', category.value))

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

export const fetchSpots = createAsyncThunk(
    'spots/get',
    async (page) => {
        try {
            const config = {
                headers: {
                    'Content-Type': 'application/ld+json',
                    'Authorization': 'Bearer ' + localStorage.getItem('token'),
                    'Accept': 'application/ld+json',
                },
            }
            const { data } = await axios.get(
                '/api/spots?page=' + page,
                config,
            )

            console.log(data)

            return data
        } catch (error) {
            return rejectWithValue(error.response.data.message)
        }
    }
)