import { createSlice } from '@reduxjs/toolkit'
import { userLogin } from '../actions/userActions'

const token = localStorage.getItem('token')
  ? localStorage.getItem('token')
  : null

const initialState = {
  loading: false,
  token,
  error: null,
}

const userSlice = createSlice({
  name: 'user',
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
    [userLogin.pending]: (state) => {
      state.loading = true
      state.error = null
    },
    [userLogin.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.token = payload.token
    },
    [userLogin.rejected]: (state, { payload }) => {
      state.loading = false
      state.error = payload
    },
  },
})

export const { logout } = userSlice.actions

export default userSlice.reducer
