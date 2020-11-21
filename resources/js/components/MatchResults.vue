<template>
  <div class="col-md-6">
    <div class="card">
      <div class="card-header">Match Results (click score to edit)</div>
      <div class="card-body">
        <week-results v-for="(result, index) in results" :key="index" :result="result"/>
      </div>
    </div>
  </div>
</template>

<script>
import WeekResults from "./WeekResults";
export default {
  name: "MatchResults",
  components: { WeekResults },
  props: {
    results: {
      type: Object,
      required: true
    }
  },
}
</script>

<style scoped>

</style>
