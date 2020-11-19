<template>
  <div class="col-md-7">
    <div class="card">
      <div class="card-header">League Table</div>

      <div class="card-body">
        <table class="table table-bordered table-sm">
          <thead>
          <tr>
            <th scope="col">Teams</th>
            <th scope="col">Pts</th>
            <th scope="col">P</th>
            <th scope="col">W</th>
            <th scope="col">D</th>
            <th scope="col">L</th>
            <th scope="col">GD</th>
          </tr>
          </thead>
          <tbody>
          <tr v-for="row in leagueTable" :key="row.team_id">
            <th scope="row">{{ row.team_name }}</th>
            <td>{{ row.points }}</td>
            <td>{{ row.game_played }}</td>
            <td>{{ row.win }}</td>
            <td>{{ row.draw }}</td>
            <td>{{ row.loss }}</td>
            <td>{{ row.goal_diff }}</td>
          </tr>
          </tbody>
        </table>

        <div class="row justify-content-between p-1 m-2">
          <button class="btn btn-sm btn-danger" v-if="showButtons" @click="calcTillEnd">Play All</button>
          <button class="btn btn-sm btn-outline-primary" @click="calcNextResult" v-if="showButtons">Next Week</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    leagueTable: {
      type: Array,
      required: true
    },
    currentWeek: {
      type: Number,
      required: true
    }
  },
  methods: {
    calcNextResult() {
      this.$emit('next-week')
    },
    calcTillEnd() {
      this.$emit('till-end')
    }
  },
  computed: {
    showButtons() {
      return this.currentWeek < 6
    }
  }
}
</script>
