import React, { useState, useEffect, useRef } from 'react'
import {
  CAlert,
  CProgress,
  CButton,
  CCard,
  CCardBody,
  CCardGroup,
  CCol,
  CContainer,
  CForm,
  CInput,
  CInputGroup,
  CInputGroupPrepend,
  CInputGroupText,
  CRow
} from '@coreui/react'
import CIcon from '@coreui/icons-react'
import { useSelector, useDispatch, shallowEqual } from 'react-redux'
import { authorize } from '../../../store/auth/authSlice'
import { unwrapResult } from '@reduxjs/toolkit'
import Spinner from '../../../components/Spinner'
import { Link, useHistory } from 'react-router-dom'

const Login = (props) => {
  const dispatch = useDispatch()
  const state = useSelector(state => state.auth, shallowEqual)
  const history = useHistory()
  const [message, setMessage] = useState('')
  const [visible, setVisible] = useState(10)
  const [alertType, setAlertType] = useState('danger')
  const isLoading = useSelector(state => state.auth.loading)

  const emailEl = useRef(null)
  const passEl = useRef(null)

  useEffect(() => {
    if (state.error !== null) {
      setMessage(state.error.message)
      setVisible(10)
      setAlertType('danger')
    }

    if (state.token !== null && state.error === null) {
      setMessage('Redirecting...')
      setVisible(10)
      setAlertType('success')
    }
  }, [state])

  const handleSubmit = async e => {
    const email = emailEl.current.value
    const password = passEl.current.value
    disableForm()

    const response = unwrapResult(await dispatch(authorize({ email, password })))
    if (response.code === 200) {
      history.push('/')
    } else {
      if (!state.loading) {
        enableForm(e)
      }
    }
  }

  const disableForm = () => {
    emailEl.current.setAttribute('disabled', 'disabled')
    passEl.current.setAttribute('disabled', 'disabled')
  }

  const enableForm = () => {
    emailEl.current.removeAttribute('disabled', 'disabled')
    passEl.current.removeAttribute('disabled', 'disabled')
  }

  return (
    <div className='c-app c-default-layout flex-row align-items-center'>
      <CContainer>
        <CRow className='justify-content-center'>
          <CCol md='8'>
            <CCardGroup>
              <CCard className='p-4'>
                <CCardBody>
                  <CForm>
                    {message
                      ? <CAlert color={alertType} show={visible} closeButton onShowChange={setVisible}>
                        {message}
                        <CProgress striped color={alertType} value={Number(visible) * 10} size='xs' className='mb-3' />
                       </CAlert>
                      : ''}

                    <h1>{process.env.REACT_APP_NAME}</h1>
                    <p className='text-muted'>Sign In to your account</p>
                    <CInputGroup className='mb-3'>
                      <CInputGroupPrepend>
                        <CInputGroupText>
                          <CIcon name='cil-user' />
                        </CInputGroupText>
                      </CInputGroupPrepend>
                      <CInput innerRef={emailEl} type='text' placeholder='Email Address' autoComplete='email' />
                    </CInputGroup>
                    <CInputGroup className='mb-4'>
                      <CInputGroupPrepend>
                        <CInputGroupText>
                          <CIcon name='cil-lock-locked' />
                        </CInputGroupText>
                      </CInputGroupPrepend>
                      <CInput innerRef={passEl} type='password' placeholder='Password' autoComplete='current-password' />
                    </CInputGroup>
                    <CRow>
                      <CCol xs='6'>
                        {!isLoading
                          ? <CButton color='primary' className='px-4' onClick={handleSubmit}>Login</CButton>
                          : <Spinner />}
                      </CCol>
                      <CCol xs='6' className='text-right'>
                        <CButton color='link' className='px-0'>Forgot password?</CButton>
                      </CCol>
                    </CRow>
                  </CForm>
                </CCardBody>
              </CCard>
              <CCard className='text-white bg-primary py-5 d-md-down-none' style={{ width: '44%' }}>
                <CCardBody className='text-center'>
                  <div>
                    <h2>Sign up</h2>
                    <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut
                      labore et dolore magna aliqua.</p>
                    <Link to='/register'>
                      <CButton color='primary' className='mt-3' active tabIndex={-1}>Register Now!</CButton>
                    </Link>
                  </div>
                </CCardBody>
              </CCard>
            </CCardGroup>
          </CCol>
        </CRow>
      </CContainer>
    </div>
  )
}

export default Login
