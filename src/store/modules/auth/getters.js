export default {
  authorized: state => !!state.token,
  authstatus: state => state.authStatus,
  accesspage: state => state.access,
  username: state => state.user,
}