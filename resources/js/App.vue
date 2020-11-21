<template>
  <div>
    <main class="container">
      <div class="row justify-content-center mt-5">
        <button class="btn btn-lg btn-success" @click="startNewSeason">Start New Season</button>
      </div>
      <div class="row justify-content-center mt-5">
        <league-table
          :league-table="leagueTable"
          :current-week="currentWeek"
          @next-week="calcNextResult"
          @till-end="calcNextResult(true)"
        />
        <prediction :predicts="predicts" :can-show="canPredict" :current-week="currentWeek"/>
      </div>
      <div class="row justify-content-center mt-5 mb-2">
        <match-results :results="results"/>
      </div>
    </main>

    <footer class="pt-4 my-md-5 pt-md-5 border-top">
      <div class="row justify-content-center">
          <a href="https://github.com/Ducker22/football-demo"><img src="/img/GitHub.png" alt=""> </a>
          <small class="d-block mb-3 text-muted">&copy; 2020 by Yevhen Kurguzov</small>
      </div>
    </footer>

  </div>
</template>

<script>
import LeagueTable from "./components/LeagueTable"
import Prediction from "./components/Prediction"
import MatchResults from "./components/MatchResults"
import EventBus from "./plugins/event-bus"

export default {
  name: "App",
  components: { LeagueTable, Prediction, MatchResults },
  data: () => ({
    currentWeek: 0,
    leagueTable: [],
    results: {},
    predicts: [],
  }),
  methods: {

    startNewSeason () {
      axios.post('api/v1/reset')
        .then(() => {
          this.fetchLeagueTable()
          this.fetchResults()
          this.currentWeek = 0
        })
    },

    fetchLeagueTable() {
      axios.get('api/v1/ranks')
        .then(({ data }) => {
          this.leagueTable = data
        })
    },
    fetchResults() {
      axios.get('api/v1/results')
        .then(({ data }) => {
          this.results = data
        })
    },
    patchResult(payload) {
      axios.patch('api/v1/results/' + payload.id, payload)
        .then(() => {
          this.fetchLeagueTable()
          this.fetchResults()
          this.fetchPredict()
        })
        .catch((err) => {
          console.log(err)
        })
    },
    fetchPredict() {
      if (!this.canPredict) {
        return
      }
      axios.get('api/v1/predict')
        .then(({ data }) => {
          this.predicts = data
        })
    },

    calcNextResult(toEnd = false) {
      if (this.currentWeek >= 6) {
        return
      }
      const dataBag = {
        'weeks': toEnd ? this.tillTheEnd : this.currentWeek + 1
      };
      axios.post('api/v1/results', dataBag)
        .then(() => {
          this.fetchResults()
          this.fetchLeagueTable()
          this.currentWeek = toEnd ? 6 : ++this.currentWeek
          this.fetchPredict()
        })
    },
  },
  computed: {
    tillTheEnd() {
      const res = [];
      for (let i = this.currentWeek + 1; i <= 6; i++) {
        res.push(i)
      }
      return res
    },
    canPredict() {
      return this.currentWeek >= 4 && this.currentWeek < 6
    },
  },
  mounted() {
    EventBus.$on('resultChanged', (payload) => {
      this.patchResult(payload)
    });

    this.startNewSeason()
  },
  beforeDestroy() {
    EventBus.$off('resultChanged')
  }
}
</script>

<style scoped>

</style>
