<template>
  <div v-bind:class="{ card: wrapCard }">
    <div class="table-responsive mb-0">
      <b-table
        id="resource-table"
        :busy.sync="isBusy"
        ref="resourceTable"
        :items="dataProvider"
        :fields="fields"
        :per-page="perPage"
        :current-page="currentPage"
        responsive
        show-empty
        class="card-table"
        v-bind:class="{ 'table-nowrap': !wrapTable }"
        v-bind="$attrs"
        v-on="$listeners"
        :sort-by.sync="sortBy"
        :sort-desc.sync="sortDesc"
      >
        <template
          slot="thead-top"
          slot-scope="data"
        >
          <transition name="fade">
            <tr v-if="isBusy">
              <th
                :colspan="data.columns"
                :style="{ padding: '0 !important'}"
              >
                <div class="loading-bar">
                  <div class="loading-bar-value"></div>
                </div>
              </th>
            </tr>
          </transition>
        </template>
        <template slot="empty">
          <div
            v-if="isBusy"
            class="text-center"
          >
            <b-spinner
              type="grow"
              label="Loading..."
            ></b-spinner>
          </div>
          <div
            v-else
            class="text-center"
          >No records to display!</div>
        </template>

        <template
          v-for="(_, slot) of $scopedSlots"
          v-slot:[slot]="scope"
        >
          <slot
            :name="slot"
            v-bind="scope"
          />
        </template>

      </b-table>
    </div>

    <div class="border-top p-4">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <div class="row align-items-center">
          </div>
        </div>
        <div class>
          <b-pagination
            size="sm"
            v-model="currentPage"
            :total-rows="totalRows"
            :per-page="perPage"
            aria-controls="resource-table"
            class="mb-0"
          ></b-pagination>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "ResourceTable",
  props: {
    resourceName: {
      type: String,
      required: true
    },
    resourceTitle: {
      type: String
    },
    wrapCard: {
      type: Boolean,
      required: false,
      default: true
    },
    wrapTable: {
      type: Boolean,
      required: false,
      default: false
    },
    isLoading: {
      type: Boolean,
      required: false,
      default: false
    },
    fields: {
      type: Array,
      required: true,
      default: () => []
    }
  },
  mounted() {
    this.fields.push({ key: "actions", sortable: false, label: "" });
  },
  data() {
    return {
      progressBarValue: 0,
      isBusy: false,
      from: 0,
      to: 0,
      perPage: 15,
      currentPage: 1,
      totalRows: 0,
      sortBy: "",
      sortDesc: false,
      searchValue: ""
    };
  },
  methods: {
    refreshData() {
      this.$refs.resourceTable.refresh();
    },
    async dataProvider(ctx) {

      try {
        let items = [];
        let meta = null;

        const resp = await this.$http.get('/api/v1/' + this.resourceName, {
            params: {
              page: ctx.currentPage,
              limit: ctx.perPage
            }
          });

        items = resp.data.data[this.resourceName].data;
        meta = resp.data.data[this.resourceName].pagination;


        this.currentPage = meta.current_page;
        this.perPage = meta.per_page;
        this.totalRows = meta.total;


        return items;

      } catch (e) {
        console.error(e);
        return [];
      }
    }
  }
};
</script>
<style lang="scss" scoped>
  .card {
    border: none;
  }
  table.b-table[aria-busy="true"] {
    opacity: 0.4;
  }

  #resource-table {
    th {
      &:focus {
        outline: none !important;
      }
    }
  }

  .fade-in-enter-active {
    animation: fade-in-bottom 3s;
  }
  .fade-in-leave-active {
    animation: fade-in-bottom 3s reverse;
  }
  @keyframes fade-in-bottom {
    from {
      opacity: 0;
      transform: translateY(100%);
    }
    to {
      opacity: 1;
    }
  }

  .loading-bar {
    height: 2px;
    background-color: rgb(249, 251, 253);

    width: 100%;
    overflow: hidden;

    .loading-bar-value {
      width: 100%;
      height: 100%;
      background-color: rgb(0, 123, 255);
      animation: indeterminateAnimation 1s infinite linear;
      transform-origin: 0% 50%;
    }
  }

  @keyframes indeterminateAnimation {
    0% {
      transform: translateX(0) scaleX(0);
    }
    40% {
      transform: translateX(0) scaleX(0.4);
    }
    100% {
      transform: translateX(100%) scaleX(0.5);
    }
  }
</style>
