import { createSlice } from '@reduxjs/toolkit'
import { createSpot } from '../actions/spotActions'

const initialState = {
  loading: false,
  error: null,
  spot: null,
}

const spotSlice = createSlice({
  name: 'spot',
  initialState,
  reducers: {
  },
  extraReducers: {
    [createSpot.pending]: (state) => {
      state.loading = true
      state.error = null
    },
    [createSpot.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.spot = payload
    },
    [createSpot.rejected]: (state, { payload }) => {
      state.loading = false
      state.error = payload
    },
  },
})

export const { } = spotSlice.actions

export default spotSlice.reducer
