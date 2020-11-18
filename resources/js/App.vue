<template>
  <main class="container">
    <div class="row justify-content-center mt-5">
      <league-table/>
      <prediction/>
    </div>
    <div class="row justify-content-center mt-5">
      <match-results/>
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
    foo: false
  }),
}
</script>

<style scoped>

</style>
