import React, { useEffect, useState } from 'react'
import { SelectArrayInput, fetchStart, fetchEnd } from 'react-admin'
import { useSelector, shallowEqual, useDispatch } from 'react-redux'
import ApiService from '../../../../services/ApiService'

const UserRoles = () => {
  const dispatch = useDispatch()
  const [userRoles, setUserRoles] = useState([])
  const [loading, isLoading] = useState(false)

  useEffect(() => {
    handleFetchUsers()
  }, [])

  const handleFetchUsers = () => {
    isLoading(true)
    dispatch(fetchStart())
    ApiService.get('/get-roles')
      .then(res => res.json())
      .then(res => {
        setUserRoles(res.roles)
      })
      .finally(() => {
        isLoading(false)
        dispatch(fetchEnd())
      })
  }

  return userRoles.length
    ? <SelectArrayInput label='Roles' source='roles' choices={userRoles} options={{ fullWidth: true }} />
    : <p>No roles available</p>
}

export default UserRoles
