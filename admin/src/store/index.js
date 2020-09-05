import { configureStore } from '@reduxjs/toolkit'
import authSliceReducer from './auth/authSlice'
import checkUserSliceReducer from './auth/checkUserSlice'
import sidebarSliceReducer from './ui/sidebarSlice'

export default configureStore({
  reducer: {
    auth: authSliceReducer,
    checkUser: checkUserSliceReducer,
    sidebar: sidebarSliceReducer
  }
})
