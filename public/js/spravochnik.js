Vue.component('tabs', {
  template: `
    <div>
      <div class="tabs">
      <ul class="nav nav-tabs">
        <li role="presentation" v-for="tab in tabs" :class="{ 'active': tab.isActive }">
          <a :href="tab.href" @click="selectTab(tab)" v-text="tab.name"></a>
        </li>
      </ul>
      </div>
      <div class="tab-content">
        <slot></slot>
      </div>
    </div>
  `,

  data() {
    return { tabs: [] };
  },

  created() {
    this.tabs = this.$children;
  },

  methods: {
    selectTab(selectedTab) {
      this.tabs.forEach(tab => {
        tab.isActive = (tab.href == selectedTab.href);
      });
    }
  }
});


Vue.component('tab', {
  template: `
    <div v-show="isActive"><slot></slot></div>
  `,

  props: {
    name: { required: true },
    selected: { default: false }
  },

  data() {
    return {
      isActive: false
    };
  },

  computed: {
    href() {
      return '#' + this.name.toLowerCase().replace(/ /g, '-');
    }
  },

  mounted() {
    this.isActive = this.selected;
  },
});

Vue.component('tab-table', {
  template: `
    <div class="table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th>id</th>
            <th v-for="ps in counts.pageSruture" v-text="ps.desc"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pp in counts.pageParams">
            <td v-text="pp.id"></td>
            <td v-for="ps in counts.pageSruture" v-text="pp[ps.desc]"></td>
          </tr>
        </tbody>
      </table>
    </div>
  `,

  props: {
    name: { required: true}
  },

  data() {
    return {counts: []};
  },

  mounted() {
    axios.get('/'+this.name).then(response => this.counts = response.data);
  }
});

new Vue({
  el: '#root'
});
