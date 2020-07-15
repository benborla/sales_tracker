import * as React from 'react'
import AppBar from '@material-ui/core/AppBar'
import Toolbar from '@material-ui/core/Toolbar'
import Typography from '@material-ui/core/Typography'
import { makeStyles } from '@material-ui/core/styles'

const useStyles = makeStyles({
  title: {
    flex: 1,
    textOverflow: 'ellipsis',
    whiteSpace: 'nowrap',
    overflow: 'hidden'
  },
  spacer: {
    flex: 1
  }
})

const SalesTrackerAppBar = props => {
  const classes = useStyles()
  return (
    <AppBar {...props}>
      <Toolbar>
        <Typography variant='h6' className={classes.title} align='center'>
          Sales Tracker
        </Typography>
      </Toolbar>
    </AppBar>
  )
}

export default SalesTrackerAppBar
