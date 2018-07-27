import {
  getCustomerRevenue,
  getEmployeeRevenue,
  getNoneOrderCustomers,
  getAcsessStatistical,
  getRevenues,
  getExcellentEmployees,
  getSoldWellProducts
} from '~/api/report';

const report = {
  namespaced: true,

  state: {
    customerRevenue: [],
    employeeRevenue: [],
    noneOrderCustomers: [],
    accessStatistical: [],
    monthRevenues: [],
    yearRevenues: [],
    excellentEmployees: [],
    soldWellProducts: []
  },

  getters: {
    customerRevenue: (state) => {
      return state.customerRevenue;
    },

    employeeRevenue: (state) => {
      return state.employeeRevenue;
    },

    noneOrderCustomers: (state) => {
      return state.noneOrderCustomers;
    },

    accessStatistical: (state) => {
      return state.accessStatistical;
    },

    monthRevenues: (state) => {
      return state.monthRevenues;
    },

    yearRevenues: (state) => {
      return state.yearRevenues;
    },

    excellentEmployees: (state) => {
      return state.excellentEmployees;
    },

    soldWellProducts: (state) => {
      return state.soldWellProducts;
    }
  },

  mutations: {
    SET_CUSTOMER_REVENUE: (state, customerRevenue) => {
      state.customerRevenue = customerRevenue;
    },

    SET_EMPLOYEE_REVENUE: (state, employeeRevenue) => {
      state.employeeRevenue = employeeRevenue;
    },

    SET_NONE_ORDER_CUSTOMERS: (state, customers) => {
      state.noneOrderCustomers = customers;
    },

    SET_ACCESS_STATISTICAL: (state, accessStatistical) => {
      state.accessStatistical = accessStatistical;
    },

    SET_MONTH_REVENUES: (state, monthRevenues) => {
      state.monthRevenues = monthRevenues;
    },

    SET_YEAR_REVENUES: (state, yearRevenues) => {
      state.yearRevenues = yearRevenues;
    },

    SET_EXCELLENT_EMPLOYEES: (state, employees) => {
      state.excellentEmployees = employees;
    },

    SET_SOLD_WELL_PRODUCTS: (state, products) => {
      state.soldWellProducts = products;
    }
  },

  actions: {
    fetchCustomerRevenue ({ commit }, { customerId, startDate, endDate }) {
      return new Promise((resolve, reject) => {
        getCustomerRevenue(customerId, startDate, endDate).then(response => {
          const data = response.data;
          commit('SET_CUSTOMER_REVENUE', data);

          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    fetchEmployeeRevenue ({ commit }, { employeeId, startDate, endDate }) {
      return new Promise((resolve, reject) => {
        getEmployeeRevenue(employeeId, startDate, endDate).then(response => {
          const data = response.data;
          commit('SET_EMPLOYEE_REVENUE', data);

          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    fetchNoneOrderCustomers ({ commit }) {
      return new Promise((resolve, reject) => {
        getNoneOrderCustomers().then(response => {
          const data = response.data;
          commit('SET_NONE_ORDER_CUSTOMERS', data);

          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    fetchCustomerAccessStatistical ({ commit }, { customerId, startDate, endDate }) {
      return new Promise((resolve, reject) => {
        getAcsessStatistical(customerId, startDate, endDate).then(response => {
          const data = response.data;
          commit('SET_ACCESS_STATISTICAL', data);

          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    fetchRevenues ({ commit }, params) {
      return new Promise((resolve, reject) => {
        getRevenues(params).then(response => {
          const data = response.data;

          if (params.type === 'month') {
            commit('SET_MONTH_REVENUES', data);
          } else {
            commit('SET_YEAR_REVENUES', data);
          }

          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    fetchExcellentEmployees ({ commit }) {
      return new Promise((resolve, reject) => {
        getExcellentEmployees().then(response => {
          const data = response.data;
          commit('SET_EXCELLENT_EMPLOYEES', data);

          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    },

    fetchSoldWellProductss ({ commit }) {
      return new Promise((resolve, reject) => {
        getSoldWellProducts().then(response => {
          const data = response.data;
          commit('SET_SOLD_WELL_PRODUCTS', data);

          resolve();
        }).catch(error => {
          reject(error);
        });
      });
    }
  }
};

export default report;
