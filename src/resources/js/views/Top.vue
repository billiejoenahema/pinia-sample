<script setup>
import { onMounted, reactive, ref } from "vue";
import { useUserStore } from "../stores/user";

// store を定義する
const store = useUserStore();
const loading = ref(false);
const userInfo = reactive({
  name: null,
  email: null,
  phone: null,
  zipcode: null,
  pref: null,
  city: null,
  street: null,
});
onMounted(async () => {
  // actionメソッドを実行する
  loading.value = true;
  await store.get(1);
  loading.value = false;
  Object.assign(userInfo, store.data);
});
</script>

<template>
  <h3>Top Page</h3>
  <form v-if="!loading">
    <label>User Name</label>
    <input v-model="userInfo.name" type="text" />
  </form>
  <div v-else>loading...</div>
</template>
