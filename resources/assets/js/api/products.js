import p1 from '~/assets/products/p/p1.jpg';
import p2 from '~/assets/products/p/p2.jpg';
import p3 from '~/assets/products/p/p3.jpg';
import p4 from '~/assets/products/p/p4.jpg';
import n1 from '~/assets/products/n/n1.jpg';
import n2 from '~/assets/products/n/n2.jpg';
import n3 from '~/assets/products/n/n3.jpg';
import n4 from '~/assets/products/n/n4.jpg';
import c1 from '~/assets/products/c/c1.jpg';
import c2 from '~/assets/products/c/c2.jpg';
import c3 from '~/assets/products/c/c3.jpg';
import c4 from '~/assets/products/c/c4.jpg';
import { all } from '~/api/favorite';
import * as cart from '~/api/cart';
import request from '~/utils/request';

const products = [
  {
    id: 1,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: p1,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 10,
    added: false,
    favorite: false
  },
  {
    id: 2,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: p2,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 20,
    added: false,
    favorite: false
  },
  {
    id: 3,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: p3,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 10,
    added: false,
    favorite: false
  },
  {
    id: 4,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: p4,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 25,
    added: false,
    favorite: false
  },
  {
    id: 5,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: n1,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 25,
    added: false,
    favorite: false
  },
  {
    id: 6,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: n2,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 25,
    added: false,
    favorite: false
  },
  {
    id: 7,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: n3,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 25,
    added: false,
    favorite: false
  },
  {
    id: 8,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: n4,
    category: 'TRÁI CÂY',
    price: 30000,
    discount: 45000,
    inventory: 25,
    added: false,
    favorite: false
  },
  {
    id: 9,
    title: 'Cà chua thượng hạng Nhật Bản, tự nhiên không chất bảo quản',
    img: c1,
    category: 'THỰC PHẨM',
    price: 30000,
    discount: 45000,
    inventory: 10,
    added: false,
    favorite: false
  }
];
export const getProducts = () => {
  return new Promise(resolve => {
    all().then(data => {
      cart.all().then(data2 => {
        request({
          url: '/api/products',
          method: 'get'
        }).then(res => {
          const products = res.data;
          let p = products.map(item => {
            let favorite = false;
            let incart = false;
            if (data.indexOf(item.id) > 0) {
              favorite = true;
            }
            if (Array.isArray(data2) && data2.filter(c => c.id == item.id).length > 0) {
              incart = true;
            }
            return {
              id: item.id,
              title: item.name,
              img: item.featured_image.url,
              category: item.category ? item.category.name : 'Chưa xác định',
              price: item.price,
              discount: item.discount_price || item.price,
              inventory: 10,
              added: incart,
              favorite: favorite,
              description: item.description
            };
          });
          resolve(p);
        });
      });
    });
  });
};

export const getProductById = (id) => {
  return new Promise(resolve => {
    const byId = products.find(p => p.id == id)
    setTimeout(() => resolve(byId), 1000);
  });
};
