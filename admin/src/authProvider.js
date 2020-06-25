const authProvider = {
    login: ({ username, password }) =>  {
        const request = new Request('http://localhost:20080/auth', {
            method: 'POST',
            body: JSON.stringify({ email: username, password }),
            headers: new Headers({ 'Content-Type': 'application/json' }),
        });
        return fetch(request)
            .then(response => {
                if (response.status < 200 || response.status >= 300) {
                    throw new Error(response.statusText);
                }
                return response.json();
            })
            .then(({ token }) => {
                localStorage.setItem('token', token);
            })
    },
    logout: () => {
        localStorage.removeItem('token');
        return Promise.resolve();
    },
    checkError: (error) => { console.log('NO ACCESS') },
    checkAuth: () => localStorage.getItem('token')
        ? console.log('LOGGED-IN')
        : Promise.reject({ redirectTo: '/no-access' }),
    // getPermissions: params => Promise.resolve(),   // ...
};

export default authProvider;
