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
          <tr>
            <th scope="row">Liverpool</th>
            <td>4</td>
            <td>4</td>
            <td>1</td>
            <td>1</td>
            <td>2</td>
            <td>0</td>
          </tr>
          </tbody>
        </table>

        <div class="row justify-content-between p-1 m-2">
          <button class="btn btn-sm btn-danger">Play All</button>
          <button class="btn btn-sm">Next Week</button>
        </div>

      </div>
    </div>
  </div>
</template>

<script>
export default {
  mounted() {
    console.log('Component mounted.')
  }
}
</script>
