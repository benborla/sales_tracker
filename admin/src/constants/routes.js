import React from 'react'
import { Route, Switch, Redirect } from 'react-router-dom'
import AuthService from '../services/AuthService'

// Containers
const TheLayout = React.lazy(() => import('../containers/TheLayout'))
// Pages
const Login = React.lazy(() => import('../views/pages/login/Login'))
const Register = React.lazy(() => import('../views/pages/register/Register'))
const Page404 = React.lazy(() => import('../views/pages/page404/Page404'))
const Page500 = React.lazy(() => import('../views/pages/page500/Page500'))

const ProtectedRoute = ({ component: Component, ...rest }) => {
  if (AuthService.getToken()) {
    return (
      <Route
        {...rest}
        render={
          props => <Component {...rest} {...props} />
        }
      />
    )
  } else {
    return <Redirect to='/login' />
  }
}

// @todo, enclosed ProtecctedRoute with auth checking
const Routes = () => (
  <Switch>
    <Route exact path='/login' name='Login Page' render={props => <Login {...props} />} />
    <Route exact path='/register' name='Register Page' render={props => <Register {...props} />} />
    <Route exact path='/404' name='Page 404' render={props => <Page404 {...props} />} />
    <Route exact path='/500' name='Page 500' render={props => <Page500 {...props} />} />
    <ProtectedRoute path='/' component={TheLayout} />
  </Switch>
)

export default Routes
