<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import SortIcon from "../components/SortIcon.vue";
import { useUsersStore } from "../stores/users";

// storeを定義する
const store = useUsersStore();

// actionメソッドを実行する
onMounted(async () => {
  await store.get();
});
// gettersプロパティを呼び出す
const users = computed(() => store.data);
const activeSortKey = ref("id");
const sort = (sortValue) => {
  activeSortKey.value = sortValue;
  if (params.sort.includes(sortValue)) {
    params.ascending = !params.ascending;
  } else {
    params.ascending = true;
    Object.assign(params, { ...defaultParams });
    params.sort = sortValue;
  }
  store.get(params);
};
const defaultParams = {
  name: "",
  email: "",
  phone: "",
  pref: "",
  sort: "",
  ascending: true,
};
const params = reactive({
  ...defaultParams,
  page: 1,
});
</script>

<template>
  <h2>User List</h2>
  <table class="table table-striped">
    <thead class="table-dark">
      <tr>
        <th scope="col" @click="sort('name')">
          name
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'name'"
          />
        </th>
        <th scope="col" @click="sort('email')">
          email
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'email'"
          />
        </th>
        <th scope="col" @click="sort('phone')">
          phone
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'phone'"
          />
        </th>
        <th scope="col" @click="sort('pref')">
          pref
          <SortIcon
            :ascending="params.ascending"
            :active-sort-key="activeSortKey"
            :label="'pref'"
          />
        </th>
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
