<template>
  <div class="m-2 p-1">
    <p class="text-center">{{ result[0].week }} Week Match Results</p>
    <div class="m-1" v-for="match in result" :key="match.id">
      <div class="row d-flex pr-2 pl-2">
        <h5 class="p-2 flex-item">{{ match.home_team.name }}</h5>
        <h4 class="p-2 text-lg-center flex-item">{{ match.home_team_scored }} : {{ match.away_team_scored }}</h4>
        <h5 class="p-2 text-right flex-item">{{ match.away_team.name }}</h5>
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
  .flex-item {
    flex: 1;
  }
</style>
