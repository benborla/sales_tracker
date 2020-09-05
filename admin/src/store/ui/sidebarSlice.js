import { createSlice } from '@reduxjs/toolkit'

export const sidebar = createSlice({
  name: 'sidebar',
  initialState: {
    sidebarShow: 'responsive'
  },
  reducers: {
    changeState: (state, action) => {
      switch (action.type) {
        case 'set':
          return { ...state, ...action.rest }
        default:
          return state
      }
    }
  }
})

export default sidebar.reducer
