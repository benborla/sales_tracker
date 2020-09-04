import ApiService from './ApiService'

const authenticate = async (email, password) => {
  const noNeedForHeaderAuth = true
  const response = await ApiService.post('/auth', { email, password }, noNeedForHeaderAuth)
  return response
}

const isAuthenticated = async () => {
  const response = await ApiService.get('/api/user')
  return response
}

const getToken = () => {
  return localStorage.getItem('atk')
}

export default {
  authenticate,
  isAuthenticated,
  getToken
}
