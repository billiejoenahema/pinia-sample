import { defineStore } from "pinia";

export const useUserStore = defineStore("user", {
  state: () => ({
    user: {},
    errors: {},
  }),
  getters: {
    data() {
      return this.user.data?.data ?? {};
    },
  },
  actions: {
    async get(id) {
      try {
        this.user = await axios.get(`/api/user/${id}`);
      } catch (err) {
        console.log(err ?? "");
        this.errors = err;
      }
    },
  },
});
