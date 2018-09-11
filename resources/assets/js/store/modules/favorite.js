import createCrudModule from './crud';
export default createCrudModule({
  resource: 'favorites',
  idAttribute: 'product_id',
  getters: {
    favoriteProducts: (state, getters, rootState) => state.list.map((id) => {
      const index = rootState.products.list.find(p => p === state.entities[id].product_id.toString());
      const p = rootState.products.entities[index];
      const img = p && p.featured && p.featured[0] && p.featured[0].url;
      console.log(p)
      return p && {
        id,
        title: p.name,
        price: p.price,
        discount: p.discount_price,
        unit: p.unit,
        quantitative: p.quantitative,
        img: img,
        added: p.customer_carts && p.customer_carts.length > 0,
        provider: p.provider && p.provider.name,
        product_id: id
      } || {};
    })
  }
});
