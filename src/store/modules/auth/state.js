export default {
  authStatus: '',
  token: !!localStorage.getItem('_token'),
  user: JSON.parse(localStorage.getItem('user')) || {},
  access: JSON.parse(localStorage.getItem('permiso')) || [],
}