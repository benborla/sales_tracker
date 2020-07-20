import { configureStore } from '@reduxjs/toolkit'
import authSliceReducer from './auth/authSlice'

export default configureStore({
  reducer: {
    auth: authSliceReducer
  }
})
