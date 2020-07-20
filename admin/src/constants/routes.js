import React from 'react'

// Containers
const TheLayout = React.lazy(() => import('../containers/TheLayout'))
// Pages
const Login = React.lazy(() => import('../views/pages/login/Login'))
const Register = React.lazy(() => import('../views/pages/register/Register'))
const Page404 = React.lazy(() => import('../views/pages/page404/Page404'))
const Page500 = React.lazy(() => import('../views/pages/page500/Page500'))

export default [
  {
    path: '/login',
    name: 'Login',
    exact: true,
    render: props => <Login {...props} />
  },
  {
    path: '/register',
    name: 'Register',
    exact: true,
    render: props => <Register {...props} />
  },
  {
    path: '/404',
    name: 'Page Not Found',
    exact: true,
    render: props => <Page404 {...props} />
  },
  {
    path: '/500',
    name: 'Internal Server Error',
    exact: true,
    render: props => <Page500 {...props} />
  },
  {
    path: '/',
    name: 'Home',
    exact: false,
    render: props => <TheLayout {...props} />
  }
]
