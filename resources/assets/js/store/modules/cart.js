import createCrudModule from './crud';
export default createCrudModule({
  resource: 'carts',
  idAttribute: 'product_id',
  getters: {
    cartProducts: (state, getters, rootState) => () => {
      return state.list.map((id) => {
        const index = rootState.products.list.find(p => p === state.entities[id].product_id.toString());
        const p = rootState.products.entities[index];
        const img = p.featured && `/${p.featured[0].directory}/${p.featured[0].filename}.${p.featured[0].extension}`;
        console.log(p);
        return {
          id,
          title: p.name,
          price: p.price,
          img: img,
          provider: p.provider && p.provider.name,
          quantity: state.entities[id].quantity,
          real_price: p.price,
          tmp_price: p.price,
          product_id: id
        };
      });
    }
  }
});
