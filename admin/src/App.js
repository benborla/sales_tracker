import React from 'react'
import { Redirect, Route } from 'react-router-dom'
import {
  HydraAdmin,
  hydraDataProvider as baseHydraDataProvider,
  fetchHydra as baseFetchHydra,
  ResourceGuesser
} from '@api-platform/admin'
import parseHydraDocumentation from '@api-platform/api-doc-parser/lib/hydra/parseHydraDocumentation'
import authProvider from './authProvider'
import UserResource from './pages/user'
import { Dashboard } from './pages/dashboard'
import SalesTrackerLayout from './components/ui/Layout'

const entrypoint = 'http://localhost:20080' //process.env.REACT_APP_API_ENTRYPOINT
const fetchHeaders = { Authorization: `Bearer ${window.localStorage.getItem('token')}` }
const fetchHydra = (url, options = {}) => baseFetchHydra(url, {
  ...options,
  headers: new Headers(fetchHeaders)
})

const apiDocumentationParser = entrypoint => parseHydraDocumentation(entrypoint, { headers: new Headers(fetchHeaders) })
  .then(
    ({ api }) => ({ api }),
    (result) => {
      switch (result.status) {
        case 401:
          return Promise.resolve({
            api: result.api,
            customRoutes: [
              <Route
                key={result.status} path='/' render={() => {
                  return window.localStorage.getItem('token') ? window.location.reload() : <Redirect to='/login' />
                }}
              />
            ]
          })

        default:
          return Promise.reject(result)
      }
    }
  )
const dataProvider = baseHydraDataProvider(entrypoint, fetchHydra, apiDocumentationParser)

export default () => (
  <HydraAdmin
    layout={SalesTrackerLayout}
    dashboard={Dashboard}
    dataProvider={dataProvider}
    authProvider={authProvider}
    entrypoint={entrypoint}
  >
    <UserResource name='users' />
    <ResourceGuesser name='information' />
  </HydraAdmin>
)
