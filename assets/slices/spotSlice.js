import { createSlice } from '@reduxjs/toolkit'
import { createSpot, fetchSpots } from '../actions/spotActions'

const spotSlice = createSlice({
  name: 'spot',
  initialState: {
    loading: false,
    success: false,
    errors: null,
    spot: null,
    spots: [],
    page: 1,
    pageCount: 0,
  },
  reducers: {
    clearState: (state) => {
      state.loading = false
      state.success = false
      state.errors = null
      state.spot = null
      state.spots = []
      state.page = 1
      state.pageCount = 0
    },
  },
  extraReducers: {
    [createSpot.pending]: (state) => {
      state.loading = true
      state.success = false
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
    [fetchSpots.pending]: (state) => {
      state.loading = true
      state.success = false
      state.errors = null
    },
    [fetchSpots.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.success = true
      state.spots = payload['hydra:member']
      state.page = parseInt(payload['hydra:view']['@id'].replace(/\D/g,''), 10)
      state.pageCount = parseInt(payload['hydra:view']['hydra:last'].replace(/\D/g,''), 10)
    },
    [fetchSpots.rejected]: (state, { payload }) => {
      state.loading = false
      state.success = false
      state.errors = payload
    },
  },
})

export const getSpotLoadingStatus = (state) => state.spot.loading;

export const getSpotSuccessStatus = (state) => state.spot.success;

export const getSpotErrors = (state) => state.spot.errors;

export const getSpots = (state) => state.spot.spots;

export const getSpot = (state) => state.spot.spot;

export const getPage = (state) => state.spot.page;

export const getPageCount = (state) => state.spot.pageCount;

export const { clearState } = spotSlice.actions

export default spotSlice.reducer
