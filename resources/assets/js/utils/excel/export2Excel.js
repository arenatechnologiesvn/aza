import { json2excel } from 'js2excel';

export default function excelExport (name, exportData) {
  return new Promise((resolve, reject) => {
    try {
      json2excel({
        data: exportData,
        name: name
      });
      resolve();
    } catch (error) {
      reject(error);
    }
  });
}
