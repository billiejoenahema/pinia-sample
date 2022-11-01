import { defineStore } from "pinia";

export const useUsersStore = defineStore("users", {
  state: () => ({
    users: [],
    errors: {},
  }),
  getters: {
    data() {
      return this.users.data?.data ?? {};
    },
  },
  actions: {
    async get(params) {
      console.log(params);
      try {
        this.users = await axios.get(`/api/user`, { params });
      } catch (err) {
        this.errors = err;
      }
    },
  },
});
