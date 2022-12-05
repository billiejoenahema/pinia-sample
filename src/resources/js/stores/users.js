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
    links() {
      return this.users.data?.meta?.links ?? [];
    },
  },
  actions: {
    async get(params) {
      try {
        this.users = await axios.get(`/api/user`, { params });
      } catch (err) {
        this.errors = err;
      }
    },
  },
});
