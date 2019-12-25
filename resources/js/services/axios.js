import axios from "axios"


axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';

const token = sessionStorage.getItem("userToken");
console.log('token is', token);
if (token) {
  axios.defaults.headers.common["Authorization"] = "Bearer " + token;
} else {
  axios.defaults.headers.common["Authorization"] = null;
}

export default axios;
