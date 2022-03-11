import axios from 'axios'

export default {
  login ({ commit }, userData) {
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios.post('/login', { username: userData.username, password: userData.password })
        .then(response => {
          const token = response.data.token
          const user = response.data.user
          const permiso = response.data.permiso
          localStorage.setItem('_token', token)
          localStorage.setItem('user', JSON.stringify(user))
          localStorage.setItem('permiso', JSON.stringify(permiso))
          axios.defaults.headers.common['Authorization'] = 'Bearer ' + token
          commit('auth_success', { token, user, permiso })
          resolve(response)
        })
        .catch(error => {
          console.log('login error')
          commit('auth_error')
          localStorage.removeItem('_token')
          reject(error)
        })
    })
  },

  permisorenew({ commit }, userData){
    console.log(userData);
    return new Promise((resolve, reject) => {
      commit('auth_request')
      axios.post(`/permisorenew/${userData}`)
        .then(response => {
          const permiso = response.data.permiso
          localStorage.removeItem('permiso')
          localStorage.setItem('permiso', JSON.stringify(permiso))
          commit('auth_permiso', permiso)
          resolve(response)
        })
        .catch(error => {
          console.log('permiso error')
          reject(error)
        })
    })
  },

  logout ({ commit }) {
    return new Promise((resolve, reject) => {
      commit('logout')
      localStorage.removeItem('_token')
      localStorage.removeItem('user')
      localStorage.removeItem('permiso')
      delete axios.defaults.headers.common['Authorization']
      resolve()
    })
  },
}