new Vue({

  el: "#p1-table",

  data: {
    counts: []
  },

  mounted() {
    axios.get('/address').then(response => this.counts = response.data);
  }
});
