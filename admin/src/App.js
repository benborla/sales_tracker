import React, { Component } from 'react'
import { HashRouter, Route, Switch } from 'react-router-dom'
import './scss/style.scss'
import routes from './constants/routes'

const loading = (
  <div className='pt-3 text-center'>
    <div className='sk-spinner sk-spinner-pulse' />
  </div>
)
class App extends Component {
  render () {
    return (
      <HashRouter>
        <React.Suspense fallback={loading}>
          <Switch>
            {
              routes.map((route, i) => {
                return <Route exact={route.exact} key={i} {...route} />
              })
            }
          </Switch>
        </React.Suspense>
      </HashRouter>
    )
  }
}

export default App
