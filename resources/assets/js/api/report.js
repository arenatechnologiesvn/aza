import request from '~/utils/request';

const CUSTOMER_REPORT_URL = '/api/report/customer/revenue';
const EMPLOYEE_REPORT_URL = '/api/report/employee/revenue';
const NONE_ORDER_REPORT_URL = '/api/report/customer/none_order';
const ACCESS_STATISTICAL_URL = '/api/report/customer/access_satistical';

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
