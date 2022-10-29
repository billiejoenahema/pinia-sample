<script setup>
import { computed, onMounted } from "vue";
import { useUsersStore } from "../stores/users";

// storeを定義する
const store = useUsersStore();

// actionメソッドを実行する
onMounted(async () => {
  await store.get();
});
// gettersプロパティを呼び出す
const users = computed(() => store.data);
</script>

<template>
  <h2>User List</h2>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr>
        <th scope="col">name</th>
        <th scope="col">email</th>
        <th scope="col">phone</th>
        <th scope="col">pref</th>
      </tr>
    </thead>
    <tbody>
      <tr v-for="user in users" :id="user.id">
        <th scope="row">{{ user.name }}</th>
        <td>{{ user.email }}</td>
        <td>{{ user.phone }}</td>
        <td>{{ user.pref }}</td>
      </tr>
    </tbody>
  </table>
</template>
