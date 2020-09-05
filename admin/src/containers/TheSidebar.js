import React, { useState, useEffect } from 'react'
import { useSelector, useDispatch, shallowEqual } from 'react-redux'
import {
  CCreateElement,
  CSidebar,
  CSidebarBrand,
  CSidebarNav,
  CSidebarNavDivider,
  CSidebarNavTitle,
  CSidebarMinimizer,
  CSidebarNavDropdown,
  CSidebarNavItem
} from '@coreui/react'

import CIcon from '@coreui/icons-react'
import { sidebar } from '../store/ui/sidebarSlice'
import UserAccessToNav from '../services/UserAccessToNav'

const TheSidebar = () => {
  const dispatch = useDispatch()
  const show = useSelector(state => state.sidebar.sidebarShow)
  const user = useSelector(state => state.checkUser, shallowEqual)
  const [navigation, setNavigation] = useState()

  useEffect(() => {
    setNavigation(UserAccessToNav.getNav(user.data))
  }, [])

  const handleShowChange = val => (
    dispatch(sidebar.actions.changeState({ type: 'set', sidebarShow: val }))
  )

  return (
    <CSidebar
      show={show}
       onShowChange={handleShowChange}
    >
      <CSidebarBrand className='d-md-down-none' to='/'>
        <h4>Sales Tracker</h4>
      </CSidebarBrand>
      <CSidebarNav>

        <CCreateElement
          items={navigation}
          components={{
            CSidebarNavDivider,
            CSidebarNavDropdown,
            CSidebarNavItem,
            CSidebarNavTitle
          }}
        />
      </CSidebarNav>
      <CSidebarMinimizer className='c-d-md-down-none'/>
    </CSidebar>
  )
}

export default React.memo(TheSidebar)
