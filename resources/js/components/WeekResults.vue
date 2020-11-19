<template>
  <div class="m-2 p-1">
    <h5 class="text-center">Match Results</h5>
    <div class="m-1" v-for="match in result" :key="match.id">
      <div class="row d-flex justify-content-around">
        <p class="p-2">{{ match.home_team.name }}</p>
        <h5 class="p-2 text-lg-center">{{ match.home_team_scored }} : {{ match.away_team_scored }}</h5>
        <p class="p-2">{{ match.away_team.name }}</p>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "WeekResults",
  props: {
    result: {
      type: Array,
      required: true,
      default: () => [],
    }
  },
  computed: {

  }
}
</script>

<style scoped>
  .flex-test {
    flex: 1;
  }
</style>
