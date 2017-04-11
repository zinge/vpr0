new Vue({

  el: "#p1-table",

  data: {
    counts: []
  },

  mounted() {
    axios.get('/equip').then(response => this.counts = response.data);
  }
});
