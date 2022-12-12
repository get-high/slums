import { createSlice } from '@reduxjs/toolkit'
import { createSpot } from '../actions/spotActions'

const spotSlice = createSlice({
  name: 'spot',
  initialState: {
    loading: false,
    errors: null,
    spot: null,
  },
  reducers: {
  },
  extraReducers: {
    [createSpot.pending]: (state) => {
      state.loading = true
      state.errors = null
    },
    [createSpot.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.spot = payload
    },
    [createSpot.rejected]: (state, { payload }) => {
      state.loading = false
      state.errors = payload
    },
  },
})

export const getSpotStatus = (state) => state.spot.loading;

export const getSpotErrors = (state) => state.spot.errors;

export const getSpot = (state) => state.spot.spot;

export const { } = spotSlice.actions

export default spotSlice.reducer
