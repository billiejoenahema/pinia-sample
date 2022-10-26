<script setup>
import { computed, onMounted } from "vue";
import { useUserStore } from "../stores/user";

// storeを定義する
const store = useUserStore();

// actionメソッドを実行する
onMounted(async () => {
  await store.get(1);
});
// gettersプロパティを呼び出す
const user = computed(() => store.data);
</script>

<template>
  <h3>Top Page</h3>
  <label>User Name</label>
  <div>{{ user.name }}</div>
  <input v-model="user.name" type="text" />
</template>
