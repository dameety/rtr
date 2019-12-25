import * as types from "@/store/constant";
import axios from "axios";

const state = {
  token: sessionStorage.getItem("userToken") || "",
  user: sessionStorage.getItem("userDetails") || ""
};

const getters = {
  currentAuthUser: state => {
    let user;
    if (state["user"]) {
      user = JSON.parse(state.user);
    } else {
      user = JSON.parse(sessionStorage.getItem("userDetails"));
    }
    return user;
  },

  userIsAdmin: (state, x, y) => {
    if (state["user"]) {
      return x.currentAuthUser.role === 'admin';
    }
  },

  userIsCustomer: (state, x, y) => {
    if (state["user"]) {
      return x.currentAuthUser.role === 'customer';
    }
  },

  userIsDriver: (state, x, y) => {
    if (state["user"]) {
      return x.currentAuthUser.role === 'driver';
    }
  },

  userIsAuthenticated: state => {
    return state["user"];
  }
};

const mutations = {
  [types.USER_DETAILS]: (state, user) => {
    state.user = user;
  },
  [types.AUTH_LOGOUT]: state => {
    state.token = "";
    state.user = {};
  }
};

const actions = {
  [types.LOGIN_REQUEST]: ({ commit }, user) => {
    return new Promise((resolve, reject) => {
      axios
        .post([types.LOGIN_API], user)
        .then(resp => {

          const token = resp.data.data.access_token;
          const userData = resp.data.data.user;
          sessionStorage.setItem("userToken", token);
          sessionStorage.setItem("userDetails", JSON.stringify(userData));

          commit(types.USER_DETAILS, JSON.stringify(userData));
          resolve(resp);
        })
        .catch(err => {
          sessionStorage.removeItem("userToken");
          sessionStorage.removeItem("userDetails");
          reject(err);
        });
    });
  },

  [types.REGISTER_REQUEST]: ({ commit }, user) => {
    return new Promise((resolve, reject) => {
      axios
        .post([types.REGISTER_API], user)
        .then(resp => {

          const token = resp.data.data.access_token;
          const userData = resp.data.data.user;
          sessionStorage.setItem("userToken", token);
          sessionStorage.setItem("userDetails", JSON.stringify(userData));

          commit(types.USER_DETAILS, JSON.stringify(userData));
          resolve(resp);
        })
        .catch(err => {
          sessionStorage.removeItem("userToken");
          sessionStorage.removeItem("userDetails");
          reject(err);
        });
    });
  },

  [types.AUTH_LOGOUT]: ({ commit }) => {
    return new Promise(resolve => {
      commit(types.AUTH_LOGOUT);

      sessionStorage.removeItem("userToken");
      sessionStorage.removeItem("userDetails");

      resolve();
    });
  }
};

export default {
  state,
  getters,
  mutations,
  actions
};
