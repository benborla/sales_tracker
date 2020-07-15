import React from 'react'
import { ResourceGuesser } from '@api-platform/admin'
import { UserList } from './list'
import { UserEdit } from './edit'

const UserResource = ({ ...props }) => (
  <ResourceGuesser
    {...props}
    list={UserList}
    edit={UserEdit}
  />
)

export default UserResource
