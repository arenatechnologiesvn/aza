import { getCustomerRevenue, getEmployeeRevenue, getNoneOrderCustomers } from '~/api/report';

const report = {
  namespaced: true,

  state: {
    customerRevenue: [],
    employeeRevenue: [],
    noneOrderCustomers: []
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
    }
  }
};

export default report;
