import { createSlice } from '@reduxjs/toolkit'
import { fetchCategories } from "../actions/categoryActions";

const categorySlice = createSlice({
  name: 'category',
  initialState: {
    categories: [],
    loading: false,
    errors: false,
  },
  reducers: {},
  extraReducers: {
    [fetchCategories.pending]: (state) => {
      state.loading = true
      state.errors = null
    },
    [fetchCategories.fulfilled]: (state, { payload }) => {
      state.loading = false
      state.categories = payload
    },
    [fetchCategories.rejected]: (state, { payload }) => {
      state.loading = false
      state.errors = payload
    },
  },
})

export const getCategoryStatus = (state) => state.category.loading;

export const getCategoryErrors = (state) => state.category.errors;

export const getCategories = (state) => state.category.categories;

export const {} = categorySlice.actions

export default categorySlice.reducer