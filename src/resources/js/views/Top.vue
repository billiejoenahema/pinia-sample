<script setup>
import { computed, onMounted, reactive, ref } from "vue";
import { useRouter } from "vue-router";
import DataCount from "../components/DataCount.vue";
import Pagination from "../components/Pagination.vue";
import SortIcon from "../components/SortIcon.vue";
import { useConstsStore } from "../stores/consts";
import { useUsersStore } from "../stores/users";

const router = useRouter();
// storeを定義する
const store = useUsersStore();
const constsStore = useConstsStore();

// actionメソッドを実行する
onMounted(async () => {
  await store.get();
  await constsStore.getIfNeeded();
});
// gettersプロパティを呼び出す
const users = computed(() => store.data);
const links = computed(() => store.links);
const meta = computed(() => store.meta);
const activeSortKey = ref("id");
const prefectureFormOptions = computed(() => constsStore.prefectureFormOptions);
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
const moveToDetail = (id) => {
  router.push(`/users/${id}`);
};
const changePage = (page = null) => {
  if (page) {
    params.page = page;
    store.get(params);
  }
};
</script>

<template>
  <div class="d-flex justify-content-between">
    <h2>User List</h2>
    <div class="form-inline d-inline-flex my-2 my-lg-0">
      <select v-model="params.pref" class="form-control">
        <option v-for="(pref, index) in prefectureFormOptions" :key="index">
          {{ pref }}
        </option>
      </select>
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
      <tr class="sticky-top">
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
      <tr
        v-for="user in users"
        :id="user.id"
        @click="moveToDetail(user.id)"
        class="user-row"
      >
        <th scope="row">{{ user.name }}</th>
        <td>{{ user.email }}</td>
        <td>{{ user.phone }}</td>
        <td>{{ user.pref }}</td>
      </tr>
    </tbody>
  </table>
  <DataCount :meta="meta" />
  <Pagination :links="links" @change="changePage" />
</template>

<style>
.user-row {
  cursor: pointer;
}
.user-row:hover {
  opacity: 0.8;
}
</style>
