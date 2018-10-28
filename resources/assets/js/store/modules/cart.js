import createCrudModule from './crud';
import dummyImage from '~/assets/login_images/dummy-image.jpg';

export default createCrudModule({
  resource: 'carts',
  idAttribute: 'product_id',
  getters: {
    cartProducts: (state, getters, rootState) => () => {
      return state.list.map((id) => {
        const index = rootState.products.list.find(p => p === state.entities[id].product_id.toString());
        const p = rootState.products.entities[index];
        const img = (p && p.featured && p.featured[0] && p.featured[0].url) || dummyImage;
        return p && {
          id,
          title: p.name,
          price: p.price,
          img: img,
          provider: p.provider && p.provider.name,
          quantity: state.entities[id].quantity,
          unit: p.unit,
          quantitative: p.quantitative,
          real_price: p.price,
          tmp_price: p.price,
          product_id: id
        } || {};
      });
    },
    getQuantityById: (state) => (id) => {
      return state.entities[id.toString()].quantity;
    }
  }
});
