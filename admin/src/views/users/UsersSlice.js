import { createSlice, createAsyncThunk } from '@reduxjs/toolkit'
import ApiService from '../../services/ApiService'
import {
  GET_USERS 
} from '../../constants/apiRoutes'

export const fetchUsers = createAsyncThunk(
  'get-users',
  () => ApiService.get(GET_USERS)
)

export const usersSlice = createSlice({
  name: 'users',
  initialState: {
    loading: false,
    data: null,
    error: null
  },
  reducers: {},
  extraReducers: {
    [fetchUsers.pending]: (state, action) => {
      state.loading = true
    },
    [fetchUsers.fulfilled]: (state, action) => {
      state.loading = false
      if (action.payload['hydra:totalItems'] !== '0') {
        state.data = action.payload['hydra:member']
      } else {
        state.error = action.payload
      }
    }
  }
})

export default usersSlice.reducer
