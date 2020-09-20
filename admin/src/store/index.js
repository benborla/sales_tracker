import { configureStore } from '@reduxjs/toolkit'
import authSliceReducer from './auth/authSlice'
import checkUserSliceReducer from './auth/checkUserSlice'
import sidebarSliceReducer from './ui/sidebarSlice'
import usersSliceReducer from '../views/users/UsersSlice'

export default configureStore({
  reducer: {
    auth: authSliceReducer,
    checkUser: checkUserSliceReducer,
    sidebar: sidebarSliceReducer,
    users: usersSliceReducer
  }
})
