<template>
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
      <prediction/>
    </div>
    <div class="row justify-content-center mt-5 mb-2">
      <match-results :results="results"/>
    </div>
  </main>
</template>

<script>
import LeagueTable from "./components/LeagueTable";
import Prediction from "./components/Prediction";
import MatchResults from "./components/MatchResults";

export default {
  name: "App",
  components: { LeagueTable, Prediction, MatchResults },
  data: () => ({
    currentWeek: 0,
    leagueTable: [],
    results: {},
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
  },
  mounted() {
    // this.startNewSeason()
  }
}
</script>

<style scoped>

</style>
