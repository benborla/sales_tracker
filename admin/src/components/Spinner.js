import React from 'react'

const Spinner = (type = 'secondary') => (
  <div className={`spinner-border text-${type}`} style={{ maxWidth: '1rem', maxHeight: '1rem' }} role='status'>
    <span className='sr-only'>Loading...</span>
  </div>
)

export default Spinner
