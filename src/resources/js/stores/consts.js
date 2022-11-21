import { defineStore } from "pinia";

export const useConstsStore = defineStore("consts", {
  state: () => ({
    consts: {},
    errors: {},
  }),
  getters: {
    prefectureFormOptions(state) {
      return state.consts?.data?.PREFECTURES ?? [];
    },
  },
  actions: {
    async get() {
      try {
        this.consts = await axios.get(`/api/consts`);
      } catch (err) {
        this.errors = err;
      }
    },
    async getIfNeeded() {
      if (Object.keys(this.consts).length === 0) {
        try {
          this.consts = await axios.get(`/api/consts`);
        } catch (err) {
          this.errors = err;
        }
      }
    },
  },
});
import axios from "axios";

const state = {
  data: [],
  errors: {},
};

const getters = {
  data(state) {
    return state.data ?? [];
  },
  prefectureFormOptions(state) {
    return state.data.PREFECTURES ?? [];
  },
  prefectureTextValue: (state) => (id) => {
    const item = state.data.PREFECTURES?.find((v) => {
      return v.id == id;
    });
    return item?.name ?? "";
  },
};

const actions = {
  async get({ commit }) {
    await axios
      .get("/api/consts")
      .then((res) => {
        commit("setErrors", {});
        commit("setData", res.data);
      })
      .catch((err) => {
        commit("setErrors", err.message);
        commit("setData", {});
      });
  },
  async getIfNeeded({ dispatch, getters }) {
    if (getters.isLogin) return;
    await dispatch("get");
  },
};

const mutations = {
  setData(state, data) {
    state.data = data;
  },
  setErrors(state, data) {
    state.errors = {};
    state.errors = data;
  },
};

export default {
  namespaced: true,
  state,
  getters,
  actions,
  mutations,
};
