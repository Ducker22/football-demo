<template>
  <div class="m-1 match-result">
    <div class="row d-flex pr-2 pl-2 clickable-item" @click="handleEdit">
      <h5 class="p-1 flex-item">{{ match.home_team.name }}</h5>
      <h4 class="p-1 text-lg-center flex-item">{{ match.home_team_scored }} : {{ match.away_team_scored }}</h4>
      <h5 class="p-1 text-right flex-item">{{ match.away_team.name }}</h5>
    </div>

    <template v-if="canEdit">
      <div class="form-row d-flex justify-content-center mb-1" >
        <input class="form-control form-control-sm w-25 mr-2" type="number" v-model="matchResult.homeScored">
        <input class="form-control form-control-sm w-25 ml-2" type="number" v-model="matchResult.awayScored">
      </div>
      <div class="row justify-content-center mt-1">
        <button type="button" class="btn btn-primary btn-sm mr-3 small" @click="handleSave">Save</button>
        <button type="button" class="btn btn-secondary btn-sm ml-3 small" @click="edit = false">Cancel</button>
      </div>
    </template>
  </div>
</template>

<script>
import EventBus from "../plugins/event-bus";

export default {
  name: "SingleMatch",
  props: {
    match: {
      type: Object,
      required: true,
    },
  },
  data: () => ({
    edit: false,
    matchResult: {},
  }),
  methods: {
    handleEdit() {
      if (this.match.home_team_scored) {
        this.edit = !this.edit
      }
      this.matchResult = {
        homeScored: this.match.home_team_scored,
        awayScored: this.match.away_team_scored,
      }
    },
    handleSave() {
      EventBus.$emit('resultChanged', {
        id: this.match.id,
        ...this.matchResult,
      })
      this.edit = false
    },
  },
  computed: {
    canEdit() {
      return this.edit && this.match.home_team_scored
    },
  }
}
</script>

<style scoped>
  .flex-item {
    flex: 1;
  }
  .clickable-item {
    cursor: pointer
  }
</style>
