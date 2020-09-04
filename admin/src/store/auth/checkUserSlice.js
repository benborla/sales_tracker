import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import AuthService from '../../services/AuthService'

export const checkUser = createAsyncThunk(
  'check-user',
  () => AuthService.isAuthenticated()
)

export const checkUserSlice = createSlice({
  name: 'checkUser',
  initialState: {
    loading: false,
    token: null,
    data: null,
    error: null,
    status: 401
  },
  reducers: {},
  extraReducers: {
    [checkUser.pending]: (state, action) => {
      state.loading = true
    },
    [checkUser.fulfilled]: (state, action) => {
      state.loading = false
      if (action.payload.status === 200) {
        state.token = action.payload.token
        state.data = action.payload
        state.error = null
        state.status = action.payload.status
      } else {
        state.token = null
        state.data = null
        state.error = action.payload
      }
    }
  }
})

export default checkUserSlice.reducer
