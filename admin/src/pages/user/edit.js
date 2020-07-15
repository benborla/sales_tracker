import React from 'react'
import {
  EditGuesser,
  InputGuesser
} from '@api-platform/admin'
import Typography from '@material-ui/core/Typography'
import Box from '@material-ui/core/Box'
import { makeStyles } from '@material-ui/core/styles'
import Grid from '@material-ui/core/Grid'
import Paper from '@material-ui/core/Paper'
import {
  required,
  Edit,
  ReferenceInput,
  TextInput,
  SimpleForm,
  TextField,
  TabbedForm,
  FormTab,
  SelectArrayInput
} from "react-admin"

// sample
// https://codesandbox.io/s/react-with-hooks-g0u3m
// https://codesandbox.io/s/github/marmelab/react-admin/tree/master/examples/simple?file=/src/posts/PostEdit.js
// https://marmelab.com/react-admin/CreateEdit.html
// https://marmelab.com/react-admin/Inputs.html
const useStyles = makeStyles(theme => ({
  root: {
    flexGrow: 1
  },
  paper: {
    padding: theme.spacing(2),
    textAlign: 'center',
    color: theme.palette.text.secondary
  }
}))

const EditTitle = ({ record }) => {
  return <span>User {record ? `"${record.fullName}"` : ''}</span>
}
export function UserEdit (props) {
  return <Edit title={<EditTitle />} {...props}>
    <TabbedForm>
      <FormTab label='Personal Information'>
        <TextInput source='email' disabled />
      </FormTab>

      <FormTab label='Address'>
        <TextInput source='firstName' />
      </FormTab>

      <FormTab label='Security'>
        <TextInput source='firstName' />
      </FormTab>

      { /* @TODO apply role checking on roles */ }
      <FormTab label='Roles'>
        <SelectArrayInput label='Roles' source='roles' />
      </FormTab>
    </TabbedForm>
  </Edit>

  // return <EditGuesser title={<EditTitle />} {...props}>
    // <Typography variant='h6'>
      // Personal Information
    // </Typography>
    // <InputGuesser source='email' disabled />
    // <InputGuesser source='firstName' />
    // <InputGuesser source='middleName' />
    // <InputGuesser source='lastName' />
    // <InputGuesser source='telephone' />
    // <InputGuesser source='mobile' />
    // <InputGuesser source='email' />
  // </EditGuesser>
}

// unable to get billing data, unless we put the data in a hidden field 
// then make a call to the iri 
