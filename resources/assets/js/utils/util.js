import { hasOneOf, forEach } from './tools';

export const hasChild = (item) => {
  return item.children && item.children.length !== 0;
};

const showThisMenuEle = (item, access) => {
  if (item.meta && item.meta.access && item.meta.access.length) {
    return hasOneOf(item.meta.access, access);
  }

  return true;
};

export const getMenuByRouter = (list, access) => {
  const res = [];
  forEach(list, item => {
    if (!item.hidden) {
      const obj = {
        icon: (item.meta && item.meta.icon) || '',
        name: item.name,
        meta: item.meta
      };

      if (hasChild(item) && showThisMenuEle(item, access)) {
        obj.children = getMenuByRouter(item.children, access);
      }

      if (showThisMenuEle(item, access)) res.push(obj);
    }
  });

  return res;
};
