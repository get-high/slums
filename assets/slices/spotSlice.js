import { createSlice } from '@reduxjs/toolkit'
import { createSpot } from '../actions/spotActions'

const token = localStorage.getItem('token')
  ? localStorage.getItem('token')
  : null

const initialState = {
  loading: false,
  error: null,
}

const createSpot = createSlice({
  name: 'spot',
  initialState,
  reducers: {
    logout: (state) => {
      localStorage.removeItem('token')
      state.loading = false
      state.token = null
      state.error = null
    },
  },
  extraReducers: {
    [spotSlice.pending]: (state) => {
      state.loading = true
      state.error = null
    },
    [spotSlice.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.token = payload.token
    },
    [spotSlice.rejected]: (state, { payload }) => {
      state.loading = false
      state.error = payload
    },
  },
})

export const { logout } = spotSlice.actions

export default spotSlice.reducer
