const state = {
  data: {
    api_token: null,
    avatar: null,
    created_at: null,
    email: null,
    email_verified_at: null,
    google_id: null,
    id: null,
    name: null,
    updated_at: null
  }
}

const mutations = {
  setData (state, newData) {
    state.data = newData
  }
}

export default {
  namespaced: true,
  state,
  mutations
}