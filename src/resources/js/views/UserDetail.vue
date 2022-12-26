<script setup>
import { computed, onMounted, onUnmounted, ref } from "vue";
import { useRouter } from "vue-router";
import { useConstsStore } from "../stores/consts";
import { useUserStore } from "../stores/user";

const props = defineProps({
  id: {
    type: String,
    required: true,
    default: null,
  },
});
const router = useRouter();
const store = useUserStore();
const constsStore = useConstsStore();

onMounted(async () => {
  await store.get(router.currentRoute.value?.params?.id);
  await constsStore.getIfNeeded();
});
const user = computed(() => store.data);
const showInputType = ref(false);
const backToIndex = () => {
  router.push(`/`);
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
      <p>birth_date: {{ user.birth_date }}</p>
      <p>email: {{ user.email }}</p>
      <p>phone: {{ user.phone }}</p>
      <p>address: {{ user.address }}</p>
      <p>remarks: {{ user.remarks }}</p>
      <p>updated_at: {{ user.updated_at }}</p>
    </div>
  </div>
  <input v-if="showInputType" type="file" accept=".jpg,.jpeg,.png,.svg" />
  <button v-else @click="showInputType = !showInputType">変更する</button>
</template>

<style>
.avatar > img {
  height: 160px;
}
</style>
