import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import AuthService from '../../services/AuthService'
import Cookies from 'js-cookie'

export const authorize = createAsyncThunk(
  'api/authenticate',
  ({ email, password }) => AuthService.authenticate(email, password)
)

export const logout = createAsyncThunk(
  'api/logout',
  () => {
    Cookies.remove('atk')
  }
)

export const authSlice = createSlice({
  name: 'auth',
  initialState: {
    loading: false,
    token: null,
    data: null,
    error: null
  },
  reducers: {},
  extraReducers: {
    [authorize.pending]: (state, action) => {
      state.loading = true
    },
    [authorize.fulfilled]: (state, action) => {
      state.loading = false
      if (action.payload.code === 200) {
        state.token = action.payload.token
        state.data = action.payload.data
        state.error = null
        Cookies.set('atk', state.token)
      } else {
        state.token = null
        state.data = null
        state.error = action.payload
      }
    }
  }
})

export default authSlice.reducer
