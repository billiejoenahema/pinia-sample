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
  search_column: "name",
  search_word: "",
  sort: "",
  ascending: true,
};
const params = reactive({
  ...defaultParams,
  page: 1,
});
// 入力欄でEnterを押したときの挙動
const onKeyDownEnter = (event) => {
  // 文字変換中なら何もしない
  if (event.isComposing || event.keyCode === 229) return;
  // 文字変換中でなければ検索を実行する
  store.get(params);
};
const searchColumns = ["name", "email", "phone", "pref"];
const search = () => {
  store.get(params);
};
</script>

<template>
  <div class="d-flex justify-content-between">
    <h2>User List</h2>
    <div class="form-inline d-inline-flex my-2 my-lg-0">
      <select v-model="params.search_column" class="form-control">
        <option v-for="column in searchColumns" :id="column">
          {{ column }}
        </option>
      </select>
      <input
        v-model="params.search_word"
        class="form-control mr-sm-2"
        type="search"
        placeholder="Search"
        aria-label="Search"
        @keydown.enter="onKeyDownEnter($event)"
      />
      <button
        class="btn btn-outline-success my-2 my-sm-0"
        type="button"
        @click="search()"
      >
        Search
      </button>
    </div>
  </div>
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
