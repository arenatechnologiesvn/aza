export const forEach = (arr, fn) => {
  if (!arr.length || !fn) return
  let i = -1
  const len = arr.length
  while (++i < len) {
    const item = arr[i]
    fn(item, i, arr)
  }
}

export const getIntersection = (arr1, arr2) => {
  return Array.from(new Set([...arr1, ...arr2]))
}

export const hasOneOf = (target, arr) => {
  if (Array.isArray(target)) {
    return target.some(_ => arr.indexOf(_) > -1)
  }
  return arr.indexOf(target) > -1
}
