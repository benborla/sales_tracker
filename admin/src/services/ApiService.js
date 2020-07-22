import { fetch } from 'whatwg-fetch'
import Cookies from 'js-cookie'

const api = process.env.REACT_APP_ENTRYPOINT_API
const token = Cookies.get('atk')
const endpoint = path => api + path
const options = (method = 'GET', path = '') => {
  const auth = token !== '' && typeof token !== 'undefined' ? `Bearer ${token}` : ''
  return {
    method,
    headers: {
      Authorization: auth,
      'Content-Type': 'application/ld+json'
    }
  }
}

const get = path => fetch(endpoint(path), options('GET')).then(res => res.json())
const post = (path, payload, method = 'POST') => {
  const requestPayload = options(method, path)
  return fetch(endpoint(path), { ...requestPayload, body: JSON.stringify(payload) }).then(res => res.json())
}
const put = (path, payload, method = 'PUT') => {
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
