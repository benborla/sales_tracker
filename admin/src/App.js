import React, { Component } from 'react'
import { HashRouter } from 'react-router-dom'
import './scss/style.scss'
import BaseRouter from './routes/BaseRouter'

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
          <BaseRouter />
        </React.Suspense>
      </HashRouter>
    )
  }
}

export default App
