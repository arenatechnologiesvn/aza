export function filterObject (orginObjects, code) {
  let tempObjects = Object.keys(orginObjects).map((index) => {
    return orginObjects[index];
  });

  tempObjects = tempObjects.filter((item) => {
    return item.parent_code === code;
  }) || [];

  if (tempObjects.length) {
    tempObjects.sort((a, b) => {
      const nameA = a.name_with_type.toUpperCase();
      const nameB = b.name_with_type.toUpperCase();
      if (nameA < nameB) {
        return -1;
      }
      if (nameA > nameB) {
        return 1;
      }

      return 0;
    });
  }

  return tempObjects;
}
