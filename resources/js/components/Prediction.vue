<template>
  <div class="col-md-4">
    <div class="card">
      <div class="card-header">Prediction</div>

      <div class="card-body">

        <div class="m-1 p-1" v-if="canShow">
          <p class="text-center">{{ currentWeek }}th Week Prediction of Championship</p>
          <div class="row d-flex pr-2 pl-2" v-for="row in predicts" :key="row.id">
            <div class="p-1 flex-item"><img src="" alt=""></div>
            <div class="p-1 flex-item"><h5>{{ row.name }}</h5></div>
            <div class="p-1 text-right flex-item"><h5>{{ row.chance }}%</h5></div>
          </div>
        </div>
        <div v-else>
          <h5>{{ noDataTitle }}</h5>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    predicts: {
      type: Array,
      required: true,
    },
    canShow: {
      type: Boolean,
      required: true,
      default: false
    },
    currentWeek: {
      type: Number,
      required: true,
    },
  },
  computed: {
    noDataTitle() {
      return this.currentWeek < 6 ? 'Not enough data for analyze.' : 'The season is over.'
    },
  },
}
</script>
<style scoped>
  .flex-item {
    flex: 1
  }
</style>
