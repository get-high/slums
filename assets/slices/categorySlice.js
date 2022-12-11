import { createSlice } from '@reduxjs/toolkit'
import { fetchCategories } from "../actions/categoryActions";

const categorySlice = createSlice({
  name: 'category',
  initialState: {
    categories: [],
    loadings: false,
    error: false,
  },
  reducers: {},
  extraReducers: {
    [fetchCategories.pending]: (state) => {
      state.loading = true
      state.error = null
    },
    [fetchCategories.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.categories = payload
    },
    [fetchCategories.rejected]: (state, { payload }) => {
      state.loading = false
      state.error = payload
    },
  },
})

export const {} = categorySlice.actions

export default categorySlice.reducer