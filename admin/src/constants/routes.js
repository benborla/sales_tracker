import React from 'react'
import { useSelector, shallowEqual } from 'react-redux'
import { Route, Switch, Redirect } from 'react-router-dom'

// Containers
const TheLayout = React.lazy(() => import('../containers/TheLayout'))
// Pages
const Login = React.lazy(() => import('../views/pages/login/Login'))
const Register = React.lazy(() => import('../views/pages/register/Register'))
const Page404 = React.lazy(() => import('../views/pages/page404/Page404'))
const Page500 = React.lazy(() => import('../views/pages/page500/Page500'))

const ProtectedRoute = ({ component: Component, ...rest }) => {
  const auth = useSelector(state => state.auth, shallowEqual)

  if (auth.status === 200) {
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

const AccessibleIfNoToken = ({ component: Component, ...rest }) => {
  const auth = useSelector(state => state.auth, shallowEqual)

  if (auth.status === 401) {
    return (
      <Route
        {...rest}
        render={
          props => <Component {...rest} {...props} />
        }
      />
    )
  } else {
    return <Redirect to='/' />
  }
}

// @todo, enclosed ProtecctedRoute with auth checking
const Routes = () => (
  <Switch>
    <AccessibleIfNoToken exact path='/login' name='Login Page' component={props => <Login {...props} />} />
    <Route exact path='/register' name='Register Page' render={props => <Register {...props} />} />
    <Route exact path='/404' name='Page 404' render={props => <Page404 {...props} />} />
    <Route exact path='/500' name='Page 500' render={props => <Page500 {...props} />} />
    <ProtectedRoute path='/' component={TheLayout} />
  </Switch>
)

export default Routes
