import request from '~/utils/request';

const CUSTOMER_REPORT_URL = '/api/report/customer/revenue';
const EMPLOYEE_REPORT_URL = '/api/report/employee/revenue';
const NONE_ORDER_REPORT_URL = '/api/report/customer/none_order';
const ACCESS_STATISTICAL_URL = '/api/report/customer/access_satistical';
const REVENUE_STATISTICAL_URL = '/api/report/revenue';
const EXCELLENT_EMPLOYEES_URL = 'api/report/employees/excellent';
const SOLD_WELL_PRODUCTS_URL = 'api/report/product/sold_well';

export function getCustomerRevenue (customerId, startDate, endDate) {
  return request({
    url: CUSTOMER_REPORT_URL,
    method: 'get',
    params: {
      customer_id: customerId,
      start_date: startDate,
      end_date: endDate
    }
  });
}

export function getEmployeeRevenue (employeeId, startDate, endDate) {
  return request({
    url: EMPLOYEE_REPORT_URL,
    method: 'get',
    params: {
      employee_id: employeeId,
      start_date: startDate,
      end_date: endDate
    }
  });
}

export function getNoneOrderCustomers () {
  return request({
    url: NONE_ORDER_REPORT_URL,
    method: 'get',
    params: {}
  });
}

export function getAcsessStatistical (customerId, startDate, endDate) {
  return request({
    url: ACCESS_STATISTICAL_URL,
    method: 'get',
    params: {
      customer_id: customerId,
      start_date: startDate,
      end_date: endDate
    }
  });
}

export function getRevenues (params) {
  return request({
    url: REVENUE_STATISTICAL_URL,
    method: 'get',
    params: params
  });
}

export function getExcellentEmployees () {
  return request({
    url: EXCELLENT_EMPLOYEES_URL,
    method: 'get',
    params: {}
  });
}

export function getSoldWellProducts () {
  return request({
    url: SOLD_WELL_PRODUCTS_URL,
    method: 'get',
    params: {}
  });
}
