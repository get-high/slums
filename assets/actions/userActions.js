import axios from 'axios'
import { createAsyncThunk } from '@reduxjs/toolkit'

export const userLogin = createAsyncThunk(
  'user/login',
  async ({ username, password }, { rejectWithValue }) => {
    try {
      const config = {
        headers: {
          'Content-Type': 'application/json',
        },
      }
      const { data } = await axios.post(
        '/api/login',
        { username, password },
        config
      )
      localStorage.setItem('token', data.token)
      return data
    } catch (error) {
        return rejectWithValue(error.response.data.message)
    }
  }
)
