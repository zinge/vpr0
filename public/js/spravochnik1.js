class Errors {
    /**
     * Create a new Errors instance.
     */
    constructor() {
        this.errors = {};
    }


    /**
     * Determine if an errors exists for the given field.
     *
     * @param {string} field
     */
    has(field) {
        return this.errors.hasOwnProperty(field);
    }


    /**
     * Determine if we have any errors.
     */
    any() {
        return Object.keys(this.errors).length > 0;
    }


    /**
     * Retrieve the error message for a field.
     *
     * @param {string} field
     */
    get(field) {
        if (this.errors[field]) {
            return this.errors[field][0];
        }
    }


    /**
     * Record the new errors.
     *
     * @param {object} errors
     */
    record(errors) {
        this.errors = errors;
    }


    /**
     * Clear one or all error fields.
     *
     * @param {string|null} field
     */
    clear(field) {
        if (field) {
            delete this.errors[field];

            return;
        }

        this.errors = {};
    }
}


class Form {
    /**
     * Create a new Form instance.
     *
     * @param {object} data
     */
    constructor(data) {
        this.originalData = data;

        for (let field in data) {
            this[field] = data[field];
        }

        this.errors = new Errors();
    }


    /**
     * Fetch all relevant data for the form.
     */
    data() {
        let data = {};

        for (let property in this.originalData) {
            data[property] = this[property];
        }

        return data;
    }


    /**
     * Reset the form fields.
     */
    reset() {
        for (let field in this.originalData) {
            this[field] = '';
        }

        this.errors.clear();
    }


    /**
     * Send a POST request to the given URL.
     * .
     * @param {string} url
     */
    post(url) {
        return this.submit('post', url);
    }


    /**
     * Send a PUT request to the given URL.
     * .
     * @param {string} url
     */
    put(url) {
        return this.submit('put', url);
    }


    /**
     * Send a PATCH request to the given URL.
     * .
     * @param {string} url
     */
    patch(url) {
        return this.submit('patch', url);
    }


    /**
     * Send a DELETE request to the given URL.
     * .
     * @param {string} url
     */
    delete(url) {
        return this.submit('delete', url);
    }


    /**
     * Submit the form.
     *
     * @param {string} requestType
     * @param {string} url
     */
    submit(requestType, url) {
        return new Promise((resolve, reject) => {
            axios[requestType](url, this.data())
                .then(response => {
                    this.onSuccess(response.data);

                    resolve(response.data);
                })
                .catch(error => {
                    this.onFail(error.response.data);

                    reject(error.response.data);
                });
        });
    }


    /**
     * Handle a successful form submission.
     *
     * @param {object} data
     */
    onSuccess(data) {
        alert(data.message); // temporary

        this.reset();
    }


    /**
     * Handle a failed form submission.
     *
     * @param {object} errors
     */
    onFail(errors) {
        this.errors.record(errors);
    }
}

Vue.component('tabs', {
  template: `
    <div>
      <div class="tabs">
      <ul class="nav nav-tabs">
        <li role="presentation" v-for="tab in tabs" :class="{ 'active': tab.isActive }">
          <a :href="tab.href" @click="selectTab(tab)" v-text="tab.desc"></a>
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
    desc: { required: true },
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
      <table class="table table-hover table-bordered">
        <thead>
          <tr>
            <th>id</th>
            <th v-for="ps in counts.pageSruture" v-text="ps.desc"></th>
          </tr>
        </thead>
        <tbody>
          <tr v-for="pp in counts.pageParams">
            <td v-text="pp.id"></td>
            <td v-for="ps in counts.pageSruture" v-text="pp[ps.field]"></td>
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
