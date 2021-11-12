import Vue from 'vue';
import axios from 'axios';

const api = axios.create({
  baseURL: process.env.API_URL || 'https://appetiser-api.tk/',
});

export default () => {
  // for use inside Vue files (Options API) through this.$axios and this.$api
  Vue.prototype.$axios = axios;
  // ^ ^ ^ this will allow you to use this.$axios (for Vue Options API form)
  //       so you won't necessarily have to import axios in each vue file

  Vue.prototype.$api = api;
  // ^ ^ ^ this will allow you to use this.$api (for Vue Options API form)
  //       so you can easily perform requests against your app's API
};

export {
  axios,
  api,
};
