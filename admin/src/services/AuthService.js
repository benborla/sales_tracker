import ApiService from './ApiService'

const authenticate = async (email, password) => {
  const noNeedForHeaderAuth = true
  const response = await ApiService.post('/auth', { email, password }, noNeedForHeaderAuth)
  return response
}

const isAuthenticated = () => {
  const user = ApiService.get('/api/current-user')

  if (user.code === 401) {
    return false
  }

  if (user) {
    return true
  }

  return false
}

const getToken = () => {
  return localStorage.getItem('atk')
}

export default {
  authenticate,
  isAuthenticated,
  getToken
}
