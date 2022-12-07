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
    meta() {
      return {
        current_page: this.users.data?.meta?.current_page ?? 0,
        from: this.users.data?.meta?.from ?? 0,
        to: this.users.data?.meta?.to ?? 0,
        total: this.users.data?.meta?.total ?? 0,
        last_page: this.users.data?.meta?.last_page ?? 0,
      };
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
