import React, { useState, useEffect } from 'react'
import { useSelector, useDispatch, shallowEqual } from 'react-redux'
import { Route, Switch, Redirect } from 'react-router-dom'
import { unwrapResult } from '@reduxjs/toolkit'
import { checkUser } from '../store/auth/checkUserSlice'

// Containers
const TheLayout = React.lazy(() => import('../containers/TheLayout'))
// Pages
const Login = React.lazy(() => import('../views/pages/login/Login'))
const Register = React.lazy(() => import('../views/pages/register/Register'))
const Page404 = React.lazy(() => import('../views/pages/page404/Page404'))
const Page500 = React.lazy(() => import('../views/pages/page500/Page500'))

const ProtectedRoute = ({ component: Component, ...rest }) => {
  const dispatch = useDispatch()
  const isLoading = useSelector(state => state.checkUser.loading)
  const [authenticated, setAuthenticated] = useState(false)

  const handleCheckUser = async () => {
    const response = unwrapResult(await dispatch(checkUser()))

    if (response.status === 200) {
      setAuthenticated(true)
    }
  }

  useEffect(() => {
    handleCheckUser()
  }, [])

  const redirectToLogin = () => {
    return <Route
      {...rest}
      render={
        props => <Login {...rest} {...props} />
      }
    />
  }
 
  const renderPage = () => {
    return <Route
      {...rest}
      render={
        props => <Component {...rest} {...props} />
      }
    />
  }

  return !isLoading && !authenticated
    ? redirectToLogin()
    : renderPage()
}

const CheckAuthOnLogin = ({ component: Component, ...rest }) => {
  const dispatch = useDispatch()
  const state = useSelector(state => state.checkUser, shallowEqual)
  const isLoading = useSelector(state => state.checkUser.loading)
  const [authenticated, setAuthenticated] = useState(false)

  const handleCheckUser = async () => {
    const response = unwrapResult(await dispatch(checkUser()))

    if (response.status === 200) {
      setAuthenticated(true)
    }
  }

  useEffect(() => {
    handleCheckUser()
  }, [])

  const redirectToLandingPage = () => {
    return <Redirect to='/' />
  }

  const renderPage = () => {
    return <Route
      {...rest}
      render={
        props => <Login {...rest} />
      }
    />
  }

  return !isLoading && authenticated
    ? redirectToLandingPage()
    : renderPage()
}


const BaseRouter = () => (
  <Switch>
    <CheckAuthOnLogin exact path='/login' name='Login' render={props => <Login {...props} />} />
    <Route exact path='/register' name='Register Page' render={props => <Register {...props} />} />
    <Route exact path='/404' name='Page 404' render={props => <Page404 {...props} />} />
    <Route exact path='/500' name='Page 500' render={props => <Page500 {...props} />} />
    <ProtectedRoute path='/' component={TheLayout} />
  </Switch>
)

export default BaseRouter
