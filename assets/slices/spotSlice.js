import { createSlice } from '@reduxjs/toolkit'
import { createSpot } from '../actions/spotActions'

const spotSlice = createSlice({
  name: 'spot',
  initialState: {
    loading: false,
    success: false,
    errors: null,
    spot: null,
  },
  reducers: {
    clearState: (state) => {
      state.loading = false
      state.success = false
      state.errors = null
      state.spot = null
    },
  },
  extraReducers: {
    [createSpot.pending]: (state) => {
      state.loading = true
    },
    [createSpot.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.success = true
      state.spot = payload
    },
    [createSpot.rejected]: (state, { payload }) => {
      state.loading = false
      state.success = false
      state.errors = payload
    },
  },
})

export const getSpotLoadingStatus = (state) => state.spot.loading;

export const getSpotSuccessStatus = (state) => state.spot.success;

export const getSpotErrors = (state) => state.spot.errors;

export const getSpot = (state) => state.spot.spot;

export const { clearState } = spotSlice.actions

export default spotSlice.reducer
