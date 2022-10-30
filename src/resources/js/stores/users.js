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
    async get() {
      try {
        this.users = await axios.get(`/api/user`);
      } catch (err) {
        this.errors = err;
      }
    },
  },
});
