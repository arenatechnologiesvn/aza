import { json2excel } from 'js2excel';
import moment from 'moment';

export default function excelExport (exportData) {
  return new Promise((resolve, reject) => {
    try {
      json2excel({
        data: exportData,
        name: 'DSSP_' + moment().format('ssmmhh_DDMMYYYY')
      });
      resolve();
    } catch (error) {
      reject(error);
    }
  });
}
