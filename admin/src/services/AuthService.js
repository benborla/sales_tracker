import ApiService from './ApiService'
import Cookies from 'js-cookie'

const authenticate = async (email, password) => {
  const response = await ApiService.post('/auth', { email, password })
  return response
}

const isAuthenticated = async () => {
  const user = await ApiService.get('/current-user')
  if (typeof user.id !== 'undefined') {
    return true
  }

  return false
}

const getToken = () => {
  return Cookies.get('atk')
}

export default {
  authenticate,
  isAuthenticated,
  getToken
}
