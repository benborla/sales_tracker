import React from 'react'
import {
  ListGuesser,
  FieldGuesser
} from '@api-platform/admin'
import { ReferenceField, TextField } from 'react-admin'

export const UserList = props => {
  return <ListGuesser {...props}>
    <FieldGuesser source='email' />
    <FieldGuesser source='lastName' label='Last Name' />
    <FieldGuesser source='firstName' label='First Name' />
    <FieldGuesser source='middleName' label='Middle Name' />
    <FieldGuesser source='accountType' label='Type' />
    <FieldGuesser source='createdAt' label='Created' />
    <FieldGuesser source='updatedAt' label='Updated' />
    <TextField label='Billing Address' source="information.billingAddress" />
    <ReferenceField label='Country' source='information' reference='information'>
      <TextField source='billingCountry' />
    </ReferenceField>
  </ListGuesser>
}
