import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import ApiService from '../../services/ApiService'

export const AUTH_REQUEST = 'AUTH_REQUEST'
export const AUTH_SUCCESS = 'AUTH_SUCCESS'
export const AUTH_FAIL = 'AUTH_FAIL'

const error = {
  code: 500,
  message: 'Something went wrong.'
}

export const authorize = createAsyncThunk(
  'api/authorize',
  async ({ email, password }) => {
    const response = await ApiService.post('/auth', { email, password })
    return response
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
      } else {
        state.token = null
        state.data = null
        state.error = action.payload
      }
    }
  }
})

export default authSlice.reducer
