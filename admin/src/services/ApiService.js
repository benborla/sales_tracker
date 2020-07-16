
const endpoint = path => process.env.REACT_APP_ENTRYPOINT_API + path
const authToken = localStorage.getItem('token')
const config = {
  headers: {
    'Content-Type': 'application/json',
    Authorization: 'Bearer ' + authToken
  }
}

const get = path => fetch(endpoint(path), {
  method: 'GET',
  headers: new Headers(config.headers)
})

export default { get }
