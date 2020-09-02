import { fetch } from 'whatwg-fetch'

const api = process.env.REACT_APP_ENTRYPOINT_API
const endpoint = path => api + path
const options = (method = 'GET', path = '', isAnonymous = false) => {
  const token = localStorage.getItem('atk')
  console.log({ option: token })
  const auth = isAnonymous ? {} : (token !== null && typeof token !== 'undefined') ? { Authorization: `Bearer ${token}` } : {}
  const headerOptions = { method, headers: { 'Content-Type': 'application/ld+json', ...auth } }

  return headerOptions
}

const get = path => fetch(endpoint(path), options('GET')).then(res => res.json())
const post = (path, payload, isAnonymous = false, method = 'POST') => {
  const requestPayload = options(method, path, isAnonymous)
  return fetch(endpoint(path), { ...requestPayload, body: JSON.stringify(payload) }).then(res => res.json())
}
const put = (path, payload, method = 'PUT') => {
  const token = localStorage.getItem('atk')
  if (token) {
    return post(path, payload, method)
  } else {
    throw console.error('Invalid token')
  }
}

const patch = (path, payload, method = 'PATCH') => put(path, payload, method)
const del = (path, method = 'DELETE') => post(path, {}, method)

export default {
  endpoint,
  get,
  post,
  put,
  patch,
  del
}
