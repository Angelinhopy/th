import axios from 'axios'

export default {
  getTableList ({commit}, tableName) {
    return new Promise((resolve, reject) => {
      axios.get(`/${tableName}`)
        .then(response => {
          let tableList = response.data
          commit('setTableList', { tableList })
          resolve(response)
        })
        .catch(error => {
          console.log(`${tableName} error`)
          reject(error)
        })
    })
  },
  
  updateTableItem ({ commit }, tableData) {
    return new Promise((resolve, reject) => {
      let httpmethod = tableData.method
      axios({ url: `/${tableData.endpoint}`, method: httpmethod, data: tableData.tableItem })
        .then(response => {
          resolve(response)
        })
        .catch(error => {
          //console.log(error)
          reject(error)
        })
    })
  }
}