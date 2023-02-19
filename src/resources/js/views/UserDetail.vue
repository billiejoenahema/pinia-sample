<script setup>
import { computed, onMounted, onUnmounted } from "vue";
import { useRouter } from "vue-router";
import { useConstsStore } from "../stores/consts";
import { useUserStore } from "../stores/user";

const router = useRouter();
const store = useUserStore();
const constsStore = useConstsStore();
const userId = router.currentRoute.value?.params?.id;

onMounted(async () => {
  await store.get(userId);
  await constsStore.getIfNeeded();
});
const user = computed(() => store.data);
const backToIndex = () => {
  router.push(`/`);
};
const moveToEdit = () => {
  router.push(`/users/${userId}/edit`);
};
onUnmounted(() => {
  store.user = {};
});
</script>

<template>
  <ul class="nav">
    <li class="nav-item">
      <a class="nav-link" href="#" @click.prevent="backToIndex()">back</a>
    </li>
  </ul>
  <div class="h3">User Detail</div>
  <div class="card">
    <div class="card-body">
      <p class="avatar">
        <img :src="user.avatar" hight="80" />
      </p>
      <p>id: {{ user.id }}</p>
      <p>user_name: {{ user.name }}</p>
      <p>kana_name: {{ user.kana_name }}</p>
      <p>birth_date: {{ user.formatted_birth_date }}</p>
      <p>email: {{ user.email }}</p>
      <p>phone: {{ user.phone }}</p>
      <p>address: {{ user.address }}</p>
      <p>remarks: {{ user.remarks }}</p>
      <p>updated_at: {{ user.updated_at }}</p>
    </div>
  </div>
  <button class="btn btn-primary m-2" type="button" @click="moveToEdit()">
    編集
  </button>
</template>

<style>
.avatar > img {
  height: 160px;
}
</style>
