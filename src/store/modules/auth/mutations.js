export default {
  auth_request (state) {
    state.authStatus = 'loading'
  },
  auth_success (state, { token, user, permiso }) {
    state.authStatus = 'success'
    state.token = token
    state.user = user
    state.access = permiso
  },
  auth_permiso (state, permiso) {
    state.access = permiso
  },
  auth_error (state) {
    state.authStatus = 'error'
  },
  logout (state) {
    state.authStatus = ''
    state.token = ''
  },
}