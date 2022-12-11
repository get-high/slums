import { configureStore } from '@reduxjs/toolkit'
import { combineReducers } from 'redux'
import userReducer from '../slices/userSlice'
import categoryReducer from "../slices/categorySlice";

const reducer = combineReducers({
    user: userReducer,
    category: categoryReducer,
})

const store = configureStore({
    reducer
})

export default store