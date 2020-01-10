import collect from 'collect.js'

const state = {
  data: {
    active: '0',
    categories: [],
    currentState: 'lobby',
    id: 0,
    numberOfRounds: '0',
    rounds: [],
    started: '0',
    timer: '0',
    userId: '0',
    users: []
  },
  activeRound: {},
  receivedAnswers: [],
  roundApproval: [],
  roundAnswers: []
}

const mutations = {
  setGame (state, game) {
    state.data = game

    game.rounds.forEach(round => {
      state.roundApproval[round.id] = round.approval
    })
  },
  setPlayers (state, players) {
    state.data.users = players
  },
  setState (state, newState) {
    state.data.currentState = newState
  },
  setActiveRound (state, newRound) {
    state.activeRound = newRound
    state.data.categories.forEach(category => {
      state.roundAnswers[category.id] = newRound.letter
    })
  },
  setRoundAnswers (state, answers) {
    state.roundAnswers = answers
  },
  setReceivedAnswers (state, answers) {
    const collection = collect(answers).groupBy('categoryId')
    state.receivedAnswers = collection.all()
  },
  setRoundApproval (state, data) {
    state.roundApproval.splice(data.roundId, 1, data.approval)
  }
}

export default {
  namespaced: true,
  state,
  mutations
}