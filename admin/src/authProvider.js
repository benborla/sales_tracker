const API_URL = 'http://localhost:20080'
const authProvider = {
  login: ({ username, password }) =>  {
    const request = new Request(`${API_URL}/auth`, {
      method: 'POST',
      body: JSON.stringify({ email: username, password }),
      headers: new Headers({ 'Content-Type': 'application/json' })
    })
    return fetch(request)
      .then(response => {
        if (response.status < 200 || response.status >= 300) {
          throw new Error(response.statusText)
        }
        return response.json()
      })
      .then(({ token }) => {
        localStorage.setItem('token', token)
      })
  },
  logout: () => {
    console.log('should log out ')
    localStorage.removeItem('token')
    return Promise.resolve()
  },
  checkError: (error) => { 
    Promise.reject() 
  },
  checkAuth: () => {
    const token = localStorage.getItem('token')
    if (typeof token === 'undefined' || token === null) {
      return Promise.reject({ redirectTo: '/login' })
    } else {
      // validate token
      const request = new Request(`${API_URL}/current-user`, {
        method: 'GET',
        headers: new Headers({ 'Authorization': `Bearer ${token}`})
      })

      return fetch(request)
        .then(response => {
          if (response.status !== 200) {
            localStorage.removeItem('token')
            return Promise.reject({ redirectTo: '/login'})
          }
        })
    }
  },
  getPermissions: params => Promise.resolve()   // ...
}

export default authProvider
