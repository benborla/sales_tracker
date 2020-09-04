import { configureStore } from '@reduxjs/toolkit'
import authSliceReducer from './auth/authSlice'
import checkUserSliceReducer from './auth/checkUserSlice'

export default configureStore({
  reducer: {
    auth: authSliceReducer,
    checkUser: checkUserSliceReducer
  }
})
