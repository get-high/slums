import { createSlice } from '@reduxjs/toolkit'
import { createSpot } from '../actions/spotActions'

const initialState = {
  createSpot: {
    loading: false,
    errors: null,
    spot: null,
  },
}

const spotSlice = createSlice({
  name: 'spot',
  initialState,
  reducers: {
  },
  extraReducers: {
    [createSpot.pending]: (state) => {
      state.createSpot.loading = true
      state.createSpot.errors = null
    },
    [createSpot.fulfilled]: (state, { payload }) => {
      state.createSpot.loading = false
      state.createSpot.spot = payload
    },
    [createSpot.rejected]: (state, { payload }) => {
      state.createSpot.loading = false
      state.createSpot.errors = payload
    },
  },
})

export const { } = spotSlice.actions

export default spotSlice.reducer
