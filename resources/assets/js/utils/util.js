import { hasOneOf, forEach } from './tools';
import _ from 'underscore.string';

export const hasChild = (item) => {
  return item.children && item.children.length !== 0;
};

const showThisMenuEle = (item, access) => {
  if (item.meta && item.meta.access && item.meta.access.length) {
    return hasOneOf(item.meta.access, access);
  }

  return true;
};

export const formatNumber = (num) => {
  const floatNumber = parseFloat(num);
  return _.numberFormat(floatNumber, 0, ',', '.');
};

export const getMenuByRouter = (list) => {
  const res = [];
  forEach(list, item => {
    if (Number(item.meta.show) === 1 && Number(item.meta.menu) === 1) {
      const obj = {
        icon: (item.meta && item.meta.icon) || '',
        name: item.name,
        meta: item.meta
      };

      if (hasChild(item)) {
        obj.children = getMenuByRouter(item.children);
      }

      res.push(obj);
    }
  });

  return res;
};

export const currencyFormat = (value) => {
  if (!value) return 0;
  return Number(value).toLocaleString('de-DE');
};
