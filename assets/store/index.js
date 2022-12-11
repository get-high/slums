import { configureStore } from '@reduxjs/toolkit'
import { combineReducers } from 'redux'
import userReducer from '../slices/userSlice'
import categoryReducer from "../slices/categorySlice";
import spotReducer from "../slices/spotSlice";

const reducer = combineReducers({
    user: userReducer,
    spot: spotReducer,
    category: categoryReducer,
})

const store = configureStore({
    reducer
})

export default store