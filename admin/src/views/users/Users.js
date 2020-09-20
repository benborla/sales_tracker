import React, { useState, useEffect } from 'react'
import { useSelector, useDispatch, shallowEqual } from 'react-redux'
import { useHistory, useLocation } from 'react-router-dom'
import {
  CCard,
  CCardBody,
  CCardHeader,
  CCol,
  CRow,
  CDataTable,
  CPagination,
  CBadge
} from '@coreui/react'
import DataTable from '../../components/datatable/DataTable'
import {
  fetchUsers,
} from './UsersSlice'

const Users = () => {
  const dispatch = useDispatch()
  const users = useSelector(state => state.users, shallowEqual)
  const fields = ['email', 'lastName', 'firstName', 'action']

  useEffect(() => {
    const retrieveUsers = async () => {
      return dispatch(await fetchUsers())
    }
    retrieveUsers()
  }, [])

  useEffect(() => {
    console.log({ users })
  }, [users])

  const history = useHistory()
  const queryPage = useLocation().search.match(/page=([0-9]+)/, '')
  const currentPage = Number(queryPage && queryPage[1] ? queryPage[1] : 1)
  const [page, setPage] = useState(currentPage)

  const pageChange = newPage => {
    currentPage !== newPage && history.push(`/users?page=${newPage}`)
  }

  useEffect(() => {
    currentPage !== page && setPage(currentPage)
  }, [currentPage, page])

  return (
    <CRow>
      <CCol xl={12}>
        <CCard>
          <CCardHeader>
            Users
            <small className='text-muted'> example</small>
          </CCardHeader>
          <CCardBody>
            <CDataTable
              items={users.data}
              fields={fields}
              hover
              striped
              bordered
              size="lg"
              itemsPerPage={1}
              scopedSlots = {{
                'action':
                  (item)=>(
                    <td>
                      Edit | Delete
                    </td>
                  )
              }}
            />
            <CPagination
              activePage={page}
              onActivePageChange={pageChange}
              pages={5}
              doubleArrows={false} 
              align="center"
            />
          </CCardBody>
        </CCard>
      </CCol>
    </CRow>
  )
}

export default Users
