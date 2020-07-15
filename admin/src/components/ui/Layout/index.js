import * as React from 'react'
import { Layout } from 'react-admin'
import SalesTrackerAppBar from '../AppBar'

const SalesTrackerLayout = props => <Layout {...props} appBar={SalesTrackerAppBar} />

export default SalesTrackerLayout
