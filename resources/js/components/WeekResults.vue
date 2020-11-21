<template>
  <div class="m-2 p-1">
    <p class="text-center">{{ result[0].week }} Week Match Results</p>

    <single-match v-for="match in result" :key="match.id" :match="match"/>

  </div>
</template>

<script>
import SingleMatch from "./SingleMatch";
export default {
  name: "WeekResults",
  components: { SingleMatch },
  props: {
    result: {
      type: Array,
      required: true,
      default: () => ([]),
    }
  },
}
</script>
